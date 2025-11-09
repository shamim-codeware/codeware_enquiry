<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShowRoom;
use App\Models\User;
use App\Models\Enquery;
use App\Models\FollowUp;
use App\Models\Setting;
use App\Models\Zone;
use App\Models\EnquirySource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    /**
     * Display dashbnoard demo one of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $enquiry_status = @Setting::first()->enquiry_status;
        $today = now()->format('Y-m-d');
        $startOfMonth = now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d');
        $title = "Dashboard";
        $new_close_status = array_diff($enquiry_status['close'], [$enquiry_status['sale']]);
        $pending_status   = isset($enquiry_status['pending'])? $enquiry_status['pending']: [];
        $firstDayLastMonth = date('Y-m-d 00:00:00', strtotime("first day of last month"));
        // Calculate the last day of the last month
        $lastDayLastMonth = date('Y-m-d 23:59:59', strtotime("last day of last month"));
        $previousDate = date('Y-m-d', strtotime(now()->format('Y-m-d') . ' -1 day'));
        $zones = Zone::orderBy('name','ASC')->get();
        $description = "Some description for the page";
        $countData['countshowrooms'] = ShowRoom::count();

        $countexecutive = User::where('role_id',2)->where('is_active',1);
        $countmanager = User::where('role_id',3)->where('is_active',1);
         $counttodayenquery = Enquery::whereDate('created_at', $today);

         $lastfiveenquiry = Enquery::orderBy('id','DESC');
         $counttpreviousenquery = Enquery::whereDate('created_at', $previousDate);

        $counttodayfollowup = FollowUp::with('enquiry')->whereBetween("next_follow_up_date",  [now()->format('Y-m-d H:i:00'), now()->format('Y-m-d 23:59:00')])->where('status', 0);
        $countpreviousfollowup = FollowUp::whereDate('next_follow_up_date', $previousDate);

        $counttodaylastmonth = Enquery::whereBetween('created_at', [$firstDayLastMonth, $lastDayLastMonth]);
        $passedfollowup = Enquery::where('next_follow_up_date', '<', now())->where('enquiry_status',$enquiry_status['open']);

        $passedpreviousfollowup = Enquery::where('next_follow_up_date', '<', $previousDate)->where('enquiry_status',$enquiry_status['open'])->where('status',1);
        
        $total =  Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $open =   Enquery::where('enquiry_status',$enquiry_status['open'])
                 ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $close =   Enquery::whereIn('enquiry_status',$new_close_status)
                 ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $sales =   Enquery::where('enquiry_status',@$enquiry_status['sale'])
                 ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $pending =   Enquery::whereIn('enquiry_status', $pending_status)
                 ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        //All Total Enquiry Total , Pending , Sale , Close , Open , 
        $total_all =  Enquery::orderBy('id','DESC');
        $open_all =   Enquery::where('enquiry_status', $enquiry_status['open']);
        $close_all =   Enquery::whereIn('enquiry_status', $new_close_status);
        $sales_all =   Enquery::where('enquiry_status', @$enquiry_status['sale']);
        $pending_all =   Enquery::whereIn('enquiry_status', $pending_status);
        $latestenquiry =  Enquery::orderBy('id', 'DESC')->take(5);

        if($request->Showroom){ 
            $Showroom = $request->Showroom;

            $latestenquiry->where('showroom_id', $request->Showroom);

            $countexecutive->where('showroom_id',$request->Showroom);
            $countmanager->where('showroom_id',$request->Showroom);
            $counttodayenquery->where('showroom_id',$request->Showroom);
            $lastfiveenquiry->where('showroom_id',$request->Showroom);
            $counttpreviousenquery->where('showroom_id',$request->Showroom);

            $counttodayfollowup->whereHas('enquiry', function ($enquiry) use ($Showroom){
                $enquiry->where('showroom_id', $Showroom);
                });

            $countpreviousfollowup->whereHas('enquiry', function ($enquiry) use ($Showroom){
                $enquiry->where('showroom_id', $Showroom);
            });
           $counttodaylastmonth->where('showroom_id',$request->Showroom);
           $passedfollowup->where('showroom_id',$request->Showroom);
           $passedpreviousfollowup->where('showroom_id',$request->Showroom);

           $total =  Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('showroom_id',$request->Showroom)->count();
           $open =   Enquery::where('enquiry_status',$enquiry_status['open'])
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('showroom_id',$request->Showroom)->count();
           $close =   Enquery::whereIn('enquiry_status',$new_close_status)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('showroom_id',$request->Showroom)->count();
           $sales =   Enquery::where('enquiry_status',$enquiry_status['sale'])
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('showroom_id',$request->Showroom)->count();
           $pending =   Enquery::whereIn('enquiry_status', $pending_status)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('showroom_id',$request->Showroom)->count();
            //All Total Enquiry Total , Pending , Sale , Close , Open , 
            $total_all =  $total_all->where('showroom_id', $request->Showroom);
            $open_all =   $open_all->where('showroom_id', $request->Showroom);
            $close_all =   $close_all->where('showroom_id',$request->Showroom);
            $sales_all =    $sales_all->where('showroom_id', $request->Showroom);
            $pending_all = $pending_all->where('showroom_id', $request->Showroom) ;
                    
        }

        if(Auth::user()->role_id == 2){
             $user_id = Auth::user()->id;
            $counttodayenquery->where('assign',$user_id);
            $counttpreviousenquery->where('assign',$user_id);
            $counttodayfollowup->whereHas('enquiry', function ($enquiry) use ($user_id){
                $enquiry->where('assign', $user_id);
                });
            $latestenquiry->where('assign', $user_id);
            $countpreviousfollowup->with(['enquiry' => function ($enquiry) use ($user_id) {
                $enquiry->where('assign', $user_id);}]);
            // dd($counttodayfollowup);
            $counttodaylastmonth->where('assign',$user_id);
            $passedfollowup->where('assign',$user_id);
            $passedpreviousfollowup->where('assign',$user_id);

            $total =  Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('assign',$user_id)->count();
            $open =   Enquery::where('enquiry_status',$enquiry_status['open'])
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('assign',$user_id)->count();
            $close =   Enquery::whereIn('enquiry_status',$new_close_status)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('assign',$user_id)->count();
            $sales =   Enquery::where('enquiry_status',$enquiry_status['sale'])
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('assign',$user_id)->count();

            $pending =   Enquery::whereIn('enquiry_status',$pending_status)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('assign',$user_id)->count();

           //All Total Enquiry Total , Pending , Sale , Close , Open , 

            $total_all =  $total_all->where('assign', $user_id);
            $open_all =   $open_all->where('assign', $user_id);
            $close_all =   $close_all->where('assign', $user_id);
            $sales_all =    $sales_all->where('assign', $user_id);
            $pending_all = $pending_all->where('assign', $user_id);         

        }elseif(Auth::user()->role_id == 3){
            $showroom_id = Auth::user()->showroom_id;
            $latestenquiry->where('showroom_id', $showroom_id);
           $counttodayenquery->where('showroom_id',$showroom_id);
           $counttpreviousenquery->where('showroom_id',$showroom_id);
            $counttodayfollowup->whereHas('enquiry', function ($enquiry) use ($showroom_id){
                $enquiry->where('showroom_id', $showroom_id);
                });

               // dd($counttodayfollowup->get());

            $countpreviousfollowup->with(['enquiry'=> function($enquiry) use ($showroom_id){ 
                $enquiry->where('show_room_id',$showroom_id);
            }]);
           $counttodaylastmonth->where('showroom_id',$showroom_id);
           $passedfollowup->where('showroom_id',$showroom_id);
           $passedpreviousfollowup->where('showroom_id',$showroom_id);

           $total =  Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('showroom_id',$showroom_id)->count();
           $open =   Enquery::where('enquiry_status',$enquiry_status['open'])
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('showroom_id',$showroom_id)->count();
           $close =   Enquery::whereIn('enquiry_status',$new_close_status)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('showroom_id',$showroom_id)->count();
           $sales =   Enquery::where('enquiry_status',$enquiry_status['sale'])
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('showroom_id',$showroom_id)->count();
        
           $pending =   Enquery::whereIn('enquiry_status', $pending_status)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('showroom_id',$showroom_id)->count();
            //All Total Enquiry Total , Pending , Sale , Close , Open , 

            $total_all =  $total_all->where('showroom_id', $showroom_id);
            $open_all =   $open_all->where('showroom_id', $showroom_id);
            $close_all =   $close_all->where('showroom_id', $showroom_id);
            $sales_all =    $sales_all->where('showroom_id', $showroom_id);
            $pending_all = $pending_all->where('showroom_id', $showroom_id);  
  
        }elseif((Auth::user()->role_id == 6) || (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8)){
            $created_by = Auth::user()->id;
            $counttodayenquery->where('created_by', $created_by);

            $latestenquiry->where('created_by', $created_by);
            $counttpreviousenquery->where('created_by', $created_by);
            $counttodayfollowup->whereHas('enquiry', function ($enquiry) use ($created_by) {
                $enquiry->where('created_by', $created_by);
            });

            $countpreviousfollowup->with(['enquiry' => function ($enquiry) use ($created_by) {
                $enquiry->where('created_by', $created_by);
            }]);
            $counttodaylastmonth->where('created_by', $created_by);
            $passedfollowup->where('created_by', $created_by);
            $passedpreviousfollowup->where('created_by', $created_by);
            $total =  Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('created_by', $created_by)->count();
            $open =   Enquery::where('enquiry_status', $enquiry_status['open'])
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('created_by', $created_by)->count();
            $close =   Enquery::whereIn('enquiry_status', $new_close_status)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('created_by', $created_by)->count();
            $sales =   Enquery::where('enquiry_status', $enquiry_status['sale'])
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('created_by', $created_by)->count();

            $pending =   Enquery::whereIn('enquiry_status', $pending_status)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('created_by', $created_by)->count();
            //All Total Enquiry Total , Pending , Sale , Close , Open , 

            $total_all =  $total_all->where('created_by', $created_by);
            $open_all =   $open_all->where('created_by', $created_by);
            $close_all =   $close_all->where('created_by', $created_by);
            $sales_all =    $sales_all->where('created_by', $created_by);
            $pending_all = $pending_all->where('created_by', $created_by);  

        }

        $total_all = $countData['total_all_cou'] =  $total_all->count();
        $open_all =  $countData['open_all_cou'] =  $open_all->count();
        $close_all = $countData['close_all_cou'] = $close_all->count();
        $pending_all = $countData['pending_all_cou'] = $pending_all->count();
        $sales_all  = $countData['sales_all_cou'] = $sales_all->count();

        if($total_all <= 0){
            $total_all = 1;
        }

        if ($total <= 0) {
            $total = 1;
        }

        $countData['countopen'] = number_format(($open / $total) * 100, 0);
        $countData['countclose'] = number_format(($close / $total) *  100 , 0);
        $countData['countsales'] = number_format(($sales / $total) * 100, 0);
        $countData['countpending'] = number_format(($pending / $total) * 100, 0);
    
        $enquiry_status['close'];
        $enquiry_status['open'];
        $enquiry_status['sale'];

        //All Total Enquiry Total , Pending , Sale , Close , Open , 
           
        $countData['total_all']   = number_format(($open_all / $total_all) * 100, 0);
        $countData['open_all']    = number_format(($open_all / $total_all) * 100, 0);
        $countData['close_all']   = number_format(($close_all / $total_all) *  100, 0);
        $countData['pending_all'] =  number_format(($pending_all / $total_all) * 100, 0);
        $countData['sales_all'] =  number_format(($sales_all / $total_all) * 100, 0);


        $countData['countexecutive'] =  $countexecutive->count();
        $countData['countmanager'] =    $countmanager->count();
        $countData['counttodayenquery'] = $counttodayenquery->count();
        $countData['counttpreviousenquery'] = $counttpreviousenquery->count();
       // dd( $countData['counttpreviousenquery']);
        $countData['todayenquirys'] = Enquery::orderBy('id','DESC')->take(5)->get();
        
        $countData['counttodayfollowup']  = $counttodayfollowup->count();
        $countData['countpreviousfollowup'] = $countpreviousfollowup->count();
        $countData['counttodaylastmonth'] = $counttodaylastmonth->count();
        $countData['passedfollowup'] =  $passedfollowup->count();
        $countData['passedpreviousfollowup'] =  $passedpreviousfollowup->count();

        $countData['total'] = $total ;

        $countData['request'] = $request->all();
        
        $enquery_source = EnquirySource::orderBy('id','ASC')->where('parent_id',0)->get();
        return view('pages.dashboard', compact('title','enquiry_status','lastDayLastMonth','firstDayLastMonth', 'description','countData','zones','enquery_source','firstDayLastMonth','lastDayLastMonth','open','sales','close','pending'));
    }

    public function SelectShowroom(Request $request){
       $showrooms = ShowRoom::where('zone_id',$request->parent_id)->get();
       return json_encode($showrooms);
    }

    public function EnquiryStatistics(Request $request)
    {
        $current_year = date('Y');
        $startOfMonth = $current_year . '-' . str_pad($request->month_source, 2, '0', STR_PAD_LEFT) . '-1';
        $endOfMonth = date('Y-m-t', strtotime($startOfMonth));
        $enquiry_status = @Setting::first()->enquiry_status;
        $new_close_status = array_diff($enquiry_status['close'], [$enquiry_status['sale']]);
        $pending_status   = isset($enquiry_status['pending']) ? $enquiry_status['pending'] : [];
        $total =  Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        $open =   Enquery::where('enquiry_status', $enquiry_status['open'])
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        $close =   Enquery::whereIn('enquiry_status', $new_close_status)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        $sales =   Enquery::where('enquiry_status', @$enquiry_status['sale'])
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        $pending =   Enquery::whereIn('enquiry_status', $pending_status)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);

        if ($request->Showroom) {
            $total->where('showroom_id', $request->Showroom);
            $open->where('showroom_id', $request->Showroom);
            $close->where('showroom_id', $request->Showroom);
            $sales->where('showroom_id', $request->Showroom);
            $pending->where('showroom_id', $request->Showroom);
        }
        if (Auth::user()->role_id == 2) {

            $user_id = Auth::user()->id;
            $total->where('assign', $user_id);
            $open->where('assign', $user_id);
            $close->where('assign', $user_id);
            $sales->where('assign', $user_id);
            $pending->where('assign', $user_id);
        } elseif (Auth::user()->role_id == 3) {

            $showroom_id = Auth::user()->showroom_id;
            $total->where('showroom_id', $showroom_id);
            $open->where('showroom_id', $showroom_id);
            $close->where('showroom_id', $showroom_id);
            $sales->where('showroom_id', $showroom_id);
            $pending->where('showroom_id', $showroom_id);
        } elseif ((Auth::user()->role_id == 6) || (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8)) {

            $created_by = Auth::user()->id;
            $total->where('created_by', $created_by);
            $open->where('created_by', $created_by);
            $close->where('created_by', $created_by);
            $sales->where('created_by', $created_by);
            $pending->where('created_by', $created_by);
        }

        $total = $total->count();
        $open = $open->count();
        $close = $close->count();
        $sales = $sales->count();
        $pending = $pending->count();

        if ($total <= 0) {
            $total = 1;
        }

        $countData['countopen'] = number_format(($open / $total) * 100, 0);
        $countData['countclose'] = number_format(($close / $total) *  100, 0);
        $countData['countsales'] = number_format(($sales / $total) * 100, 0);
        $countData['countpending'] = number_format(($pending / $total) * 100, 0);

        $start_date = $startOfMonth;
        $end_date  = $endOfMonth;

        return view('components.dashboard.enquirystatistic', compact('pending', 'sales', 'close', 'open', 'countData', 'start_date', 'end_date', 'total', 'enquiry_status'));
    }



    public function SourceStatistics(Request $request)
    {
        $current_year = date('Y');
        $startOfMonth = $current_year . '-' . str_pad($request->month_source, 2, '0', STR_PAD_LEFT) . '-01';
        $endOfMonth = date('Y-m-t', strtotime($startOfMonth));
        $status = 1;

        $enquiry_status = @Setting::first()->enquiry_status;
        $new_close_status = array_diff($enquiry_status['close'], [$enquiry_status['sale']]);
        $pending_status   = isset($enquiry_status['pending']) ? $enquiry_status['pending'] : [];

        $enquiry_sources = EnquirySource::where('parent_id', 0)->get();
       

        return view('components.dashboard.sourcewisecount', compact('enquiry_sources', 'endOfMonth', 'startOfMonth', 'pending_status', 'enquiry_status', 'new_close_status'));
    }

    public function TodaysfollowUp(Request $request){

        date_default_timezone_set('Asia/Dhaka');
        $today = now()->format('Y-m-d');
        $executive_id = Auth::user()->id;
        $showroom_id = Auth::user()->showroom_id;
        $todays_followup = FollowUp::with(['enquiry' => function ($enquiry) {
            $enquiry->with(['users', 'showroom']);
        }])->whereBetween("next_follow_up_date",  [now()->format('Y-m-d H:i:00'), now()->format('Y-m-d 23:59:00')])->where('status',0);

        if(Auth::user()->role_id == 2){
            $todays_followup->whereHas('enquiry', function ($enquiry) use ($executive_id){
                $enquiry->where('assign', $executive_id)->select('name');
                });
        }elseif(Auth::user()->role_id == 3){
            $todays_followup->whereHas('enquiry', function ($enquiry) use ($showroom_id){
                $enquiry->where('showroom_id', $showroom_id)->select('name');
                });
        } else if ((Auth::user()->role_id == 6) || (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8)) {
            
            $todays_followup->whereHas('enquiry', function ($enquiry) use ($showroom_id) {
                $enquiry->where('created_by', Auth::user()->id)->select('name');
            });
        }
        $data =  $todays_followup->get();
        $str  = '  ' ;
        foreach($data  as $row){

            $str.=$row->enquiry->name . '  Todays Follow Up Time  ' .date('h:i:s A', strtotime($row->next_follow_up_date)); if(Auth::user()->role_id == 1){ 
                 $str .= '('.$row->enquiry->showroom->name.')';
                }
                $str .= '  **      ';
        }
      
        return $str;

    }
}

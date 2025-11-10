<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Enquery;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\FollowUp;
use Illuminate\Http\Request;
use App\Models\EnquirySource;
use App\Imports\EnquiryImport;
use App\Models\EnquiryProduct;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import(Request $request)
    {

        date_default_timezone_set('Asia/Dhaka');


        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
        ]);

        $open_status    = 1;
        $array = Excel::toArray(new EnquiryImport, request()->file('file'));
        $ext = request()->file('file')->getClientOriginalExtension();
        //   dd($ext);
        if ($ext == "xlsx" || $ext == "csv") {

            // dd($array);

            $districtData = [];
            for ($i = 1; $i < count($array[0]); $i++) {
                $value = $array[0][$i];
                if ($value[1] != '') {
                    // $districtName = $value[2];
                    // if (!isset($districtData[$districtName])) {
                    //     $districtData[$districtName] = [];
                    // }
                    $dateValue = $value[2];
                    $dateTime = date_create_from_format('d-m-Y', $dateValue);
                    if ($dateTime !== false) {
                        $formattedDate = date_format($dateTime, 'Y-m-d');
                    } else {
                        $currentDateTime = new DateTime();
                        //  $nextDateTime = $currentDateTime->modify('+1 day');
                        $formattedDate = $currentDateTime->format('Y-m-d H:i:s');
                    }

                    $districtData[] = [
                        'column0' => $value[0],
                        'column1' => $value[1],
                        'column2' => $value[2],
                        'column3' => $value[3],
                        'column4' => $value[4],
                        'column5' => $value[5],
                        'column6' => $value[6],
                        'column7' => $value[7],
                        'column8' => $value[8],
                        // 'column9' => $value[9],

                    ];
                }
            }
            foreach ($districtData as $districtName => $row) {
                $currentShowroomIndex = 0;
                //create Customer
                $customer_create = DB::table('customers')->where('number', $row['column5'])->first();

                if ($customer_create != null) {
                    $customer_name = $customer_create->name;
                    $customer_number = $customer_create->number;
                    $customer_id =  $customer_create->id;
                } else {
                    $customer_name = $row['column4'];
                    $customer_number = (string) $row['column5'];


                    $data = [
                        'name' => $customer_name,
                        'number' => $customer_number,
                        'district_id'   => @$district->id
                        // ... add other columns and values as needed
                    ];
                    // dd($data);
                    $Customer =  new Customer;
                    $Customer->fill($data)->save();
                    $customer_id =  $Customer->id;
                }


                $last = Enquery::orderBy('id', 'DESC')->first();



                if (empty($last)) {
                    $next_id = 1;
                } else {
                    $next_id = $last->id + 1;
                }
                $event_code     = 'REM0000' . $next_id;

                // $customer_remarks = $row['column6'];

                $currentDateTime = new DateTime();
                //  $nextDateTime = $currentDateTime->modify('+1 day');
                $formattedNextDate = $currentDateTime->format('Y-m-d H:i:s');

                $createdat = $row['column2'];

                //                            $assign_exe = DB::table('users')->where('phone', $row['column8'])->first();
                $assign_exe = User::where('phone', "01676508343")->first();
                if ($assign_exe) {
                    $assign_by =  $assign_exe->id;
                } else {
                    $assign_by = NULL;
                }



                $Enquery                 = new Enquery;
                $Enquery->customer_id    = $customer_id;
                $Enquery->showroom_id    = 1;
                $Enquery->event_code     = $event_code;
                $Enquery->number         = (string) $row['column5'];
                $Enquery->name           = $customer_name;
                $Enquery->source_parent  = 33;
                $Enquery->source_child   = 34;
                $Enquery->next_follow_up_date  = $formattedNextDate;
                $Enquery->enquiry_status  = $open_status;
                $Enquery->created_by      = Auth::user()->id;
                //                            $Enquery->created_at      = $createdat;
                $Enquery->camp_id         = $row['column1'];
                $Enquery->assign          = $assign_by;

                $Enquery->company_name     = $row['column2'];
                $Enquery->employee_size  = $row['column3'];

                // return $Enquery;


                $Enquery->save();


                // $Enquery->fill($enquiryData)->save();

                $follwoupdata = [
                    'enquiry_id'   => $Enquery->id,
                    'name'         => $customer_name,
                    'event_code'   => $event_code,
                    'next_follow_up_date' => $formattedNextDate,
                    'status_parent' => $open_status
                ];

                $FollowUp = new FollowUp;
                $FollowUp->fill($follwoupdata)->save();

                $EnquiryProduct = Product::with(['types', 'categories'])->where('id', 51)->first();



                // if(!empty($EnquiryProduct)){
                if ($EnquiryProduct != null) {
                    $productData = [
                        'enquiry_id' => $Enquery->id,
                        'group_name' => @$EnquiryProduct->types->name,
                        'category_name' => @$EnquiryProduct->categories->name,
                        'product_name' => $EnquiryProduct->name,
                        'group_id'    => @$EnquiryProduct->type_id,
                        'category_id'  => @$EnquiryProduct->category_id,
                        'product_id'   => $EnquiryProduct->id
                    ];

                    EnquiryProduct::create($productData);
                    // }

                }
                // $currentShowroomIndex = ($currentShowroomIndex + 1) % $showroomCount;


                // } else {

                //     echo "No Showroom available for this district<br>";
                // }
                // }
                // } else {
                //     foreach ($data as $row) {
                //         echo "Column 1: " . $row['column1'] . "<br>";
                //         echo "Column 2: " . $row['column2'] . "<br>";
                //         echo "<br>";
                //     }
                // }
            }
        }


        return  redirect('enquiry')->with('success', 'Success! Import Successfully');

        //return back();
    }




    public function importIdeskAction(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $open_status    = @Setting::first()->enquiry_status['open'];
        $array = Excel::toArray(new EnquiryImport, request()->file('file'));
        $ext = request()->file('file')->getClientOriginalExtension();
        if ($ext == "xlsx" || $ext == "csv") {
            $dataRows = array_slice($array[0], 1);

            foreach ($dataRows as $row) {
                $showrooms = DB::table('show_rooms')->where('suffix', $row[2])->where('status', 1)->first();
                //create Customer

                if ($showrooms != null) {

                    $customer_create = DB::table('customers')->where('number', $row[4])->first();
                    if ($customer_create != null) {
                        $customer_name = $customer_create->name;
                        $customer_number = $customer_create->number;
                        $customer_id =  $customer_create->id;
                    } else {
                        $customer_name = $row[3];
                        $customer_number = $row[4];
                        $data = [
                            'name' => $customer_name,
                            'number' => $customer_number,
                            // ... add other columns and values as needed
                        ];
                        $Customer =  new Customer;
                        $Customer->fill($data)->save();
                        $customer_id =  $Customer->id;
                    }



                    $last = Enquery::orderBy('id', 'DESC')->first();

                    $source = EnquirySource::where('name', $row[6])->first();
                    $source_parent = 1;
                    if (@$source->parent_id == 0) {
                        $source_parent = @$source->id;
                    } else {
                        $source_parent = @$source->parent_id;
                    }

                    if (empty($last)) {
                        $next_id = 1;
                    } else {
                        $next_id = $last->id + 1;
                    }
                    $event_code     = 'EMS0000' . $next_id;

                    $customer_remarks = $row[7];

                    $currentDateTime = new DateTime();
                    $formattedNextDate = $currentDateTime->format('Y-m-d H:i:s');
                    $enquiryData = [
                        'customer_id' => $customer_id,
                        'showroom_id' => $showrooms->id,
                        'event_code'  => $event_code,
                        'number'      => $customer_number,
                        'name'        => $customer_name,
                        'source_parent' => $source_parent,
                        'source_child'  => @$source->id,
                        'purchase_mode' => 12,
                        'next_follow_up_date' => $formattedNextDate,
                        'enquiry_status' => $open_status,
                        'created_by' => Auth::user()->id,
                        'customer_remarks' => $customer_remarks,
                        'sales_date' => $formattedNextDate
                    ];
                    $Enquery = new Enquery;
                    $Enquery->fill($enquiryData)->save();

                    $follwoupdata = [
                        'enquiry_id'   => $Enquery->id,
                        'name'         => $customer_name,
                        'event_code'   => $event_code,
                        'next_follow_up_date' => $formattedNextDate,
                        'status_parent' => $open_status
                    ];

                    $FollowUp = new FollowUp;
                    $FollowUp->fill($follwoupdata)->save();

                    $EnquiryProduct = Product::with(['categories', 'types'])->where('name', $row[5])->first();
                    // if(!empty($EnquiryProduct)){
                    if ($EnquiryProduct != null) {
                        $productData = [
                            'enquiry_id' => $Enquery->id,
                            'group_name' => $EnquiryProduct->types->name,
                            'category_name' => $EnquiryProduct->categories->name,
                            'product_name' => $EnquiryProduct->name,
                            'group_id'    => $EnquiryProduct->type_id,
                            'category_id'  => $EnquiryProduct->category_id,
                            'product_id'   => $EnquiryProduct->id
                        ];
                        EnquiryProduct::create($productData);
                    }
                }
            }
        }

        return  redirect('enquiry')->with('success', 'Success! Import Successfully');
    }
}

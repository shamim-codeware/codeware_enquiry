<div class="col-xxl-12">
    <div class="row gx-2">
        <div class="col-lg-3  col-md-6">
            <div class="card mb-3">

                <div class="d-flex justify-content-between">
                    <div style="background-color: #FFA500"
                        class="p-2 d-flex align-items-center  box-header gap-3 align-items-center">
                        {{-- <span class="enquiry-icon-1"><i class="fas fa-info-circle"></i></span> --}}
                        <p class="m-0 fw-600 text-white">Open</p>
                    </div>

                     <div class="card-box-value  px-2 py-3 gap-1">
                        <h2 class="fs-36px lh-36px">{{ $countData['open_all_cou'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card mb-3">
                <div class="d-flex justify-content-between">
                    <div style="background-color: #008000" class="d-flex p-2 box-header gap-3 align-items-center">
                        <p class="m-0 fw-600 text-white">Sales</p>
                    </div>
                    <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                        <h2 class="fs-36px lh-36px">{{ $countData['sales_all_cou'] }}</h2>
                    </div>
                                       
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card mb-3">
                <div class="d-flex justify-content-between">
                    <div style="background-color: #FFB078" class="d-flex p-2 box-header gap-3 align-items-center">
                        <p class="m-0 fw-600 text-white">Pending</p>
                    </div>
                    <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                        <h2 class="fs-36px lh-36px">{{ $countData['pending_all_cou'] }}</h2>
                        
                    </div>
                       
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card mb-3">
                <div class="d-flex justify-content-between">
                    <div style="background-color: #FF0000" class="d-flex p-2 box-header gap-3 align-items-center">
                        <p class="m-0 fw-600 text-white">Close</p>
                    </div>
                    <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                        <h2 class="fs-36px lh-36px">{{ $countData['close_all_cou'] }}</h2>
                    </div>            
                </div>
            </div>
        </div>
    </div>


    <div class="row gx-2">
        <div class="col-md-6">
            {{-- Total’s Enquiry  --}}
            <div class="col-lg-12 mb-4">
                <div class="card box-height">
                    {{-- <div class="card-header">
                                Current Month Conversion Rate
                               </div> --}}
                    <div class="card-body p-3" dir="ltr">

                        <div class="row gx-3">
                            <div class="col-lg-6 mb-3">
                                @php
                                    $current_date = date('d-m-Y');
                                    $start_date = date('1-m-y');
                                    $end_date = date('t-m-Y');

                                    // dd($end_date);
                                    $lastdate = explode('-', $end_date);
                                    $alldate = [];
                                    $num = [];
                                    for ($i = 01; $i <= $lastdate[0]; $i++) {
                                        $alldate[] = date('Y-m-' . $i);
                                        $num[] = "$i";
                                    }

                                @endphp
                                <a
                                    href="{{ url('/enquiry?from_date=' . $current_date . '&to_date=' . $current_date . '&date_type=2' . '&showroom_id=' . request('Showroom') . '&zone_id=' . request('zone')) }}">
                                    <div class="card">
                                        <div class="d-flex p-2 box-header gap-3 align-items-center">
                                            <span class="enquiry-icon-1"><i class="fas fa-info-circle"></i></span>
                                            <p class="m-0 fw-600">Today’s Enquiry</p>
                                        </div>
                                        <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                                            <h2 class="fs-36px lh-36px">{{ $countData['counttodayenquery'] }}</h2>
                                            <span
                                                class="@if ($countData['counttodayenquery'] > $countData['counttpreviousenquery']) color-positive @else color-negative @endif "><i
                                                    class="fas  @if ($countData['counttodayenquery'] > $countData['counttpreviousenquery']) fa-arrow-up @else fa-arrow-down @endif"></i></span>
                                            {{-- <p class="m-0 color-positive fw-500">64.4%</p> --}}
                                        </div>
                                    </div>
                                </a>
                                {{-- href="{{ url('/enquiry?from_date=' . $current_date . '&to_date=' . $current_date . '&date_type=2') }}">
                                                <h2>{{ $countData['counttodayenquery'] }}</h2>
                                                <p class="mt-1 mb-0 fw-bold">Today’s Enquiry</p>
                                            </a> --}}

                            </div>
                            <div class="col-lg-6 mb-3">
                                <a
                                    href="{{ url('/enquiry?from_date=' . $current_date . '&to_date=' . $current_date . '&date_type=1&from=today' . '&showroom_id=' . request('Showroom') . '&zone_id=' . request('zone')) }}">
                                    <div class="card">
                                        <div class="d-flex p-2 box-header gap-3 align-items-center">
                                            <span class="enquiry-icon-2"><i class="fas fa-chart-line"></i></span>
                                            <p class="m-0 fw-600">Today’s Follow Up</p>
                                        </div>
                                        <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                                            <h2 class="fs-36px lh-36px">{{ $countData['counttodayfollowup'] }}</h2>
                                            <span
                                                class="@if ($countData['counttodayfollowup'] > $countData['countpreviousfollowup']) color-positive @else color-negative @endif"><i
                                                    class="fas @if ($countData['counttodayfollowup'] > $countData['countpreviousfollowup']) fa-arrow-up @else fa-arrow-down @endif"></i></span>
                                            {{-- <p class="m-0 color-positive fw-500">64.4%</p> --}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 mb-lg-0 mb-3">
                                <a
                                    href="{{ url('/passed-over?&showroom_id=' . request('Showroom') . '&zone_id=' . request('zone')) }}">
                                    <div class="card">
                                        <div class="d-flex p-2 box-header gap-3 align-items-center">
                                            <span class="enquiry-icon-3"><i class="fas fa-history"></i></span>
                                            <p class="m-0 fw-600">Passed over Follow Up</p>
                                        </div>
                                        <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                                            <h2 class="fs-36px lh-36px">{{ $countData['passedfollowup'] }}</h2>
                                            <span
                                                class="@if ($countData['passedfollowup'] > $countData['passedpreviousfollowup']) color-positive @else color-negative @endif "><i
                                                    class=" fa @if ($countData['passedfollowup'] > $countData['passedpreviousfollowup']) fa-arrow-up @else fa-arrow-down @endif"></i></span>
                                            {{-- <p class="m-0 color-positive fw-500">64.4%</p> --}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 mb-lg-0 mb-3">
                                <a
                                    href="{{ url('/enquiry?from_date=' . $firstDayLastMonth . '&to_date=' . $lastDayLastMonth . '&date_type=2' . '&showroom_id=' . request('Showroom') . '&zone_id=' . request('zone')) }}">
                                    <div class="card">
                                        <div class="d-flex p-2 box-header gap-3 align-items-center">
                                            <span class="enquiry-icon-4"><i class="far fa-calendar-alt"></i></span>
                                            <p class="m-0 fw-600">Last Month Enquiry</p>
                                        </div>
                                        <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                                            <h2 class="fs-36px lh-36px">{{ $countData['counttodaylastmonth'] }}</h2>
                                            <span
                                                class="@if ($countData['total'] < $countData['counttodaylastmonth']) color-positive @else color-negative @endif"><i
                                                    class="fas @if ($countData['total'] < $countData['counttodaylastmonth']) fa-arrow-up @else fa-arrow-down @endif "></i></span>
                                            {{-- <p class="m-0 color-negative fw-500">64.4%</p> --}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       
            {{-- Bar Chart  --}}

        </div>
        <div class="col-md-6">
            {{-- Total’s Enquiry  --}}
            <div class="col-lg-12 mb-4">
                <div class="card box-height">
                    <div class="card-body p-3" dir="ltr">
                        <div class="row gx-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="d-flex box-header p-2 justify-content-between align-center">
                                        <div class="d-flex  gap-3 align-items-center">
                                            <span class="enquiry-icon-1"><i class="fas fa-calendar-check"></i></span>
                                            <p class="m-0 fw-600">Enquiry Statistics (Current Month)</p>
                                        </div>
                                            <div class="month_select">
                                          <form action="" method="GET" class="filter-support-order-search__form">
                                                <div class="select-style2">
                                                    <div class="dm-select enquiry_status_dm-select">
                                                          <select name="" onchange="EnquiryStatistics()" id="month_source" class="form-control" required>
                                                            <option   value="0">Select Month</option>
                                                            <option @if(date('n') == '1') selected @endif value="1">January</option>
                                                            <option @if(date('n') == '2') selected @endif value="2">February</option>
                                                            <option @if(date('n') == '3') selected @endif value="3">March</option>
                                                            <option @if(date('n') == '4') selected @endif value="4">April</option>
                                                            <option @if(date('n') == '5') selected @endif value="5">May</option>
                                                            <option @if(date('n') == '6') selected @endif value="6">June</option>
                                                            <option @if(date('n') == '7') selected @endif value="7">July</option>
                                                            <option @if(date('n') == '8') selected @endif value="8">August</option>
                                                            <option @if(date('n') == '9') selected @endif value="9">September</option>
                                                            <option @if(date('n') == '10') selected @endif value="10">October</option>
                                                            <option @if(date('n') == '11') selected @endif value="11">November</option>
                                                            <option @if(date('n') == "12") selected @endif value="12">December</option>
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-box-value" id="card-box-value-status">
                                    </div>
                                </div>

                                {{-- href="{{ url('/enquiry?from_date=' . $current_date . '&to_date=' . $current_date . '&date_type=2') }}">
                                                        <h2>{{ $countData['counttodayenquery'] }}</h2>
                                                        <p class="mt-1 mb-0 fw-bold">Today’s Enquiry</p>
                                                    </a> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Total’s Enquiry Close  --}}
            {{-- Total’s Enquiry  --}}

            {{-- Total’s Enquiry Close  --}}

            {{-- <div class="col-xxl-12 col-sm-12 mb-25">
                <div class="card card-default defult-height card-md mb-4">
                    <div class="card-body d-flex align-items-center">
                
                    </div>
                </div>
            </div> --}}

            @php

                $data = [];
                $countfollowup = [];
            @endphp
            @foreach ($alldate as $source)
                @php

                    $enquery = App\Models\Enquery::whereDate('created_at', $source);

                    $followup = App\Models\FollowUp::with(['enquiry'])
                        ->whereDate('last_attend_date', $source)
                        ->where('status', 1);

                    if ($countData['request']) {
                        $show_room_id = $countData['request']['Showroom'];
                        $enquery->where('showroom_id', $countData['request']['Showroom']);

                        $followup->whereHas('enquiry', function ($q) use ($show_room_id) {
                            $q->where('showroom_id', $show_room_id);
                        });

                        // $followup->where('showroom_id', $countData['request']['Showroom']);
                    }
                    // dd(Auth::user()->role_id);
                    if (Auth::user()->role_id == 2) {
                        $enquery->where('assign', Auth::user()->id);
                        $user_id = Auth::user()->id;
                        // $followup->with(['enquiries','enquiries.assign'])->where('assign', Auth::user()->id);
                        $followup->whereHas('enquiry', function ($q) use ($user_id) {
                            $q->where('assign', $user_id);
                        });
                        //  dd(Auth::user()->id);
                    } elseif (Auth::user()->role_id == 3) {
                        $show_room_id = Auth::user()->showroom_id;
                        $enquery->where('showroom_id', $show_room_id);

                        $followup->whereHas('enquiry', function ($q) use ($show_room_id) {
                            $q->where('showroom_id', $show_room_id);
                        });
                    }elseif (Auth::user()->role_id == 6) {

                          $created_by = Auth::user()->id;
                        $enquery->where('created_by',$created_by);

                        $followup->whereHas('enquiry', function ($q) use ($created_by) {
                            $q->where('created_by', $created_by);
                        });
                        
                    }
                    $totalenq = $enquery->count();
                    $totalfollwup = $followup->count();

                @endphp
                @php
                    // if ($totalenq <= 0) {
                    //     $totalenq = 1;
                    // }
                    // if ($totalsale <= 0) {
                    //     $totalsale = 0;
                    // }

                    // $data_collect = number_format(($totalsale / $totalenq) * 100, 0);

                    $data[] = $totalenq;
                    $countfollowup[] = $totalfollwup;

                @endphp
            @endforeach




            {{-- <div class="col-xxl-12 mb-25">
              
                <div class="card card-default card-md mb-4">
                    <div class="card-header">
                        <h6>Monthly Conversion Rate</h6>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div class="areaChartBasic"></div>
                         </div>
                    </div>
                </div>
            </div> --}}



        </div>




        {{-- row  --}}

         
    </div>

    
    {{-- Digital Source Start --}}
<div class="row">
    <div class="col-xxl-12 mb-25">
        <div class="card  px-25 h-100">
            <div class="card-header px-0 border-0">
                <h6>Source Of Revenue Generated</h6>
                <div class="card-extra">
                     <div class="month_select">
                        <form action="" method="GET" class="filter-support-order-search__form">
                            <div class="select-style2">
                                <div class="dm-select select_district_2">
                                    <select name="" onchange="SourceStatistics()" id="month_source_source" class="form-control" required>
                                        <option   value="0">Select Month</option>
                                        <option @if(date('n') == '1') selected @endif value="1">January</option>
                                        <option @if(date('n') == '2') selected @endif value="2">February</option>
                                        <option @if(date('n') == '3') selected @endif value="3">March</option>
                                        <option @if(date('n') == '4') selected @endif value="4">April</option>
                                        <option @if(date('n') == '5') selected @endif value="5">May</option>
                                        <option @if(date('n') == '6') selected @endif value="6">June</option>
                                        <option @if(date('n') == '7') selected @endif value="7">July</option>
                                        <option @if(date('n') == '8') selected @endif value="8">August</option>
                                        <option @if(date('n') == '9') selected @endif value="9">September</option>
                                        <option @if(date('n') == '10') selected @endif value="10">October</option>
                                        <option @if(date('n') == '11') selected @endif value="11">November</option>
                                        <option @if(date('n') == "12") selected @endif value="12">December</option>
                                    </select>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="sourcedata">

            </div>
        </div>
    </div>
</div>
{{-- Digital Source Close --}}

    <div class="row gx-2">

        {{-- Bar Chart  --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h2>Monthly Enquiry Rate</h2>
                </div>
                <div class="card-body" dir="ltr">

                    <canvas id="areaChartBasic"></canvas>

                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h2>Monthly Follow-Up</h2>
                </div>
                <div class="card-body" dir="ltr">

                    <canvas id="follow-up"></canvas>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            {{-- Latest Enquery  --}}
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h2>Latest Enquery</h2>
                        <a class="btn btn-outline-primary"
                            href="{{ url('/enquiry?showroom_id=' . request('Showroom') . '&zone_id=' . request('zone')) }}">View
                            All Enquery<i class="fas m-0 px-2 fa-angle-right"></i></a>
                    </div>
                    <div class="card-body p-3" dir="ltr">
                        <div class="table-responsive d-lg-block d-md-block d-none">
                            <table class="table mb-0 table-bordered ">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Event Code</span>
                                        </th>
                                        <th style="width: 13%;" data-type="html" data-name='Booking Id'>
                                            <span class="userDatatable-title">Created date</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Source Category</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Source</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Customer Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Mobile</span>
                                        </th>

                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created by</span>
                                        </th>
                                        <th style="width: 13%;">
                                            <span class="userDatatable-title">Next Follow-up</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countData['todayenquirys'] as $key => $enquiry)
                                        <tr>
                                            <td>
                                                <button style="color:#0C3688"
                                                    class="mb-0 border-0 bg-transparent text-center"
                                                    onclick="history({{ $enquiry->id }})">
                                                    <div style="color:#0C3688" class="userDatatable-content">
                                                        {{ $enquiry->event_code }}</div>
                                                </button>
                                                <div class="icon-wrapper">
                                                    @if ($enquiry->buying_aspect == 1)
                                                        <span href="#" data-toggle="tooltip"
                                                            data-placement="top" title="High"
                                                            style="color: #00cc2c "><img
                                                                src="https://i.postimg.cc/3R4Ttmqw/heigh.png"
                                                                alt="High"></span>
                                                    @elseif($enquiry->buying_aspect == 2)
                                                        <span href="#" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Medium"
                                                            style="color: #00ccff"><img
                                                                src="https://i.postimg.cc/s22QDHM0/medium.png"
                                                                alt="medium"></span>
                                                    @else
                                                        <span href="#" data-toggle="tooltip"
                                                            data-placement="top" title="Low"
                                                            style="color: #ff5100"><img
                                                                src="https://i.postimg.cc/4xWyMvWv/low.png"
                                                                alt="low"></span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="userDatatable-inline-title">
                                                        <a href="#" class="text-dark fw-500">
                                                            <h6>{{ date('d/m/Y h:i A', strtotime($enquiry->created_at)) }}
                                                            </h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    {{ @$enquiry->enquiry_source->name }}
                                                </div>
                                            </td>

                                            <td>
                                                <div class="userDatatable-content">
                                                    {{ @$enquiry->enquiry_source_child->name }}
                                                </div>
                                            </td>

                                            <td>
                                                <div class="userDatatable-content">{{ $enquiry->name }}</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">{{ $enquiry->number }}</div>
                                            </td>

                                            <td>
                                                <div class="userDatatable-content d-inline-block">
                                                    <span class="color-success  userDatatable-content active">
                                                        {{ @$enquiry->enquirystatus->name }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content d-inline-block">
                                                    <span
                                                        class="color-success  userDatatable-content active">{{ @$enquiry->users->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content d-inline-block">
                                                    <span
                                                        class="color-success  userDatatable-content active">{{ $enquiry->next_follow_up_date ? date('d/m/Y h:i A', strtotime($enquiry->next_follow_up_date)) : null }}</span>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="pt-2">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Bar Chart Close  --}}
        </div>
    </div>
</div>

@php
    $convertsource = json_encode($enquery_source);
    $var_rate = json_encode($data);
    $totalenq = json_encode($data);
    $num = json_encode($num);
    $countfollowup = json_encode($countfollowup);

@endphp
<script>
    var convertsource = <?php echo $convertsource; ?>;
    var var_rate = <?php echo $var_rate; ?>;
    var totalenq = <?php echo $totalenq; ?>;
    var num = <?php echo $num; ?>;
    var countfollowup = <?php echo $countfollowup; ?>;


    var countopen = ({{ $countData['countopen'] }});
    var countclose = ({{ $countData['countclose'] }});
    var countsales = ({{ $countData['countsales'] }});
    var countpending = ({{ $countData['countpending'] }});


    function areaChart(e, t, o = "270") {
        var r = {
            series: [{
                data: totalenq.map(totale => totale)
            }],
            colors: ["#8231D3", "#00AAFF"],
            chart: {
                width: t,
                height: o,
                type: "area"
            },
            legend: {
                show: !1
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                curve: "straight"
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: !0
                }
            },
            dataLabels: {
                enabled: !1
            },
            xaxis: {
                categories: num.map(n => n)
            },
        };
        $(e).length > 0 && new ApexCharts(document.querySelector(e), r).render();
    }

    function exampleAreaChart(e, a, t, r, o, n) {
        let l, i, d, color;
        (d = getComputedStyle(document.documentElement).getPropertyValue(
            "--color-primary"
        )),
        (i = getComputedStyle(document.documentElement).getPropertyValue(
            "--color-primary-rgba"
        ));
        var s = document.getElementById(e);
        if (s) {
            s.getContext("2d"), (s.height = window.innerWidth <= 575 ? 180 : a);
            new Chart(s, {
                type: "line",
                data: {
                    labels: r,
                    datasets: [{
                        data: t,
                        borderColor: d,
                        borderWidth: 3,
                        backgroundColor: () =>
                            chartLinearGradient(
                                document.getElementById(e),
                                300, {
                                    start: `rgba(${i},0.5)`,
                                    end: "rgba(255,255,255,0.05)",
                                }
                            ),
                        fill: n,
                        label: o,
                        tension: 0.4,
                        hoverRadius: "6",
                        pointBackgroundColor: d,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHitRadius: 30,
                        pointStyle: "circle",
                        pointHoverBorderWidth: 2,
                    }, ],
                },
                options: {
                    maintainAspectRatio: !0,
                    responsive: !0,
                    interaction: {
                        mode: "index"
                    },
                    plugins: {
                        legend: {
                            display: !1,
                            position: "bottom",
                            align: "start",
                            labels: {
                                boxWidth: 6,
                                display: !0,
                                usePointStyle: !0
                            },
                        },
                        tooltip: {
                            usePointStyle: !0,
                            enabled: !0
                        },
                    },
                    animation: {
                        onComplete: () => {
                            l = !0;
                        },
                        delay: (e) => {
                            let a = 0;
                            return (
                                "data" !== e.type ||
                                "default" !== e.mode ||
                                l ||
                                (a = 200 * e.dataIndex + 50 * e.datasetIndex),
                                a
                            );
                        },
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    },
                },
            });
        }
    }


    // Nipun Add
    function exampleAreaChart1(e, a, t, r, o, n) {
        let l, i, d, color;
        (d = getComputedStyle(document.documentElement).getPropertyValue(
            "--color-success"
        )),
        (i = getComputedStyle(document.documentElement).getPropertyValue(
            "--color-success-rgba"
        ));
        var s = document.getElementById(e);
        if (s) {
            s.getContext("2d"), (s.height = window.innerWidth <= 575 ? 180 : a);
            new Chart(s, {
                type: "line",
                data: {
                    labels: r,
                    datasets: [{
                        data: t,
                        borderColor: d,
                        borderWidth: 3,
                        backgroundColor: () =>
                            chartLinearGradient(
                                document.getElementById(e),
                                300, {
                                    start: `rgba(${i},0.5)`,
                                    end: "rgba(255,255,255,0.05)",
                                }
                            ),
                        fill: n,
                        label: o,
                        tension: 0.4,
                        hoverRadius: "6",
                        pointBackgroundColor: d,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHitRadius: 30,
                        pointStyle: "circle",
                        pointHoverBorderWidth: 2,
                    }, ],
                },
                options: {
                    maintainAspectRatio: !0,
                    responsive: !0,
                    interaction: {
                        mode: "index"
                    },
                    plugins: {
                        legend: {
                            display: !1,
                            position: "bottom",
                            align: "start",
                            labels: {
                                boxWidth: 6,
                                display: !0,
                                usePointStyle: !0
                            },
                        },
                        tooltip: {
                            usePointStyle: !0,
                            enabled: !0
                        },
                    },
                    animation: {
                        onComplete: () => {
                            l = !0;
                        },
                        delay: (e) => {
                            let a = 0;
                            return (
                                "data" !== e.type ||
                                "default" !== e.mode ||
                                l ||
                                (a = 200 * e.dataIndex + 50 * e.datasetIndex),
                                a
                            );
                        },
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    },
                },
            });
        }
    }
    // Nipun Close 

    $(document).ready(function() {
        // console.log(countfollowup);
        // Your code to be executed when the DOM is ready
        pieChart(".apexPieToday", [countopen, countsales, countclose, countpending], "100%", 270),
            // barChart(".barChart", "100%", 280),
            // barChart(".barChart1", "100%", 280)
            // exampleAreaChart("#area", "100%", 280)

            areaChart(".areaChartBasic", "100%", 267);
        exampleAreaChart(
            "areaChartBasic",
            "105",
            (data = totalenq.map(totale => totale)),
            (labels = num.map(n => n)),
            "Total Enquiry",
            !0
        );

        exampleAreaChart1(
            // let = color;
            // (color = getComputedStyle(document.documentElement).getPropertyValue(
            // "#101010"
            // )),
            "follow-up",
            "105",
            (data = countfollowup.map(countfollo => countfollo)),
            (labels = num.map(n => n)),
            "Total Followup",
            !0
        );
    });

    // $(document).ready(function() {
    //     // Your code to be executed when the DOM is ready
    //     pieChart(".apexPieToday", [countopen, countsales, countclose], "100%", 270)
    // });
</script>


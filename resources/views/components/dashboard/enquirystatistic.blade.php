                                <!-- <div class="card-box-value"> -->
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <ul class="px-2 mt-2 showcountbox">
                                                    <li title="Open"><span
                                                            class="chartbox-1"></span><span>{{ $countData['countopen'] }}%</span>
                                                    </li>
                                                    <li title="Sales"><span
                                                            class="chartbox-2"></span><span>{{ $countData['countsales'] }}%</span>
                                                    </li>
                                                    <li title="Pending"><span
                                                            class="chartbox-4"></span><span>{{ $countData['countpending'] }}%</span>
                                                    </li>
                                                    <li title="Close"><span
                                                            class="chartbox-3"></span><span>{{ $countData['countclose'] }}%</span>
                                                    </li>

                                                </ul>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="card-chart">
                                                    <div class="apexPieToday"></div>
                                                    <div
                                                        class="d-flex gap-2 flex-wrap justify-content-center align-items-center mb-3">
                                                        <a
                                                            href="{{ url('/enquiry?from_date=' . $start_date . '&to_date=' . $end_date . '&date_type=2&status=' . $enquiry_status['open']) }}">
                                                            <div class="orange d-flex align-items-center gap-2"><span
                                                                    style="background-color:##FFD558"></span>
                                                                <p class="m-0">Open({{ $open }})</p>
                                                            </div>
                                                        </a>
                                                        <a
                                                            href="{{ url('/enquiry?from_date=' . $start_date . '&to_date=' . $end_date . '&date_type=2&status=' . $enquiry_status['sale']) }}">
                                                            <div class="green d-flex align-items-center gap-2">
                                                                <span></span>
                                                                <p class="m-0">Sales({{ $sales }})</p>
                                                            </div>
                                                        </a>
                                                        @php
                                                            $pending_status = isset($enquiry_status['pending']) ? $enquiry_status['pending'][0] : 0;
                                                        @endphp
                                                        <a
                                                            href="{{ url('/enquiry?from_date=' . $start_date . '&to_date=' . $end_date . '&date_type=2&status_ck=pending&status=14') }}">
                                                            <div class="pending d-flex align-items-center gap-2">
                                                                <span></span>
                                                                <p class="m-0">Pending({{ $pending }})</p>
                                                            </div>
                                                        </a>

                                                        <a
                                                            href="{{ url('/enquiry?from_date=' . $start_date . '&to_date=' . $end_date . '&date_type=2&status_ck=close&status=2') }}">
                                                            <div class="red d-flex align-items-center gap-2">
                                                                <span></span>
                                                                <p class="m-0">Close({{ $close }})</p>
                                                            </div>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <!-- </div> -->

<script>
       $(document).ready(function() {

     var countopen = ({{ $countData['countopen'] }});
    var countclose = ({{ $countData['countclose'] }});
    var countsales = ({{ $countData['countsales'] }});
    var countpending = ({{ $countData['countpending'] }});
        // console.log(countfollowup);
        // Your code to be executed when the DOM is ready
        pieChart(".apexPieToday", [countopen, countsales, countclose, countpending], "100%", 270)
            // barChart(".barChart", "100%", 280),
            // barChart(".barChart1", "100%", 280)
            // exampleAreaChart("#area", "100%", 280)

         //   areaChart(".areaChartBasic", "100%", 267);

            });
</script>
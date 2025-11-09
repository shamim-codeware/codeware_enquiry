@section('title', $title)
@section('description', $description)
@extends('layout.app')
@section('content')
    <div class="">
        {{-- <marquee direction="left"
  width="250"
  height="200"
  behavior="alternate"
  style="border:solid">
        </marquee> --}}
        {{-- Healine  --}}
        <div class="container-fluid d-lg-none d-block">
            <div class="row">
                <div class="dashboard_marque mt-3">
                    <marquee class="" id="marque-text"></marquee>
                </div>
            </div>
        </div>
        {{-- Healine  --}}


        <div class=" align-items-center mt-3">
            @if (Auth::user()->role_id == 1)
                <form action="{{ url('home') }}">

                    <div class="container-fluid px-0">
                        <div class="row gap-padding gx-2">
                            <div class="col-lg-6 mb-2">
                                <div class="dm-select req">
                                    <select onchange="FindShowroom()" name="zone" id="zone" class="form-control">
                                        <option value="">All Zone </option>
                                        @foreach ($zones as $key => $zone)
                                            <option @if ($zone->id == request('zone')) selected @endif
                                                value="{{ $zone->id }}">{{ $zone->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-2">
                                <div class="row gx-1">
                                    <div class="col-lg-10 col-md-9 mb-2">
                                        <div class="dm-select w-100">
                                            <select name="Showroom" id="showroom" class="form-control">
                                                <option value="">All Showroom</option>
                                                @if (request('Showroom'))
                                                    @php
                                                        $showroom = App\Models\ShowRoom::where('id', request('Showroom'))->first();
                                                    @endphp
                                                    <option value="{{ $showroom->id }}" selected> {{ $showroom->name }}
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <button class="btn w-100 btn-primary px-30 mx-1 lh-45px" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            @endif
            @include('components.dashboard.overview_cards')
            {{-- @include('components.dashboard.sales_report') --}}
            @include('components.dashboard.sales_growth')
            {{-- @include('components.dashboard.sales_location')
                    @include('components.dashboard.top_sale_products')
                    @include('components.dashboard.browser_state') --}}
        </div>
    </div>

    <script>
        var show_room_id = <?php echo request('Showroom') ? request('Showroom') : 0; ?>;


        $(document).ready(function() {
            var parent_id = $("#zone").val();    
            if (parent_id != '') {
                const selectElement = document.getElementById("showroom");
                $.post('{{ url('/select-showroom') }}', {
                    _token: '{{ csrf_token() }}',
                    parent_id: parent_id
                }, function(data) {
                    data = JSON.parse(data);
                    console.log(data);
                    selectElement.innerHTML = '';
                    const fixedOption = document.createElement('option');
                    fixedOption.value = '';
                    fixedOption.textContent = 'All Showroom';
                    selectElement.appendChild(fixedOption);
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id; // Replace 'item.value' with the actual data field
                        option.textContent = item
                        .name; // Replace 'item.text' with the actual data field
                        selectElement.appendChild(option);
                    });
                    if (show_room_id != 0) {
                        for (let i = 0; i < selectElement.options.length; i++) {
                            if (selectElement.options[i].value == show_room_id) {
                                selectElement.selectedIndex = i;
                                break;
                            }
                        }

                    }

                });

            }


            var marquetext = "this is test ";
            $.post('{{ url('/todays-followup') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {

                $("#marque-text").html(data);
            });

            EnquiryStatistics()

        });


        //Enquiry Statistics ajax operation 
        function EnquiryStatistics(){
            var marquetext = "this is test ";
            var month_source = $("#month_source").val();
            $.post('{{ url('/enquiry-statistics') }}', {
                _token: '{{ csrf_token() }}',
                month_source : month_source
            }, function(data) {
               $("#card-box-value-status").append(data);
            });
        }

        function FindShowroom() {
            var parent_id = $("#zone").val();
            console.log(parent_id);
            const selectElement = document.getElementById("showroom");
            $.post('{{ url('/select-showroom') }}', {
                _token: '{{ csrf_token() }}',
                parent_id: parent_id
            }, function(data) {
                data = JSON.parse(data);
                console.log(data);
                selectElement.innerHTML = '';
                const fixedOption = document.createElement('option');
                fixedOption.value = '';
                fixedOption.textContent = 'All Showroom';
                selectElement.appendChild(fixedOption);
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id; // Replace 'item.value' with the actual data field
                    option.textContent = item.name; // Replace 'item.text' with the actual data field
                    selectElement.appendChild(option);
                });

            });

        }
    </script>

@endsection

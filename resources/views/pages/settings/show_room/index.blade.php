@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')
<div class="container-fluid">

    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4">
                            <div class="card-header">
                                <div class="d-flex align-items-center flex-wrap">
                                    <h6>Showroom </h6>
                                    <a class="mx-2 fw-bold excel-btn" href="{{ url('/showroom-export') }}">Export</a>
                                 
                                </div>   
                                @if (Auth::user()->user_action(1))
                                <a class="btn btn-primary" href="{{ route('show-rooms.create') }}">Add Showroom</a>
                            @endif                         
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-30">
                <div class="support-ticket-system support-ticket-system--search">
                   
                    <div class="support-form datatable-support-form d-flex justify-content-xxl-end justify-content-center align-items-center flex-wrap">
                        <div class="row row-cols-3 w-100">
                            <div class="col">
                                <h2>Total - {{ $total }}</h2>
                            </div>
                            <div class="col"></div>
                            <div class="col d-flex justify-content-end "> <div class="support-form__search">
                                <div class="support-order-search">
                                    <form action="/show-rooms" class="support-order-search__form" method="get">
                                        <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                        <input name="keyword" class="form-control border-0 box-shadow-none" type="search" placeholder="Search" aria-label="Search">
                                        <input class="search-btn-btn" type="submit" value="Search">
                                    </form>
                                </div>
                            </div></div>
                        </div>
                       
                    </div>
                    <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">SL</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Showroom Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Suffix</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">C. Name</span>
                                        </th>
                                        {{-- <th>
                                            <span class="userDatatable-title">C. Number</span>
                                        </th> --}}
                                        <th>
                                            <span class="userDatatable-title">District</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Address</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                                                         
                                        {{-- <th>
                                            <span class="userDatatable-title">Created by</span>
                                        </th> --}}
                                        <th>
                                            <span class="userDatatable-title">Created At</span>
                                        </th>
                                        <th class="actions">
                                            <span class="userDatatable-title">Action
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($showrooms as $key=>$showroom)
                                    <tr>
                                        <td>{{ ($showrooms->currentpage()-1) * $showrooms->perpage() + $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>{{ $showroom->name }}</h6>
                                                        <span style="font-size: 12px" data-toggle="tooltip" data-placement="top" title="Created By" style="color: #00ccff"><i class="fas fa-user pe-1"></i>{{ $showroom->users ? $showroom->users->name : '' }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                        <h6>{{ $showroom->suffix }}</h6>
                                                       
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="tel:{{  $showroom->number }}" class="text-dark fw-500">
                                                        <h6>{{ $showroom->contact_person }}</h6>
                                                        <span style="font-size: 12px"><i class="fas fa-phone pe-1"></i> {{ $showroom->number}}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div class="d-flex">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>{{ $showroom->number  }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>{{ $showroom->district->en_name  }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>{{ $showroom->street_address  }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject status-check">
                                                @if ($showroom->status == 1)
                                                <p style="background-color: #0e890e">Active</p>  
                                            @else
                                                <p style="background-color: #ff0000">Inactive</p>  
                                            @endif
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div class="userDatatable-content--subject">
                                                {{ $showroom->users ? $showroom->users->name : '' }}
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                {{ date('d/m/Y', strtotime($showroom->created_at)) }}
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                @if (Auth::user()->user_action(4))
                                                    <li>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Change status" href="{{ url('showroom-status/'.$showroom->id) }}" class="view">
                                                            <i class="las la-history"></i>
                                                        </a>
                                                       
                                                    </li>
                                                @endif
                                                @if (Auth::user()->user_action(2))
                                                    <li>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" href="{{url('show-rooms/'.$showroom->id.'/edit')}}" class="edit">
                                                            <i class="uil uil-edit"></i>
                                                        </a>
                                                    </li>
                                                @endif    
                                            </ul>
                                        </td>
                                    </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pt-2">
                            {{ $showrooms->links()  }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

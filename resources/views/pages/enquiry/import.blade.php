@extends('layout.app')

@section('content')



<div class="conatiner-fluid mt-3 position-relative">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form-element">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-default card-md mb-4">
                                <div class="card-header">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <h6>Import Enquiry </h6>
                                        <div id="export"></div>
                                    </div>
                                </div>
                                {{-- Passed Filter  --}}

                                <div class="card-body">
                                    <form action="{{ url('import-enquiry') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input accept=".xlsx,.csv" type="file" name="file">
                                        {{-- @error('file')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror --}}

                                        <button class="mx-2 fw-bold excel-btn" type="submit">Import</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-lg-none d-md-none d-sm-block d-block">
            <div class="row">
                <div class="col-lg-4 mx-auto">

                </div>
            </div>
        </div>
    </div>
@endsection

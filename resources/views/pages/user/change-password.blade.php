@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="crm mb-25">
    <div class="container-fluid">
        <div class="form-element mt-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-default card-md mb-4">
                                <div class="card-header">
                                    <h6>Profile</h6>
                                </div>
                                <div class="card-body py-md-25">
                                    <form action="{{ url('update-password') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <fieldset class="mt-2">
                                            <legend>Update Information:</legend>
                                        <div class="row"> 
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input required name="old_password" id="name" class="input" type="password" placeholder=" ">
                                                    <div class="placeholder"><p class="m-0">Password</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input required name="new_password" id="n_password" class="input" type="password" placeholder=" ">
                                                    <div class="placeholder"><p class="m-0">New Password</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input required name="password_c" id="c_password" class="input" type="password" placeholder=" ">
                                                    <div class="placeholder"><p class="m-0">Confirm Password</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </fieldset>
                                        <div class="d-flex gap-2 justify-content-end align-items-center mt-2">
                                        <input id="Submit" class="btn btn-primary"  type="submit" >
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>                     
                    </div>   
                </div>               
            </div>
        </div>
    </div>
</div>
@endsection
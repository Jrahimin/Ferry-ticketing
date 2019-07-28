@extends('FerryCompanyAdmin.layouts.app')

@section('additionalCSS')
    <style type="text/css">
        .btn-default.btn-on.active{background-color: #5BB75B;color: white;}
        .btn-default.btn-off.active{background-color: #DA4F49;color: white;}

        .btn-default.btn-on-1.active{background-color: #006FFC;color: white;}
        .btn-default.btn-off-1.active{background-color: #DA4F49;color: white;}

        .btn-default.btn-on-2.active{background-color: #00D590;color: white;}
        .btn-default.btn-off-2.active{background-color: #A7A7A7;color: white;}

        .btn-default.btn-on-3.active{color: #5BB75B;font-weight:bolder;}
        .btn-default.btn-off-3.active{color: #DA4F49;font-weight:bolder;}

        .btn-default.btn-on-4.active{background-color: #006FFC;color: #5BB75B;}
        .btn-default.btn-off-4.active{background-color: #DA4F49;color: #DA4F49;}
    </style>
@endsection

@section('content')
<?php
 $asset = asset('/');
 $companyId = Auth::User()->company_id;

?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
            $("#checkboxId").change(function(){
                var check = this.checked;
                if(check){
                    $("#dropdownId").prop("disabled",true);
                }
                else{
                    $("#dropdownId").prop("disabled",false);
                }
            });
        });
    </script>

	<div class="container">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3> Edit Company </h3> </center></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('updateUserCompany', ['companyId' => $companyId]) }}"  enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div  class="form-group{{ $errors->has('CompanyNumber') ? ' has-error' : '' }}">
                              <label class="col-md-4 control-label" for="CompanyNumber">  Company Number
                              </label>
                              <div class="col-md-6">
                                
                                    <input id="CompanyNumber" type="text" class="form-control" name="CompanyNumber" value="{{ $edit->account_number}}" required autofocus readonly>

                                     @if ($errors->has('CompanyNumber'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('CompanyNumber') }}</strong>
                                        </span>
                                     @endif 
                              </div>
                        </div>

                        <div  class="form-group{{ $errors->has('CompanyName') ? ' has-error' : '' }}">
                              <label class="col-md-4 control-label" for="CompanyName">  Company Name
                              </label>
                              <div class="col-md-6">
                                @foreach($companies as $company)
                                    @if($companyId == $company->id)
                                        <input id="CompanyName" type="text" class="form-control" name="CompanyName" value="{{ $company->name}}" required autofocus>
                                    @endif
                                @endforeach   
                                     @if ($errors->has('CompanyName'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('CompanyName') }}</strong>
                                        </span>
                                     @endif 
                              </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                            <label for="location" class="col-md-4 control-label">Location</label>

                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control" name="location" value="{{ $edit->location}}" required autofocus>

                                @if ($errors->has('location'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{$edit->description}}" required autofocus>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                            <label for="telephone" class="col-md-4 control-label">Telephone</label>

                            <div class="col-md-6">
                                <input id="telephone" type="text" class="form-control" name="telephone" value="{{ $edit->telephone }}" required autofocus min="0">

                                @if ($errors->has('telephone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">Status</label>

                            <div class="col-md-5">
                                <div class="btn-group" id="status" data-toggle="buttons">
                                  <label class="btn btn-default btn-on {{ $edit->status == 1 ? 'active' : '' }}" >
                                  <input type="radio" value="1" name="status" {{ $edit->status == 1 ? 'checked' : '' }}>Activate</label>
                                  <label class="btn btn-default btn-off {{ $edit->status == 0 ? 'active' : '' }} ">
                                  <input type="radio" value="0" name="status" {{ $edit->status == 0 ? 'class="active" checked' : '' }}>InActivate</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Company Logo</label>
                            <div class="col-md-6" >
                                <img id="logoPreview" src="{{$asset}}{{$edit->image_url}}" alt="Image " height="90px" width="90px"/>

                                <button class="btn btn-default" type="button" id="get_file"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Upload</button>
                                    
                                <input name="image" type="file" id="logo" style=" display: none;">
                                    @if($errors->has('logo'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('logo') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additionalJS')

<script type="text/javascript">
$(function() {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#logoPreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#logo").change(function(){
        readURL(this);
    });

    $('#get_file').click(function(){
        $('#logo').click();
    });
})
    
</script>
@stop
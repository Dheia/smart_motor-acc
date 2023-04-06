@extends('layouts.Reception.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="loading" style="display: none;">
                    <div style="position: fixed;z-index: 9999; left: 40%;top: 37% ;width: 100%">
                        <img width="200" src="{{ URL::asset('loader.gif') }}" type="image/gif">
                    </div>
                </div>
            </div>
        </div>
    </div>
		<!-- page content -->

        <div class="right_col" role="main">
            <div class="page-title">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('JobCard')}}</span></a>
                        </div>
                        @include('reception-view.dashboard.profile')
                    </nav>
                </div>
            </div>

            <div class="x_content">
                <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">

                    <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/reception/jobcard/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('JobCard List')}}</b></a></li>
                    <li role="presentation" class="active"><a href="{!! url('/reception/jobcard/search')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('JobCard Search')}}</b></a></li>
                    <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/reception/service/add') !!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add JobCard')}}</span></a></li>

                </ul>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <form method="post" id = "search_jobcard" action="javascript:" enctype="multipart/form-data"  class="form-horizontal upperform">


                                <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle" style="padding: 8px 0px;">{{ trans('app.Select Vehicle') }}</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                                        <select name="vehicle" id="vehicle" class="form-control " >
                                            <option value="all"<?php if($all_vehicles=='all'){ echo 'selected'; } ?>>{{ trans('app.All')}}</option>
                                            @foreach ($Select_vehicles as $Select_vehicle)
                                                <option value="{{ $Select_vehicle->id }}" <?php if($Select_vehicle->id == $all_vehicles) { echo  'selected'; } ?>>{{ $Select_vehicle->carNumber }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('vehicle'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('vehicle') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer" style="padding: 8px 0px;">{{ trans('app.Select Customer') }}</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                                        <select name="customer" id="customer" class="form-control " >
                                            <option value="all"<?php if($all_customer=='all'){ echo 'selected'; } ?>>{{ trans('app.All')}}</option>
                                            @foreach ($Select_customer as $Select_customers)
                                                <option value="{{ $Select_customers->id }}" <?php if($Select_customers->id == $all_customer) { echo  'selected'; } ?>>{{ $Select_customers->name }} | {{ $Select_customers->contact_no }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('customer'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('customer') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company" style="padding: 8px 0px;">{{ trans('Select Company') }}</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                                        <select name="company" id="company" class="form-control " >
                                            <option value="all"<?php if($all_company=='all'){ echo 'selected'; } ?>>{{ trans('app.All')}}</option>
                                            @foreach ($Select_company as $Select_companye)
                                                <option value="{{ $Select_companye->id }}" <?php if($Select_companye->id == $all_company) { echo  'selected'; } ?>>{{ $Select_companye->name }} | {{ $Select_companye->contact_no }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('company'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('company') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-2 text-right">
                                        <button type="submit" class="btn btn-success colorname">{{ trans('app.Go')}}</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


            <div class="row" >
                <div class="col-md-12 col-sm-12 col-xs-12" id="set-rows">

                    @include('reception-view.jobcard._table',['services'=>[]])


                </div>

            </div>
        </div>

    <script src="{{ URL::asset('build/js/custom.min.js') }}" defer="defer"></script>

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>


<!-- language change in user selected -->

<script>
$(document).ready(function(){

    $('#search_jobcard').on('submit', function () {
        $.ajax({
            type: 'POST',
            url: "{{url('/reception/jobcard/search-jobcard')}}",
            data: $('#search_jobcard').serialize(),

            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                $('#set-rows').html(data.view);
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    });

});
</script>


<!-- End Of Gate Pass Script -->
<script type="text/JavaScript">

   $(document).ready(function(){
	// Initialize select2
	$("#vehicle").select2();
	$("#customer").select2();
	$("#company").select2();
	});

</script>

@endsection

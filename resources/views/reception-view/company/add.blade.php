@extends('layouts.app')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- page content -->
    <style>
        .theTooltip {
            position: absolute!important;
            -webkit-transform-style: preserve-3d; transform-style: preserve-3d; -webkit-transform: translate(15%, -50%); transform: translate(15%, -50%);
        }
    </style>

    <?php $userid = Auth::user()->id; ?>
    @if (getAccessStatusUser('Customers',$userid)=='yes')
        @if(!empty(getActiveCustomer($userid)=='no'))
            <div class="right_col" role="main" style="background-color: #e6e6e6;">
                <div class="page-title">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle titleup">
                                <span>&nbsp {{ trans('app.You are not authorize this page.')}}</span>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        @else
            <div class="right_col" role="main" style="background-color: #e6e6e6;">
                <div class="">
                    <div class="page-title">
                        <div class="nav_menu">
                            <nav>
                                <div class="nav toggle">
                                    <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('Company')}}</span></a>
                                </div>
                                @include('dashboard.profile')
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="x_content">
                    <ul class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class=""><a href="{!! url('/admin/company/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('Company List') }}</a></li>
                        <li role="presentation" class="active"><a href="{!! url('/admin/company/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>{{ trans('Add Company') }}</b></a></li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <form id="demo-form2" action="{!! url('/admin/company/store')!!}" method="post"
                                      enctype="multipart/form-data" data-parsley-validate
                                      class="form-horizontal form-label-left input_mask">
                                    <div class="col-md-12 col-xs-12 col-sm-12 space">
                                        <h4><b>{{ trans('Company Information')}}</b></h4>
                                        <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
                                    </div>
                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">{{ trans('app.Name') }} <label class="text-danger">*</label> </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" id="name" name="name"  class="form-control validate[required]"
                                                       value="{{ old('name') }}" placeholder="{{ trans('Enter Name')}}" maxlength="25"  required  />
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
									   <strong>{{ $errors->first('name') }}</strong>
								   </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('contact_no') ? ' has-error' : '' }}">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="contact_no">{{ trans('app.Contact No') }} <label class="text-danger" >*</label></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text"  name="contact_no" placeholder="{{ trans('Enter Contact No')}}" value="{{ old('contact_no') }}" class="form-control" maxlength="15" required >
                                                @if ($errors->has('contact_no'))
                                                    <span class="help-block">
										<strong>{{ $errors->first('contact_no') }}</strong>
								   </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-12 col-sm-6 col-xs-12">

                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('TRN') ? ' has-error' : '' }}">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="TRN">{{ trans('TRN No.') }} <label class="text-danger" >*</label></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" id="TRN" name="TRN" placeholder="{{ trans('Enter TRN No.')}}" value="{{ old('TRN') }}" maxlength="25"
                                                       class="form-control" required>
                                                @if ($errors->has('TRN'))
                                                    <span class="help-block">
										<strong>{{ $errors->first('TRN') }}</strong>
									</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('address') ? ' has-error' : '' }}">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="address">{{ trans('Address') }} <label class="text-danger" >*</label></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" id="address" name="address" placeholder="{{ trans('Address')}}" value="{{ old('address') }}" maxlength="25"
                                                       class="form-control" required>
                                                @if ($errors->has('address'))
                                                    <span class="help-block">
										<strong>{{ $errors->first('address') }}</strong>
									</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-sm-6 col-xs-12">

                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">{{ trans('app.Email') }} <label class="text-danger" >*</label></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" id="email" name="email" placeholder="{{ trans('app.Enter Email')}}" value="{{ old('email') }}"
                                                       class="form-control" required>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>


                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12" style="padding: 40px 0px">
                                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                            <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                                            <button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="right_col" role="main">
            <div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
                <div class="nav toggle" style="padding-bottom:16px;">
                    <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
                </div>
            </div>
        </div>
    @endif
    <script>
        $(document).ready(function(){

            $('.select_country').change(function(){
                countryid = $(this).val();
                var url = $(this).attr('countryurl');
                $.ajax({
                    type:'GET',
                    url: url,
                    data:{ countryid:countryid },
                    success:function(response){
                        $('.state_of_country').html(response);
                    }
                });
            });

            $('body').on('change','.state_of_country',function(){
                stateid = $(this).val();

                var url = $(this).attr('stateurl');
                $.ajax({
                    type:'GET',
                    url: url,
                    data:{ stateid:stateid },
                    success:function(response){
                        $('.city_of_state').html(response);
                    }
                });
            });
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script type="text/javascript">
        $(".datepicker").datetimepicker({
            format: "<?php echo getDatepicker(); ?>",
            autoclose: 1,
            minView: 2,
            endDate: new Date(),
        });
    </script>
@endsection

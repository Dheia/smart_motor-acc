@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Employee')}}</span></a>
                    </div>
                    @include('dashboard.profile')
                </nav>
            </div>
        </div>
    </div>
    <div class="x_content">
        <ul class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class=""><a href="{!! url('/admin/employee/list')!!}" ><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Employee List')}}</a></li>

            <li role="presentation" class="active"><a href="{!! url('/admin/employee/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Employee')}}</b></a></li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <form method="post" action="{!! url('admin/employee/store') !!}" enctype="multipart/form-data"  class="form-horizontal upperform">
                        <div class="col-md-12 col-xs-12 col-sm-12 space">
                            <h4><b>{{ trans('app.Personal Information')}}</b></h4>
                            <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
                        </div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">{{ trans('Employee Name')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"  placeholder="{{ trans('Employee Name')}}" class="form-control" maxlength="25" required>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
										 <strong>{{ $errors->first('name') }}</strong>
									   </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('contact_no') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="contact_no">{{ trans('Employee Number')}} <label class="text-danger">*</label> </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" id="contact_no" name="contact_no"  value="{{ old('contact_no') }}" placeholder="{{ trans('Employee Number')}}" class="form-control" maxlength="25" required>
                                    @if ($errors->has('contact_no'))
                                        <span class="help-block">
										 <strong>{{ $errors->first('contact_no') }}</strong>
									   </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('user_name') ? ' has-error' : '' }}">
                                <label for="user_name" class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('User Name')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" id="user_name" class="form-control" value="{{ old('user_name') }}" placeholder="{{ trans('Enter User Name')}}" maxlength="25"  name="user_name">
                                    @if ($errors->has('user_name'))
                                        <span class="help-block">
										 <strong>{{ $errors->first('user_name') }}</strong>
									   </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="role">{{ trans('Role')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <select id="role" name="role"  class="form-control" required>
                                        @if(!empty($roles))
                                            @foreach($roles as $role)
                                                <option value="{{$role}}">{{ $role }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Password">{{ trans('app.Password')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="password" id="password" placeholder="{{ trans('app.Enter Password')}}" name="password"  class="form-control" maxlength="20" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12 currency" style="padding-right: 0px;"for="Password">{{ trans('app.Confirm Password') }} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="password"  name="password_confirmation" placeholder="{{ trans('app.Enter Confirm Password')}}" class="form-control col-md-7 col-xs-12" maxlength="20" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
										<strong>{{ $errors->first('password_confirmation') }}</strong>
									</span>
                                    @endif
                                </div>
                            </div>
                        </div>

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
		 <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
$(document).ready(function(){

	$('.datepicker1').datetimepicker({
        format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
		endDate: new Date(),
    });



		$(".datepicker,.input-group-addon").click(function(){
		var dateend = $('#left_date').val('');

		});

		$(".datepicker").datetimepicker({
			format: "<?php echo getDatepicker(); ?>",
			 minView: 2,
			autoclose: 1,
		}).on('changeDate', function (selected) {
			var startDate = new Date(selected.date.valueOf());

			$('.datepicker2').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,

			}).datetimepicker('setStartDate', startDate);
		})
		.on('clearDate', function (selected) {
			 $('.datepicker2').datetimepicker('setStartDate', null);
		})

			$('.datepicker2').click(function(){

			var date = $('#join_date').val();
			if(date == '')
			{
				swal('First Select Join Date');
			}
			else{
				$('.datepicker2').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
				})

			}
			});
});

</script>

  <!--
  left_date
  join_date
  -->

@endsection

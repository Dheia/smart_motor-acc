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
                        <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('Insurance')}}</span></a>
                    </div>
                    @include('dashboard.profile')
                </nav>
            </div>
        </div>
    </div>
    <div class="x_content">
        <ul class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class=""><a href="{!! url('/admin/insurance/list')!!}" ><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('Insurace List')}}</a></li>

            <li role="presentation" class="active"><a href="{!! url('/admin/insurance/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('Add Insurace')}}</b></a></li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <form method="post" action="{!! url('admin/insurance/store') !!}" enctype="multipart/form-data"  class="form-horizontal upperform">
                        <div class="col-md-12 col-xs-12 col-sm-12 space">
                            <h4><b>{{ trans('Insurance Information')}}</b></h4>
                            <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
                        </div>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('company_name') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="company_name">{{ trans('Company Name')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"  placeholder="{{ trans('Company Name')}}" class="form-control" maxlength="25" required>
                                    @if ($errors->has('company_name'))
                                        <span class="help-block">
										 <strong>{{ $errors->first('company_name') }}</strong>
									   </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('contact_no') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="contact_no">{{ trans('Company Number')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" id="contact_no" name="contact_no" value="{{ old('contact_no') }}"  placeholder="{{ trans('Company Number')}}" class="form-control" maxlength="25" required>
                                    @if ($errors->has('contact_no'))
                                        <span class="help-block">
										 <strong>{{ $errors->first('contact_no') }}</strong>
									   </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </div>

                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">{{ trans('Company Email')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" id="email" name="email" value="{{ old('email') }}"  placeholder="{{ trans('Company Email')}}" class="form-control" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
										 <strong>{{ $errors->first('email') }}</strong>
									   </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('TRN') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="TRN">{{ trans('Company TRN No.')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" id="TRN" name="TRN" value="{{ old('TRN') }}"  placeholder="{{ trans('Company TRN No.')}}" class="form-control" maxlength="25" required>
                                    @if ($errors->has('TRN'))
                                        <span class="help-block">
										 <strong>{{ $errors->first('TRN') }}</strong>
									   </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('subrogation') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="subrogation">{{ trans('Subrogation')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="file" id="subrogation" name="subrogation"  class="form-control" required>
                                    @if ($errors->has('subrogation'))
                                        <span class="help-block">
											<strong>{{ $errors->first('subrogation') }}</strong>
										</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="signature_position">{{ trans('Signature Positions')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <select id="signature_position" name="signature_position"  class="form-control" required>
                                        @if(!empty($signature_positions))
                                            @foreach($signature_positions as $signature_position)
                                                <option value="{{$signature_position}}">{{ $signature_position }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('address') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="address">{{ trans('Company Address')}} <label class="text-danger">*</label></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" id="address" name="address" value="{{ old('TRN') }}"  placeholder="{{ trans('Company Address')}}" class="form-control" maxlength="25" required>
                                    @if ($errors->has('address'))
                                        <span class="help-block">
										 <strong>{{ $errors->first('address') }}</strong>
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

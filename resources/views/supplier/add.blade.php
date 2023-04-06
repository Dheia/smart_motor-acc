@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Inventory',$userid)=='yes')
<div class="right_col" role="main">
   <div class="">
      <div class="page-title">
         <div class="nav_menu">
            <nav>
               <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Supplier')}}</span></a>
               </div>
               @include('dashboard.profile')
            </nav>
         </div>
      </div>
   </div>
   <div class="x_content">
      <ul class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class=""><a href="{!! url('/admin/supplier/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Supplier List')}}</a></li>
         <li role="presentation" class="active"><a href="{!! url('/admin/supplier/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Supplier')}}</b></a></li>
      </ul>
   </div>
   <div class="clearfix"></div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_content">
               <form method="post" action="{{ url('/admin/supplier/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform">
                  <div class="col-md-12 col-xs-12 col-sm-12 space">
                     <h4><b>{{ trans('app.Personal Information')}}</b></h4>
                     <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
                  </div>
				<div class="col-md-12 col-sm-6 col-xs-12">
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                     <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">{{ trans('Name')}} <label class="text-danger" >*</label>
                     </label>
                     <div class="col-md-8 col-sm-8 col-xs-12">
                        <input type="text" id="name" name="name" max="5" class="form-control" value="{{ old('name') }}"  placeholder="{{ trans('Enter Name')}}" maxlength="25" >
                        @if ($errors->has('name'))
                        <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                     </div>
                  </div>
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
@else
<div class="right_col" role="main">
   <div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
      <div class="nav toggle" style="padding-bottom:16px;">
         <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
      </div>
   </div>
</div>
@endif
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
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
<script>
   $(document).ready(function(){
       // Basic
       $('.dropify').dropify();

       // Translated
       $('.dropify-fr').dropify({
           messages: {
               default: 'Glissez-déposez un fichier ici ou cliquez',
               replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
               remove:  'Supprimer',
               error:   'Désolé, le fichier trop volumineux'
           }
       });

       // Used events
       var drEvent = $('#input-file-events').dropify();

       drEvent.on('dropify.beforeClear', function(event, element){
           return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
       });

       drEvent.on('dropify.afterClear', function(event, element){
           alert('File deleted');
       });

       drEvent.on('dropify.errors', function(event, element){
           console.log('Has Errors');
       });

       var drDestroy = $('#input-file-to-destroy').dropify();
       drDestroy = drDestroy.data('dropify')
       $('#toggleDropify').on('click', function(e){
           e.preventDefault();
           if (drDestroy.isDropified()) {
               drDestroy.destroy();
           } else {
               drDestroy.init();
           }
       })
   });

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
   $('.datepicker').datetimepicker({
      format: "<?php echo getDatepicker(); ?>",
   autoclose: 1,
   minView: 2,
   endDate: new Date(),
   });
</script>
@endsection

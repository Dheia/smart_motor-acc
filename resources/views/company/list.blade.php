@extends('layouts.app')
@section('content')
<!-- page content -->
	<?php $userid = Auth::user()->id; ?>
<style>

</style>


<div class="right_col" role="main">
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
    @if(session('message'))
        <div class="row massage">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="checkbox checkbox-success checkbox-circle">
                    @if(session('message') == 'Successfully Submitted')
                        <label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
                    @elseif(session('message')=='Successfully Updated')
                        <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
                    @elseif(session('message')=='Successfully Deleted')
                        <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted')}}  </label>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_content">
                <ul class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="{!! url('/admin/company/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('Company List') }}</b></a></li>
                    <li role="presentation" class=""><a href="{!! url('/admin/company/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> {{ trans('Add Company') }}</a></li>
                </ul>
            </div>
            <div class="x_panel bgr">
                <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px; width:100%;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('app.Name')}}</th>
                        <th>{{ trans('Contact Number') }}</th>
                        <th>{{ trans('TRN No.') }}</th>
                        <th>{{ trans('app.Email') }}</th>
                        <th>{{ trans('app.Address') }}</th>
                        <th>{{ trans('app.Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1;?>
                    @if(!empty($Companies))
                        @foreach($Companies as $company)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $company -> name }}</td>
                                <td>{{ $company -> contact_no }}</td>
                                <td>{{ $company -> TRN}}</td>
                                <td>{{ $company -> email }}</td>
                                <td>{{ $company -> address }}</td>

                                <td>
                                        <?php $userid=Auth::User()->id; ?>


                                    <a href="{!! url('/admin/company/list/'.$company->id) !!}">
                                        <button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>

                                    <a href="{!! url ('/admin/company/list/edit/'.$company->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>

                                    <a  url="{!! url('/admin/company/list/delete/'.$company->id)!!}" class="delete-company"> <button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>

                                </td>
                            </tr>
                                <?php $i++; ?>
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- /page content -->
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
		responsive: true,
        "language": {
			 "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange();
			?>.json"
        }
    } );
} );
</script>
<script>

$(document).ready(function(){
	$('body').on('click', '.delete-company', function() {
	  var url =$(this).attr('url');
        swal({
            title: "Are You Sure?",
			text: "You will not be able to recover this data afterwards!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#297FCA",
            confirmButtonText: "Yes, delete!",
            closeOnConfirm: false
        }, function(){
			window.location.href = url;

        });
    });
  });

</script>

@endsection

@extends('layouts.Reception.app')
@section('content')
		<!-- page content -->


        <div class="right_col" role="main">
            <div id="myModal-job" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <a href=""><button type="button" class="close">&times;</button></a>
                            <h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.JobCard')}}</h4>
                        </div>
                        <div class="modal-body">
                        </div>
                    </div>
                </div>
            </div>


            <script  type="text/javascript">

                function PrintElem(elem)
                {
                    Popup($(elem).html());
                }
                function Popup(data)
                {
                    var mywindow = window.open('', 'Print Expense Invoice', 'height=600,width=1000');

                    mywindow.document.write(data);


                    mywindow.document.close();
                    mywindow.focus();

                    mywindow.print();
                    mywindow.close();

                    return true;
                }
            </script>
            <!--end of gate pass-->

            <div class="">
                <div class="page-title">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.JobCard')}}</span></a>
                            </div>
                            @include('reception-view.dashboard.profile')
                        </nav>
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

                <div class="row" >
                    <div class="col-md-12 col-sm-12 col-xs-12" >


                        <div class="x_content">
                            <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">

                                <li role="presentation" class="active"><a href="{!! url('/reception/jobcard/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('JobCard List')}}</b></a></li>
                                <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/reception/jobcard/search')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('JobCard Search')}}</b></a></li>
                                <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/reception/service/add') !!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add JobCard')}}</span></a></li>

                            </ul>
                        </div>
                        <div class="x_panel table_up_div">
                            <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                                <thead>
                                <tr>
                                    <th>{{ trans('app.#')}}</th>
                                    <th>{{ trans('app.Job Card No')}}</th>
                                    <th>{{ trans('Quality Controller')}}</th>
                                    <th>{{ trans('app.Customer Name')}}</th>
                                    <th>{{ trans('Company Name')}}</th>
                                    <th>{{ trans('Vehicle Number')}}</th>
                                    <th>{{ trans('Received Date')}}</th>
                                    <th>{{ trans('app.Status')}}</th>
                                    <th>{{ trans('app.Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($services))
                                        <?php $i = 1; ?>
                                    @foreach ($services as $servicess)

                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $servicess->job_no }}</td>
                                            <td>{{ getCustomerName($servicess->assign_to) }}</td>
                                            <td>{{ getCustomerName($servicess->customer_id) }}</td>
                                            @php($user = \App\User::find($servicess->customer_id))
                                            @php($company = \App\User::find($user->company_id))
                                            @php($company_name = $company?$company->name:'-')
                                            <td>{{ $company_name }}</td>
                                            @php($vehicle = DB::table('tbl_vehicles')->where('id',$servicess->vehicle_id)->first())
                                            <td>{{ $vehicle->carNumber }}</td>
                                                <?php $dateservice = date("Y-m-d", strtotime($servicess->service_date)); ?>
                                            <td>{{ date(getDateFormat(),strtotime($dateservice)) }}</td>

                                            <td><?php if($servicess->done_status == 0)
                                                { echo"Active";}
                                                else if($servicess->done_status == 1)
                                                { echo"Completed";}
                                                elseif($servicess->done_status == 2){
                                                    echo"Progress";
                                                } ?>
                                            </td>
                                            <td>

                                                    <?php  $jobcard = getJobcardStatus($servicess->job_no);
                                                    $view_data = getInvoiceStatus($servicess->job_no);
                                                    ?>

                                                @if($jobcard == 1)
                                                    <a href="{{ url('/reception/jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" disabled>{{ trans('app.Process Job')}}</button></a>
                                                @elseif($view_data == "Yes")
                                                    <a href="{{ url('/reception/jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" disabled>{{ trans('app.Process Job')}}</button></a>
                                                @else
                                                    <a href="{{ url('/reception/jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" >{{ trans('app.Process Job')}}</button></a>
                                                @endif

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
        </div>

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- language change in user selected -->

<script>
$(document).ready(function(){
	$('body').on('click', '.getgetpass', function() {
		var getid = $(this).attr('getid');
	 var url = "<?php echo url('/reception/getpassdetail'); ?>";
		$.ajax({
			type:'GET',
			url:url,
			data:{getid:getid},
			success:function(response)
			{
				$('.modal-body').html(response.html);
			},
		});
	});
});
</script>

		<script>


 $('body').on('click', '.sa-warning', function() {

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


</script>

<!-- Gate Pass Script -->

<script  type="text/JavaScript">

		function PrintElem(elem)
			{
					Popup($(elem).html());
			}
			function Popup(data)
    {
        var mywindow = window.open('', 'Print Expense Invoice', 'height=600,width=1000');

        mywindow.document.write(data);


        mywindow.document.close();
        mywindow.focus();

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>

<!-- End Of Gate Pass Script -->
<script type="text/JavaScript">

$( document ).ready(function(){
$('body').on('click', '.save', function() {

	  $('.modal-body').html("");

       var serviceid = $(this).attr("serviceid");

		var url = $(this).attr('url');


       $.ajax({
       type: 'GET',
       url: url,

       data : {serviceid:serviceid},
       success: function (data)
       {

			  $('.modal-body').html(data.html);

   },
   beforeSend:function(){
						$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
					},
error: function(e) {
       alert("An error occurred: " + e.responseText);
       console.log(e);
}

       });

       });


   });

</script>

@endsection

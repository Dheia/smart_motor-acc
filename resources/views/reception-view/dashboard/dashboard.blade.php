@extends('layouts.Reception.app')
@section('content')
<Style>
.cld{
	 border-top: 3px solid #F25656;
}
.rjc{
	border-top: 3px solid #3a87ad;
}
.tmm{
	border-top: 3px solid #f39c12;
}
.mss{
    border-top: 3px solid  #12AFCB;
}
.freebuttom{
	    border-top: 3px solid #996600;
}
.paidbuttom{
	    border-top: 3px solid #f39c12 ;
}
.repeatbuttom{
	    border-top: 3px solid #00a65a ;
}
</style>
<script src="{{ URL::asset('build/js/jscharts.js') }}" defer="defer"></script>
<!-- <script src="{{ URL::asset('build/js/Chart.min.js') }}" defer="defer"></script> -->
	<div class="right_col" role="main">
	<!--  Free service view -->
		<div id="myModal-open-modal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<a href=""><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Free Service Details')}}</h4>
					</div>
					<div class="modal-body">

					</div>
				</div>
			</div>
		</div>

	<!--  Paid service view -->
		<div id="myModal-com-service" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<a href=""><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Paid Service Details')}}</h4>
					</div>
					<div class="modal-body">

					</div>
				</div>
			</div>
		</div>
	<!--  Repeat Job Service view -->
		<div id="myModal-serviceup" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">
		<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<a href=""><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Repeat Job Service Details')}}</h4>
					</div>
					<div class="modal-body">

					</div>
				</div>
			</div>
		</div>
	<!--  Free service customer view -->
		<div id="myModal-customer-modal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">
				<!-- Modal content-->
				<div class="modal-content">

					<div class="modal-body">

					</div>
				</div>
			</div>
		</div>
        <div class="page-title">
			<div class="nav_menu hidden-lg hidden-md" style="background-color: #2a3f54;">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars" style="color:#fff;"></i></a>

							<span class="titleup"> <a href="{!! url('/reception')!!}"> <img src="{{ URL::asset('public/general_setting/'.getLogoSystem())}}" width="140px" height="45px"  ></a>
							<!-- ( {{ trans('app.Dashboard')}} ) -->
							</span>

					</div>

					<ul class="nav navbar-nav navbar-right ulprofile">
						<li class="">
							<a href="javascript:;" class=" dropdown-toggle mobilefocus" data-toggle="dropdown" aria-expanded="false">
                                <span style="color:#fff;">{{ auth('reception')->user()->name }}</span>
								<span class="fa fa-angle-down" style="color:#fff;"></span>
							</a>
								<ul class="dropdown-menu dropdown-usermenu pull-right">
									<li><a href="{!!url('/reception/setting/profile')!!}"> {{ trans('app.Profile')}}</a></li>

                                    <li> <a href="{!! url('/reception/setting/general_setting/list') !!}"><span>{{ trans('app.Settings')}}</span></a></li>


                                    <li><a href="#" onclick="event.preventDefault();document.getElementById('logout-dash').submit();"><i class="fa fa-sign-out pull-right"></i> {{ trans('app.Log Out')}}</a></li>
									<form id="logout-dash" action="{{ route('reception.auth.logout') }}" method="get" style="display: none;">
											@csrf
									</form>
								</ul>
						</li>
					</ul>
				</nav>
			</div>
			<div class="nav_menu hidden-xs hidden-sm">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						<span class="titleup">{{ getNameSystem() }} </span>

					</div>

					<ul class="nav navbar-nav navbar-right ulprofile">
						<li class="">
							<a href="javascript:;" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                                {{ auth('reception')->user()->name }}

								<span class=" fa fa-angle-down"></span>
							</a>
								<ul class="dropdown-menu dropdown-usermenu pull-right">
									<li><a href="#" onclick="event.preventDefault();document.getElementById('logout-dash1').submit();"><i class="fa fa-sign-out pull-right"></i> {{ trans('app.Log Out')}}</a></li>
									<form id="logout-dash1" action="{{ route('reception.auth.logout') }}" method="get" style="display: none;">
											@csrf
									</form>
								</ul>
						</li>
					</ul>
				</nav>
			</div>
        </div>


        <div class="row">
            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-3 ">
                <a href="employee/list" target="blank">
                    <div class="panel info-box panel-white">
                        <div class="panel-body member">

                            <img src="{{ URL::asset('public/img/dashboard/team.png')}}" class="dashboard_background" alt="">
                            <div class="info-box-stats">
                                <p class="counter">
                                    @if(isset($employee))
                                            <?php  echo $employee; ?>
                                    @else
                                            <?php  echo "0"; ?>
                                    @endif                                 </p>

                                <span class="info-box-title">{{ trans('app.Employees')}}</span>
                            </div>

                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
                <a href="customer/list" target="blank">
                    <div class="panel info-box panel-white">
                        <div class="panel-body staff-member">
                            <img src="{{ URL::asset('public/img/dashboard/client.png')}}" class="dashboard_background" alt="">
                            <div class="info-box-stats">
                                <p class="counter">

                                    @if(isset($Customer))
                                            <?php echo $Customer; ?>
                                    @else
                                            <?php  echo "0"; ?>
                                    @endif
                                </p>
                                <span class="info-box-title">{{ trans('app.Customers')}}</span>
                            </div>


                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
                <a href="company/list" target="blank">
                    <div class="panel info-box panel-white">
                        <div class="panel-body member">
                            <img src="{{ URL::asset('public/img/dashboard/contract.png')}}" class="dashboard_background" alt="">						<div class="info-box-stats">
                                <p class="counter">
                                    @if($sales)
                                            <?php echo $sales; ?>
                                    @else
                                            <?php  echo "0"; ?>
                                    @endif
                                </p>

                                <span class="info-box-title"> {{ trans('Companies')}}</span>
                            </div>

                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
                <a href="supplier/list" target="blank">
                    <div class="panel info-box panel-white">
                        <div class="panel-body group">
                            <img src="{{ URL::asset('public/img/dashboard/telemarketer.png')}}" class="dashboard_background" alt="">						<div class="info-box-stats">
                                <p class="counter">
                                    @if(isset($Supplier))
                                            <?php echo $Supplier; ?>
                                    @else
                                            <?php  echo "0"; ?>
                                    @endif
                                </p>

                                <span class="info-box-title">{{ trans('app.Supplier')}} </span>
                            </div>


                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
                <a  href="section/list" target="blank">
                    <div class="panel info-box panel-white">
                        <div class="panel-body staff-member">
                            <img src="{{ URL::asset('public/img/dashboard/tasks.png')}}" class="dashboard_background" alt="">						<div class="info-box-stats">
                                <p class="counter">
                                    @if($service)
                                            <?php echo $service; ?>
                                    @else
                                            <?php  echo "0"; ?>
                                    @endif
                                </p>

                                <span class="info-box-title">{{ trans('Sections')}}</span>
                            </div>


                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
                <a href="services/list" target="blank">
                    <div class="panel info-box panel-white">
                        <div class="panel-body message">
                            <img src="{{ URL::asset('public/img/dashboard/industrial-robot.png')}}" class="dashboard_background" alt="">
                            <div class="info-box-stats">
                                <p class="counter">
                                    @if($product)
                                            <?php echo $product; ?>
                                    @else
                                            <?php  echo "0"; ?>
                                    @endif
                                </p>
                                <span class="info-box-title">{{ trans('Services')}}</span>
                            </div>


                        </div>
                    </div>
                </a>
            </div>


        </div>


	<!---end Active(login) in show admin,supportstaff,accountant-->
    </div>
	<div id="myModal-job" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<a href=""><button type="button" class="close">&times;</button></a>
					<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Invoice')}}</h4>
				</div>
				<div class="modal-body">
				</div>
			</div>
		</div>
	</div>


 <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>

 <!-- service event in calendarevent -->
 <?php if(!empty($serviceevent))
	{
		foreach($serviceevent as $serviceevents)
		{

			$i=1;
			$n_start_date=date("Y-m-d", strtotime($serviceevents->service_date));
			$n_end_date=date("Y-m-d", strtotime($serviceevents->service_date));
			$sid=$serviceevents->job_no;
			$userid=Auth::User()->id;
			if(!empty(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes'))
			{
				$view_data = getInvoiceStatus($serviceevents->job_no);

				if($view_data == "No")
				{
					$service_data_array[]=array('title'=>$serviceevents->job_no,
					'title1'=>$serviceevents->job_no,
					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),
					'customer'=>getCustomerName($serviceevents->customer_id),
					'vehicle'=>getVehicleName($serviceevents->vehicle_id),
					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),
					'url'=> 'jobcard/list/'.$serviceevents->id,
					'start'=>$n_start_date,
					'end'=>$n_end_date,
					'color'=>'#f0ad4e',
					);
				}
				else
				{
					$service_data_array[]=array('title'=>$serviceevents->job_no,
					'title1'=>$serviceevents->job_no,
					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),
					'customer'=>getCustomerName($serviceevents->customer_id),
					'vehicle'=>getVehicleName($serviceevents->vehicle_id),
					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),
					's_id'=>$serviceevents->id,
					'url1'=> 'dashboard/open-modal',
					'start'=>$n_start_date,
					'end'=>$n_end_date,
					'color'=>'#5FCE9B',
					);
				}

			}
			else
			{
				$view_data = getInvoiceStatus($serviceevents->job_no);

				if($view_data == "No")
				{
					$service_data_array[]=array('title'=>$serviceevents->job_no,
					'title1'=>$serviceevents->job_no,
					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),
					'customer'=>getCustomerName($serviceevents->customer_id),
					'vehicle'=>getVehicleName($serviceevents->vehicle_id),
					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),
					's_id'=>$serviceevents->id,
					'url11'=>'service/list/view',
					'start'=>$n_start_date,

					'end'=>$n_end_date,
					'color'=>'#f0ad4e',
					);
				}
				else
				{
					$service_data_array[]=array('title'=>$serviceevents->job_no,
					'title1'=>$serviceevents->job_no,
					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),
					'customer'=>getCustomerName($serviceevents->customer_id),
					'vehicle'=>getVehicleName($serviceevents->vehicle_id),
					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),
					's_id'=>$serviceevents->id,
					'url1'=> 'dashboard/open-modal',
					'start'=>$n_start_date,
					'end'=>$n_end_date,
					'color'=>'#5FCE9B',
					);
				}
			}

		}

	}

	//Holiday Event
	if(!empty($holiday))
	{
		foreach($holiday as $holidays)
		{
			$i=1;
			$n_start_date=date("Y-m-d", strtotime($holidays->date));
			$n_end_date=date("Y-m-d", strtotime($holidays->date));
			$service_data_array[]=array('title'=>substr($holidays->title,0,10),
			'title1'=>$holidays->title,
			'dates'=>date(getDateFormat(),strtotime($holidays->date)),
			'description'=>$holidays->description,
			'customer'=>'Holiday',
			'vehicle'=>"",
			'plateno'=>"",
			'start'=>$n_start_date,
			'end'=>$n_end_date,
			'color'=>'#3a87ad',
			);
		}
	}
	if(!empty($service_data_array)) {
		$data1 = json_encode($service_data_array);
	}
	else{
		$data1=json_encode('0');
	}
?>
 <!-- Calendar Event in Dashboard---->
 <script>
	$(document).ready(function() {
		$('#calendarevent').fullCalendar({
		height: 620,
		 header: {
		left: 'prev,next today',
		center: 'title',
		right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: new Date(),
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			editable: true,
			toolkip:true,
			events: <?php  if(!empty($data1)){ echo $data1;} ?>,
			eventMouseover: function (data, event, view) {
			   tooltip = '<div class="col-md-12 col-sm-12 col-xs-12 tooltiptopicevent" style="width:auto;height:auto;background:black;color:#fff;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;border-radius:5px;  line-height: 200%;">';
			   // alert(data.vehicle);
				if(data.title1 != '')
					tooltip = tooltip + data.title1 ;
				if(data.dates != '')
					tooltip = tooltip + ' | ' + data.dates + '</br>' + ' ';
				if(data.customer != '')
					tooltip = tooltip  + data.customer;
				if(data.plateno != '')
					tooltip = tooltip + ' | ' + data.plateno;
				if(data.vehicle != '')
					tooltip = tooltip + ' | ' + data.vehicle;

				tooltip = tooltip + '</div>';

            $("body").append(tooltip);
            $(this).mouseover(function (e) {
                $(this).css('z-index', 10000);
                $('.tooltiptopicevent').fadeIn('500');
                $('.tooltiptopicevent').fadeTo('10', 1.9);
            }).mousemove(function (e) {
                $('.tooltiptopicevent').css('top', e.pageY + 10);
                $('.tooltiptopicevent').css('left', e.pageX + 20);
            });
			},
			eventMouseout: function (data, event, view) {
				$(this).css('z-index', 8);
				$('.tooltiptopicevent').remove();
			},
			dayClick: function () {
				tooltip.hide()
			},
			eventResizeStart: function () {
				tooltip.hide()
			},
			eventDragStart: function () {
				tooltip.hide()
			},
			viewDisplay: function () {
				tooltip.hide()
			},

			eventClick: function(event) {
				if (event.url) {
					window.location(event.url);
				}
				if (event.url1)
				{
					$('#myModal-job').modal();

					$('.modal-body').html("");

					var serviceid = (event.s_id);


					var url = (event.url1);

					   $.ajax({
					   type: 'GET',
					   url: url,

					   data : {open_id:serviceid},
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
				}
				if (event.url11)
				{
					$('#myModal-customer-modal').modal();
					$('.modal-body').html("");
					var servicesid = (event.s_id);
					var url = (event.url11);

				   $.ajax({
				   type: 'GET',
				   url: url,
				   data : {servicesid:servicesid},
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
				}
			}

		});
	});

	</script>


  <script type="text/javascript">

$(document).ready(function(){

    $(".openmodel").click(function(){

	  $('.modal-body').html("");
	    var open_id= $(this).attr("open_id");

		var url = $(this).attr('url');
       $.ajax({
       type: 'GET',
       url: url,
	   data : {open_id:open_id},
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

<!-- Paid service -->
  <script type="text/javascript">

$(document).ready(function(){

    $(".completedservice").click(function(){

	  $('.modal-body').html("");

       var c_service = $(this).attr("c_service");

		var url = $(this).attr('url');

       $.ajax({
       type: 'GET',
       url: url,

       data : {open_id:c_service},
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

<!-- Repeat Job service  -->
  <script type="text/javascript">

$(document).ready(function(){

    $(".service-up").click(function(){

	  $('.modal-body').html("");

       var u_service = $(this).attr("u_service");

		var url = $(this).attr('url');

       $.ajax({
       type: 'GET',
       url: url,

       data : {open_id:u_service},
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

<!--  Free cusomer model service -->

  <script type="text/javascript">

$(document).ready(function(){

    $(".customeropenmodel").click(function(){

	  $('.modal-body').html("");
	    var open_customer_id= $(this).attr("open_customer_id");
		var url = $(this).attr('url');

       $.ajax({
       type: 'GET',
       url: url,
	   data : {servicesid:open_customer_id},
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

@extends('layouts.Reception.app')
@section('content')
    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <style>
        .jobcardmargintop{margin-top:9px;}
        .table>tbody>tr>td{padding:10px;
        <!-- vertical-align: unset!important; -->
        }
        .jobcard_heading{margin-left: 19px;margin-bottom: 15px}
        label{margin-bottom:0px;}
        .checkbox_padding{margin:10px 0px;}
        .first_observation{margin-left:23px;}
        .height{height:28px;}
        .all{width:226px;}
    </style>
<!-- page content -->

	<div class="right_col" role="main">
		<div class="page-title">
			  <div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.JobCard')}}</span></a>
					</div>
					  @include('reception-view.dashboard.profile')
				</nav>
			  </div>
		</div>

        <div class="x_content">
            <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">

                <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/reception/jobcard/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('JobCard List')}}</b></a></li>
                <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/reception/jobcard/search')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('JobCard Search')}}</b></a></li>
                <li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('/reception/service/add') !!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add JobCard')}}</span></a></li>

            </ul>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <form method="post" action="{{ url('reception/service/store') }}">
                        <div class="col-md-12 col-xs-12 col-xs-12">
                            <div class="col-md-5 col-xs-12 col-sm-12">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <label class="control-label jobcardmargintop col-md-4 col-sm-12 col-xs-12">{{ trans('app.Job Card No')}} <label class="text-danger">*</label></label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" id="job_no" name="job_no" value="{{$code }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                                    <label class="control-label jobcardmargintop col-md-4 col-sm-12 col-xs-12">{{ trans('Received Date')}} <label class="text-danger">*</label></label>
                                    <div class="col-md-8 col-sm-12 col-xs-12 input-group date">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                        <input type="date" name="received_date" id="received_date" placeholder="{{ trans('Enter Received Date') }}"  value="{{ old('reg_no') }}" maxlength="15" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 col-xs-12 col-sm-12">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <label class="control-label  col-md-3 col-sm-12 col-xs-12">{{ trans('Jobcard Type')}} <label class="text-danger">*</label></label>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        <label class="radio-inline"><input type="radio" name="customer_type" checked id="customer_cash"  value="customer_cash" required>{{ trans('Cash')}}</label>
                                        <label class="radio-inline"><input type="radio" name="customer_type"  id="customer_insurance"  value="customer_insurance" required>{{ trans('Insurance')}}</label>
                                        <label class="radio-inline"><input type="radio" name="customer_type"  id="company"  value="company" required>{{ trans('Company')}}</label>
                                        <label class="radio-inline"><input type="radio" name="customer_type"  id="company_insurance"  value="company_insurance" required>{{ trans('Insurance')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-xs-12 col-sm-12 space1">
                            <p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
                        </div>

                        <div class="col-md-12 col-xs-12 col-xs-12">

                            <div class="col-md-12 col-xs-12 col-sm-12" id ="customer_form">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-12 col-xs-12">{{ trans('app.Customer Name')}} <label class="text-danger">*</label></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <select name="Customername" id = "customer_select" cus_url = "{!! url('reception/service/get_user_data') !!}" class="form-control select_vhi" required>
                                            <option value="">{{ trans('app.Select Customer')}}</option>
                                            @if(!empty($customer))
                                                @foreach($customer as $customers)
                                                    <option value="{{$customers->id}}" <?php if($customers->id == $customer_id) { echo  'selected'; } ?> >{{ $customers->name }} | {{ $customers->contact_no }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12 addremove">
                                        <button type="button" data-toggle="modal"     data-target="#mymodal" class="btn btn-default openmodel">{{ trans('app.Add')}}</button>
                                    </div>
                                </div>

                            <div class="col-md-12 col-xs-12 col-sm-12" id ="company_form" hidden>
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-12 col-xs-12">{{ trans('Company Name')}} <label class="text-danger">*</label></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <select name="Companyname" style="min-width: 100% !important;"  id = "company_select" cus_url = "{!! url('reception/service/get_user_data') !!}" class="form-control select_vhi_com" >
                                            <option value="">{{ trans('Select Company')}}</option>
                                            @if(!empty($companies))
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}" >{{ $company->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-12 col-xs-12" for="vehicalnumber">{{ trans('Vehicle Number')}} <label class="text-danger">*</label></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <select name="vehicalnumber" id="vhi" class="form-control modelnameappend" vhi_url = "{!! url('reception/service/get_vehicle_data') !!}" required>
                                            <option value="">{{ trans('Select vehicle Number')}}</option>
                                            @if(!empty($vehicles))
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{$vehicle->id}}"  <?php if($vehicle->id == $vehicle_id) { echo  'selected'; } ?> >{{ $vehicle->carNumber }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12 addremove">
                                        <button type="button" data-toggle="modal" data-target="#vehiclemymodel" class="btn btn-default vehiclemodel">{{ trans('app.Add')}}</button>
                                    </div>
                                </div>

                            <div class="col-md-12 col-xs-12 col-sm-12">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-12 col-xs-12">{{ trans('app.Assign To')}} <label class="text-danger">*</label></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <select id="AssigneTo" name="AssigneTo"  class="form-control" required>
                                            <option value="">-- {{ trans('app.Select Assign To')}} --</option>
                                            @if(!empty($employee))
                                                @foreach($employee as $employees)
                                                    <option value="{{$employees->id}}">{{ $employees->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                        </div>


                        <div class="col-md-12 col-xs-12 col-xs-12" id="insurance" hidden>
                            <div class="col-md-12 col-xs-12 col-sm-12 space1">
                                <p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <h2 class="text-left jobcard_heading">{{ trans('Insurance Details')}}</h2>
                                <p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:8px;">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12"> {{ trans('Insurance Company')}}: <label class="text-danger">*</label></label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <select id="insurance_id" name="insurance_id"  class="form-control" >
                                            <option value="">{{ trans('Select Insurance Company')}}</option>
                                            @if(!empty($insurances))
                                                @foreach($insurances as $insurance)
                                                    <option value="{{$insurance->id}}">{{ $insurance->company_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12">{{ trans('Accident Report No')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" name="accident_no" placeholder="{{ trans('Enter Accident Report No')}}"  value="{{ old('accident_no') }}" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12">{{ trans('Reference No')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" name="reference_no" placeholder="{{ trans('Enter Reference No')}}"  value="{{ old('reference_no') }}" maxlength="50" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:8px;">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('Claim No')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" name="claim_no" placeholder="{{ trans('Enter Claim No')}}"  value="{{ old('claim_no') }}" maxlength="50" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:8px;">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('LPO No')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" name="LPO" placeholder="{{ trans('Enter LPO No')}}"  value="{{ old('LPO') }}" maxlength="50" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:8px;">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('LPO Date')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="date" name="LPO_Date" placeholder="{{ trans('Enter LPO Date')}}"  value="{{ old('LPO_Date') }}" maxlength="50" class="form-control" >
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-12 col-xs-12 col-sm-12 space1">
                            <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
                        </div>


                        <div class="col-md-12 col-xs-12 col-xs-12">
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <h2 class="text-left jobcard_heading">{{ trans('app.Customer Details')}}</h2>
                                <p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12">{{ trans('app.Name')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" id = "customer_name"  name="name" class="form-control" value="{{$customer_name}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12">{{ trans('TRN')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" id = "customer_TRN" name="address" class="form-control" value="{{$customer_TRN}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:8px;">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Contact No')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" id = "customer_contact_no"  name="con_no" class="form-control" value="{{$customer_contact_no}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:8px;">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12"> {{ trans('app.Email')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" id = "customer_email" name="email" class="form-control" value="{{$customer_email}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12 col-xs-12 vehicle_space">
                                <h2 class="text-left jobcard_heading">{{ trans('app.Vehicle Details')}}</h2>
                                <p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" style="padding-top: 7px;">{{ trans('app.Model Name')}}:</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="vehicle_modelname" name="model" class="form-control" value="{{$vehicle_modelname}}" readonly>
                                    </div>
                                    <label class="jobcardmargintop col-md-2 col-sm-2 col-xs-12">{{ trans('app.Chasis No')}}: </label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="vehicle_chassisno" name="coupan_no" class="form-control" value="{{$vehicle_chassisno}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
                                    <label class="jobcardmargintop control-label col-md-2 col-sm-2 col-xs-12">{{ trans('Car Number')}}: </label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="vehicle_carNumber" name="engine_no" class="form-control" value="{{$vehicle_carNumber}}" readonly>
                                    </div>
                                    <label class="jobcardmargintop col-md-2 col-sm-2 col-xs-12">{{ trans('Color')}}:</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="vehicle_color" name="kms"  maxlength="15" class="form-control" value="{{$vehicle_color}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-xs-12 col-xs-12" id="company_details" hidden>
                            <div class="col-md-12 col-xs-12 col-sm-12 space1">
                                <p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <h2 class="text-left jobcard_heading">{{ trans('Company Details')}}</h2>
                                <p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:8px;">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12"> {{ trans('Company Name')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" id ="company_name" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12">{{ trans('TRN')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" id ="company_TRN" readonly>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:8px;">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('Contact No')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" id ="company_contact_no" readonly>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                                    <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12">{{ trans('Email')}}:</label>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" id ="company_email" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-xs-12 col-sm-12 space1">
                            <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
                        </div>


                        <div class="col-md-12 col-xs-12 col-sm-12 panel-group">
                            <div class="col-md-10 col-sm-8 col-xs-8">
                                <h2>{{ trans('app.Other Service Charges')}}</h2>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-4">
                                <button type="button" id="add_new_product" class="btn btn-default" url="{!! url('/reception/jobcard/addproducts')!!}" style="margin:5px 0px;">{{ trans('app.Add New')}} </button>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:20px;">
                                <table class="table table-bordered addtaxtype" id="tab_products_detail" align="center">
                                    <thead>
                                    <tr>
                                        <th class="all">{{ trans('app.Service')}}</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($pros))
                                            <?php $id = 1; ?>
                                        @foreach($pros as $product)
                                            <tr id="<?php echo'row_id_'.$id; ?>">
                                                <td>
                                                    <input type="text" name="other_product[]" class="form-control" value="<?php echo $product->comment;?>" id="othr_prod_<?php echo $id; ?>" othr_prod="<?php echo $product->id;?>" >
                                                </td>
                                                <td>
                                                    <span class="trash_product" data-id="<?php echo $id; ?>" oth_url="<?php echo url('jobcard/oth_pro_delete') ?>"><i class="fa fa-trash fa-2x"style="vertical-align: middle !important;" ></i></span>
                                                </td>
                                            </tr>
                                                <?php $id++; ?>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!---- model in observation Point -->
                        <div class="col-md-12">
                            <div id="responsive-modal-observation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title">{{ trans('app.Observation Point')}}</h4>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success col-md-offset-10 check_submit" style="margin-bottom:5px;">{{ trans('app.Submit')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                                <button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

		<!--customer add model -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Customer Details</h4>
			  </div>
			    <div class="row massage hide addcustomermsg">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="checkbox checkbox-success checkbox-circle">
								<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
							</div>
						</div>
			    </div>
			  <div class="modal-body">
					<div class="x_content">


						<form id="formcustomer" action="" method="POST" name="formcustomer"
						enctype="multipart/form-data" data-parsley-validate
					             class="form-horizontal form-label-left input_mask">
                            <div class="col-md-12 col-xs-12 col-sm-12 space">
                                <h4><b>{{ trans('Customer Information')}}</b></h4>
                                <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
                            </div>



                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">{{ trans('app.Name') }} <label class="text-danger">*</label> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="name" name="name"  class="form-control validate[required]"
                                               value="{{ old('name') }}" placeholder="{{ trans('Enter Name')}}" maxlength="25"  required  />
                                        <span class="invalid-feedback">
                                        <strong id="errorname" ></strong>
                                   </span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('contact_no') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="contact_no">{{ trans('app.Contact No') }} <label class="text-danger" >*</label></label>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <button type="button" class="btn btn-default font-weight-bold" disabled>+971</button>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="contact_no" name="contact_no" placeholder="{{ trans('Enter Contact No')}}" value="{{ old('contact_no') }}" class="form-control" maxlength="15" required >
                                        <span class="invalid-feedback">
                                        <strong id="errorcontact_no" ></strong>
                                   </span>
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-12 col-sm-6 col-xs-12">

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('TRN') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="TRN">{{ trans('TRN No.') }}</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="TRN" name="TRN" placeholder="{{ trans('Enter TRN No.')}}" value="{{ old('TRN') }}" maxlength="25"
                                               class="form-control">
                                        <span class="invalid-feedback">
                                         <strong id="errorTRN" ></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('emirates_id') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="emirates_id">{{ trans('Emirates Id') }} <label class="text-danger" >*</label></label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="emirates_id" name="emirates_id" placeholder="{{ trans('Emirates Id')}}" value="{{ old('emirates_id') }}" maxlength="25"
                                               class="form-control" required>
                                        <span class="invalid-feedback">
                                         <strong id="erroremirates_id" ></strong>
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12 col-sm-6 col-xs-12">

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">{{ trans('app.Email') }}</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="email" name="email" placeholder="{{ trans('app.Enter Email')}}" value="{{ old('email') }}"
                                               class="form-control">
                                        <span class="invalid-feedback">
                                         <strong id="erroremail" ></strong>
                                        </span>
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('company') ? ' has-error' : '' }}" id = "customer_company" hidden>
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="test">{{ trans('Company') }} <label class="text-danger" >*</label></label>


                                    <div class="col-md-8 col-sm-8 col-xs-12">

                                        <select  id = "company_select2" name="companyCustomer" class="form-control">
                                            <option value="">{{ trans('Select Company')}}</option>
                                            @if(!empty($companies))
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}" >{{ $company->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="invalid-feedback">
                                         <strong id="errorcompany" ></strong>
                                        </span>
                                    </div>
                                </div>

                            </div>


                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group col-md-12 col-sm-12 col-xs-12" style="padding: 40px 0px">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                    <a class="btn btn-primary" data-dismiss="modal">{{ trans('app.Cancel')}}</a>
                                    <button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
                                </div>
                            </div>


						</form>
					</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>

		<!-- vehicle model -->
		<div class="modal fade" id="vehiclemymodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">Vehicle Details</h4>
					</div>
					<div class="row massage hide addvehiclemsg">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="checkbox checkbox-success checkbox-circle">
								<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
							</div>
						</div>
					</div>
					<div class="modal-body">
						<form  action="" method="post" enctype="multipart/form-data"  class="form-horizontal upperform">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group" style="margin-top:20px;">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="vehical_type">{{ trans('app.Vehicle Type')}} <label class="text-danger">*</label></label>
									<div class="col-md-3 col-sm-3 col-xs-12">

                                        <input type="text"  name="vehical_type" id="vehical_type" value="{{ old('vehical_type') }}" placeholder="{{ trans('app.Enter Vehicle Type')}}" maxlength="30" class="form-control" required>

                                        <span class="invalid-feedback">
											<strong id="errorlvehical_type" ></strong>
										</span>
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Chasic No')}} <label class="text-danger"> *</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="chasicno" id="chasicno1" value="{{ old('chasicno') }}" placeholder="{{ trans('app.Enter ChasicNo')}}" maxlength="30" class="form-control" required>
										<span class="invalid-feedback">
											<strong id="errorlchasicno1" ></strong>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model Name')}} <label class="text-danger">*</label></label>
									<div class="col-md-3 col-sm-3 col-xs-12">

                                        <input type="text"  name="modelname" id="modelname1" value="{{ old('modelname1') }}" placeholder="{{ trans('app.Enter Model Name')}}" maxlength="30" class="form-control" required>


                                        <span class="invalid-feedback">
											<strong id="errorlmodelname1" ></strong>
										</span>
									</div>
								</div>
								<div class="{{ $errors->has('color') ? ' has-error' : '' }}">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="color">
									{{ trans('Color' )}} <label class="text-danger">*</label> </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="color" id="color"  value="{{ old('color') }}" placeholder="{{ trans('Enter Color')}}" class="form-control" maxlength="10">
										<span class="invalid-feedback">
											<strong id="ppe"></strong>
										</span>
                                        <span class="invalid-feedback">
											<strong id="errorcolor" ></strong>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="{{ $errors->has('carNumber') ? ' has-error' : '' }}">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="carNumber">{{ trans('Car Number')}}  <label class="text-danger">*</label></label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										<input type="text"  name="carNumber" id="carNumber" value="{{ old('carNumber') }}" placeholder="{{ trans('Enter Car Number')}}" maxlength="20"  class="form-control">
									</div>
                                    <span class="invalid-feedback">
											<strong id="errorcarNumber" ></strong>
										</span>
								</div>
							</div>

							<div class="form-group col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									<button type="button" class="btn btn-success addvehicleservice" >{{ trans('app.Submit')}}</button>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

	</div>


	<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<!-- customer add -->
	<!-- customer add -->
	<script>
		$('body').on('click','.openmodel',function(){
			$('#myModal').modal();

		});

		// $('body').on('click', '.addcustomer',function(event){
	    $("#formcustomer").on('submit',(function(event) {
			function define_variable()
			{
				return {
                name:$("#name").val(),
                contact_no:$("#contact_no").val(),
                TRN:$("#TRN").val(),
                emirates_id:$("#emirates_id").val(),
                email:$("#email").val(),
                company:$('#company_select2').find(":selected").val(),
				name_pattern:/^[(a-zA-Z\s)]+$/,
				mobile_pattern:/^[- +()]*[0-9][- +()0-9]*$/,
				email_pattern:/^([a-zA-Z0-9_\.\-\+\'])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
				};
			}

			event.preventDefault();
			var call_var_customeradd = define_variable();
			var errro_msg = [];
			//first name
			if(call_var_customeradd.name == "")
			{
				var msg = "Name is required";
				$('#errorname').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorname').html("");
				errro_msg = [];
			}
			if (!call_var_customeradd.name_pattern.test(call_var_customeradd.name))
			{
				var msg = "Name must be alphabets only";
				$('#errorname').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorlfirstname').html("");
				errro_msg = [];
			}


			//Mobile number
			if(call_var_customeradd.contact_no == "")
			{
				var msg = "Contact Number is required";
				$('#errorcontact_no').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorcontact_no').html("");
				errro_msg = [];
			}
			if (!call_var_customeradd.mobile_pattern.test(call_var_customeradd.contact_no))
			{
				var msg = "Please enter only number";
				$('#errorcontact_no').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorcontact_no').html("");
				errro_msg = [];
			}


            if(call_var_customeradd.emirates_id == "")
            {
                var msg = "Emirates Id is required";
                $('#erroremirates_id').html(msg);
                errro_msg.push(msg);
                return false;
            }
            else
            {
                $('#erroremirates_id').html("");
                errro_msg = [];
            }

            if (!call_var_customeradd.mobile_pattern.test(call_var_customeradd.emirates_id))
            {
                var msg = "Please enter only number";
                $('#erroremirates_id').html(msg);
                errro_msg.push(msg);
                return false;
            }
            else
            {
                $('#erroremirates_id').html("");
                errro_msg = [];
            }


		if(errro_msg =="")
		{
		   var name =$('#name').val();
		   var contact_no =$('#contact_no').val();
		   var TRN =$('#TRN').val();
		   var emirates_id  = $("#emirates_id").val();
		   var email  = $("#email").val();

		   $.ajax({
			   type: 'POST',
			   url: '{!!url('/reception/service/customeradd')!!}',
			    data: new FormData(this),
				headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
				contentType: false,
				cache: false,
				processData:false,

			   success:function(data)
			   {

                   var call_var_customeradd = define_variable();


                   var data = {
                       id: data,
                       text: call_var_customeradd.name
                   };

                   var newOption = new Option(data.text, data.id, false, false);
                   $('#customer_select').append(newOption).trigger('change');



                   var name =$('#name').val('');
                   var contact_no =$('#contact_no').val('');
                   var TRN =$('#TRN').val('');
                   var emirates_id  = $("#emirates_id").val('');
                   var email  = $("#email").val('');

					$(".addcustomermsg").removeClass("hide");

			   },
			    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }

		   });

		}
		}));



	</script>
<!-- customer model state to city -->

<!-- Vehicle add -->
<script>
$('body').on('click','.vehiclemodel',function(){
	$('#vehiclemodel').model();
});
</script>

<!-- images show in multiple in for loop -->



<!-- vehicle add -->
<script>
$('body').on('click','.addvehicleservice',function(event){
	function define_variable()
		{

			return {
                vehical_type:$("#vehical_type").val(),
                chasicno1:$("#chasicno1").val(),
                color:$("#color").val(),
                modelname1:$("#modelname1").val(),
                carNumber:$("#carNumber").val(),
			};
		}
			event.preventDefault();
			var call_var_vehicleadd = define_variable();
			var errro_msg = [];
			//Vehicle type
			if(call_var_vehicleadd.vehical_type == "")
			{
				var msg = "Vehicle Type is required";
				$('#errorlvehical_type').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorlvehical_type').html("");
				errro_msg = [];
			}
			//chasic number
			if(call_var_vehicleadd.chasicno1 == "")
			{
				var msg = "Chassis number is required";
				$('#errorlchasicno1').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorlchasicno1').html("");
				errro_msg = [];
			}
			//Vehical Color
			if(call_var_vehicleadd.color == "")
			{
				var msg = "Vehicle Color is required";
				$('#errorcolor').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorcolor').html("");
				errro_msg = [];
			}
			//Model name
			if(call_var_vehicleadd.modelname1 == "")
			{
				var msg = "Model Name is required";
				$('#errorlmodelname1').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorlmodelname1').html("");
				errro_msg = [];
			}
			//Engine number
			if(call_var_vehicleadd.carNumber == "")
			{
				var msg = "Car number is required";
				$('#errorcarNumber').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorcarNumber').html("");
				errro_msg = [];
			}
		if(errro_msg =="")
		{

            var company_hide = $('#company_form').is(":visible");


			var vehical_type =$('#vehical_type').val();
			var chasicno1 =$('#chasicno1').val();
			var color =$('#color').val();
			var modelname1 =$('#modelname1').val();
			var carNumber =$('#carNumber').val();

			$.ajax({

				type:'get',
				url:'{!! url('reception/service/vehicleadd')!!}',
				data:{chasicno1:chasicno1,vehical_type:vehical_type,color:color,modelname1:modelname1,carNumber:carNumber},
				success: function(data){

					var modelname1 =$('#modelname1').val();


                    var data = {
                        id: data,
                        text: call_var_vehicleadd.carNumber
                    };

                    var newOption = new Option(data.text, data.id, false, false);
                    $('#vhi').append(newOption).trigger('change');






                    var vehical_type =$('#vehical_type').val('');
                    var chasicno1 =$('#chasicno1').val('');
                    var color =$('#color').val('');
                    var modelname1 =$('#modelname1').val('');
                    var carNumber =$('#carNumber').val('');
					$(".addvehiclemsg").removeClass("hide");


				},
				error: function(e){
					alert("An error occurred: " + e.responseText);
							console.log(e);
				}
			});
		}

});
</script>


<!-- Datepicker---->
  <script type="text/javascript">
    $(".datepicker").datetimepicker({
		 format: "<?php echo getDatetimepicker(); ?>",
		 autoclose:1,
    });
 </script>
<script type="text/javascript">
    $(".datepickercustmore").datetimepicker({
		format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
		endDate: new Date(),
	});
</script>
<script>
    $('.datepicker1').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });
</script>
<script>
    $('#myDatepicker2').datetimepicker({
       format: "yyyy",
		autoclose: 2,
		minView: 4,
		startView: 4,

    });
</script>
<script>
    $(function() {
        $("input[name='hasInsurance']").click(function () {
            if ($("#yes_option").is(":checked")) {
                $("#insurance").show();
                $("#LPO").show();
                $("#charge_required").attr('required', true);
            } else {
                $("#insurance").hide();
                $("#LPO").hide();
				$("#charge_required").removeAttr('required', false);
            }
        });
    });
</script>

<script>
    $(function() {
        $("input[name='customer_type']").click(function () {
            if ($("#customer_cash").is(":checked")) {
                $("#customer_form").show();
                $("#company_form").hide();
                $("#insurance").hide();
                $("#company_details").hide();
            }
            else if ($("#customer_insurance").is(":checked")){
                $("#customer_form").show();
                $("#company_form").hide();
                $("#insurance").show();
                $("#company_details").hide();
            }
            else if ($("#company").is(":checked")){
                $("#customer_form").show();
                $("#company_form").show();
                $("#customer_company").show();
                $("#insurance").hide();
                $("#company_details").show();
            }
            else if ($("#company_insurance").is(":checked")){
                $("#customer_form").show();
                $("#company_form").show();
                $("#insurance").show();
                $("#company_details").show();
                $("#customer_company").show();
            }
        });
    });
</script>


<script>

$(document).ready(function(){

	$('body').on('change','.select_vhi',function(){

		var url = $(this).attr('cus_url');
		var cus_id = $(this).val();
		var modelnms = $(this).val();

		$.ajax({

			type:'GET',
			url:url,
			data:{cus_id:cus_id,modelnms:modelnms},
			success:function(response)
			{
                $('#customer_name').val(response.name);
                $('#customer_TRN').val(response.TRN);
                $('#customer_contact_no').val(response.contact_no);
                $('#customer_email').val(response.email);
			}

		});
	});

    $('body').on('change','.select_vhi_com',function(){

        var url = $(this).attr('cus_url');
        var cus_id = $(this).val();
        var modelnms = $(this).val();

        $.ajax({

            type:'GET',
            url:url,
            data:{cus_id:cus_id,modelnms:modelnms},
            success:function(response)
            {

                $('#company_name').val(response.name);
                $('#company_TRN').val(response.TRN);
                $('#company_contact_no').val(response.contact_no);
                $('#company_email').val(response.email);
            }

        });
    });


	$('body').on('change','#vhi',function(){

        var url = $(this).attr('vhi_url');
        var vhi_id = $(this).val();

        $.ajax({

            type:'GET',
            url:url,
            data:{vhi_id:vhi_id},
            success:function(response)
            {

                $('#vehicle_modelname').val(response.modelname);
                $('#vehicle_carNumber').val(response.carNumber);
                $('#vehicle_chassisno').val(response.chassisno);
                $('#vehicle_color').val(response.color);
            }

        });

	});



});
</script>

    <script type="text/JavaScript">

   $(document).ready(function(){
	// Initialize select2
	$("#vhi").select2();
	$("#customer_select").select2();
	$("#company_select").select2();
	$("#company_select2").select2();
	});

</script>

    <script>

   $(document).ready(function(){
       $('.select2').css("min-width","100%");
	});

</script>

<!-- Fuel type -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Fuel  Type delete-->
@endsection

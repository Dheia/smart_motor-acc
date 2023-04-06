<?php

namespace App\Http\Controllers\Reception;

use Illuminate\Http\Request;
use App\tbl_vehicles;
use App\tbl_services;
use App\tbl_service_pros;
use App\tbl_jobcard_details;
use App\users;
use App\tbl_service_observation_points;
use App\Http\Requests;
use DB;
use Auth;
use App\tbl_points;
use App\tbl_vehicle_colors;
use App\tbl_vehicle_discription_records;
use App\tbl_vehicle_images;
use App\User;
use Mail;
use DateTime;
use Illuminate\Mail\Mailer;
use App\tbl_mail_notifications;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class ServicesControler extends Controller
{
	 //  get tables and compact
    public function __construct()
    {
        $this->middleware('Reception');
    }


    //service add form
	public function index()
	{
        $customer_id = '';
        $customer_name = '';
        $customer_contact_no = '';
        $customer_TRN = '';
        $customer_email = '';

        $vehicle_id = '';
        $vehicle_modelname = '';
        $vehicle_carNumber = '';
        $vehicle_color = '';
        $vehicle_chassisno = '';

       $characters = '0123456789';
       $code =  'J'.''.substr(str_shuffle($characters),0,6);
	   $employee=DB::table('users')->where('role','Quality Control')->get()->toArray();
	   //Customer add
	   $customer=DB::table('users')->where('role','Customer')->get()->toArray();
	   $companies=DB::table('users')->where('role','Company')->get()->toArray();
	   $insurances=DB::table('insurances')->get()->toArray();
       // $customer=DB::table('tbl_sales')->groupBy('customer_id')->get();
	   $country = DB::table('tbl_countries')->get()->toArray();
	   $onlycustomer=DB::table('users')->where([['role','=','Customer']])->first();


        $vehicles = DB::table('tbl_vehicles')->get();


        return view('reception-view.service.add',compact('employee','customer','code','country','onlycustomer','companies','insurances','vehicles','customer_id','customer_name','customer_TRN','customer_email','vehicle_id','vehicle_modelname','vehicle_carNumber','vehicle_color','vehicle_chassisno','customer_contact_no'));
	}

	public function open($id)
	{
        $jobcard =DB::table('tbl_services')->where('id',$id)->first();

        $customer_jobcard = User::find($jobcard->customer_id);
        $customer_id = $customer_jobcard->id;
        $customer_name = $customer_jobcard->name.' '.$customer_jobcard->lastname;
        $customer_TRN = $customer_jobcard->TRN;
        $customer_contact_no = $customer_jobcard->contact_no;
        $customer_email = $customer_jobcard->email;

        $vehicle_jobcard = DB::table('tbl_vehicles')->where('id',$jobcard->vehicle_id)->first();

        $vehicle_id = $vehicle_jobcard->id;
        $vehicle_modelname = $vehicle_jobcard->modelname;
        $vehicle_carNumber = $vehicle_jobcard->carNumber;
        $vehicle_color = $vehicle_jobcard->color;
        $vehicle_chassisno = $vehicle_jobcard->chassisno;


       $characters = '0123456789';
       $code =  'J'.''.substr(str_shuffle($characters),0,6);
	   $employee=DB::table('users')->where('role','Quality Control')->get()->toArray();
	   //Customer add
	   $customer=DB::table('users')->where('role','Customer')->get()->toArray();
	   $companies=DB::table('users')->where('role','Company')->get()->toArray();
	   $insurances=DB::table('insurances')->get()->toArray();
	   $country = DB::table('tbl_countries')->get()->toArray();
	   $onlycustomer=DB::table('users')->where([['role','=','Customer']])->first();
		//vehicle add

        $vehicles = DB::table('tbl_vehicles')->get();


        return view('reception-view.service.add',compact('employee','customer','code','country','onlycustomer','companies','insurances','vehicles','customer_id','customer_name','customer_TRN','customer_email','vehicle_id','vehicle_modelname','vehicle_carNumber','vehicle_color','vehicle_chassisno','customer_contact_no'));
	}
	//customer add
	public function customeradd(Request $request)
	{



        $name=Input::get('name');
        $TRN=Input::get('TRN');
        $emirates_id=Input::get('emirates_id');

        $contact_no=Input::get('contact_no');
        $email=Input::get('email');
        $company_id=Input::get('companyCustomer');
        if (empty($email))
        {
            $email = null;
        }
        if (empty($company_id))
        {
            $company_id = null;
        }

        $contact_no = '971'.$contact_no;

        $customer = new User;
        $customer->name=$name;
        $customer->TRN=$TRN;
        $customer->contact_no=$contact_no;
        $customer->emirates_id=$emirates_id;
        $customer->email=$email;
        $customer->company_id=$company_id;
        $customer->role="Customer";
        $customer->timezone="UTC";
        $customer -> save();
        echo $customer->id;
	}

	public function companyadd(Request $request)
	{



        $name=Input::get('company_name');
        $TRN=Input::get('company_TRN');
        $address=Input::get('company_address');

        $contact_no=Input::get('company_contact_no');
        $email=Input::get('company_email');
        if (empty($email))
        {
            $email = null;
        }

        $customer = new User;
        $customer->name=$name;
        $customer->TRN=$TRN;
        $customer->contact_no=$contact_no;
        $customer->address=$address;
        $customer->email=$email;
        $customer->role="Company";
        $customer->timezone="UTC";
        $customer -> save();
        echo $customer->id;
	}

	//add vehicle
	public function vehicleadd()
	{
		$vehical_type=Input::get('vehical_type');
		$chasicno=Input::get('chasicno1');
		$color=Input::get('color');
		$modelname=Input::get('modelname1');
		$carNumber=Input::get('carNumber');


		$vehical = new tbl_vehicles;
		$vehical->vehicletype_id=$vehical_type;
		$vehical->chassisno =$chasicno;
		$vehical->modelname  =$modelname;
		$vehical->color  =$color;
		$vehical->carNumber  =$carNumber;
		$vehical-> save();

		echo $vehical->id;


	}
	//get regi. number
	public function getregistrationno()
	{
		$vehi_id = Input::get('vehi_id');

		$vehicals = DB::table('tbl_sales')->where('vehicle_id','=',$vehi_id)->first();
		if(!empty($vehicals))
		{
			$reg = $vehicals->registration_no;
		}
		else
		{
			$vehicals = DB::table('tbl_vehicles')->where('id','=',$vehi_id)->first();
			$reg = $vehicals->registration_no;
		}
		return $reg;
	}

	//get vehicle name
	public function get_vehicle_name()
	{
		$cus_id = Input::get('cus_id');
		$vehicals = DB::table('tbl_vehicles')->where('user_id','=',$cus_id)->get()->toArray();

		// $vehicals = DB::SELECT("SELECT  tbl_sales.vehicle_id,tbl_services.vehicle_id FROM tbl_services LEFT JOIN tbl_sales ON tbl_sales.customer_id = tbl_services.customer_id where tbl_services.customer_id = 35 OR tbl_sales.customer_id=35;");
		// var_dump($vehicals);
		// exit;
		?>
		<?php foreach($vehicals as $vehical) { ?>
			<option value="<?php echo $vehical->id;?>" class="modelnms"><?php echo $vehical->carNumber;?></option>
		<?php } ?>
		<?php

	}

    public function get_user_data()
    {
        $cus_id = Input::get('cus_id');
        $user = User::find($cus_id);
        return response()->json([
            'id' => $user?$user->id:'',
            'name' => $user?$user->name.' '.$user->name:'',
            'TRN' => $user?$user->TRN:'',
            'contact_no' => $user?$user->contact_no:'',
            'email' => $user?$user->email:'',
        ]);

    }

    public function get_vehicle_data()
    {
        $vhi_id = Input::get('vhi_id');
        $vehical = DB::table('tbl_vehicles')->where('id','=',$vhi_id)->first();
        return response()->json([
            'id' => $vehical?$vehical->id:'',
            'modelname' => $vehical?$vehical->modelname:'',
            'carNumber' => $vehical?$vehical->carNumber:'',
            'chassisno' => $vehical?$vehical->chassisno:'',
            'color' => $vehical?$vehical->color:'',
        ]);

    }

	//add_jobcard store
	public function add_jobcard()
	{
		$job_no = Input::get('job_no');
		$service_id = Input::get('service_id');
		if(getDateFormat() == 'm-d-Y')
		{
			$in_dat=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('in_date'))));
			$out_dat=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('out_date'))));
		}
		else
		{
			$in_dat=date('Y-m-d H:i:s',strtotime(Input::get('in_date')));
			$out_dat=date('Y-m-d H:i:s',strtotime(Input::get('out_date')));
		}
		$cus_id = Input::get('cust_id');
		$vehi_id = Input::get('vehi_id');
		$kms = Input::get('kms');
		$coupan_no = Input::get('coupan_no');

		$product = Input::get('product');
		$sub_product = Input::get('sub_product');
		$comment = Input::get('comment');
		$obs_auto_id = Input::get('obs_id');
			if(!empty($product))
			{
				foreach($product as $key => $value)
				{
					$category = $product[$key];
					$sub = $sub_product[$key];
					$comm = $comment[$key];
					$obs_au_id = $obs_auto_id[$key];

					$tbl_service_pros = new tbl_service_pros;
					$tbl_service_pros->service_id = $service_id;
					$tbl_service_pros->category = $category;
					$tbl_service_pros->obs_point = $sub;
					$tbl_service_pros->category_comments = $comm;
					$tbl_service_pros->tbl_service_observation_points_id = $obs_au_id;
					$tbl_service_pros->save();
				}
			}
		$tbl_jobcard_details = new tbl_jobcard_details;
		$tbl_jobcard_details->customer_id = $cus_id;
		$tbl_jobcard_details->vehicle_id = $vehi_id;
		$tbl_jobcard_details->service_id = $service_id;
		$tbl_jobcard_details->jocard_no = $job_no;
		$tbl_jobcard_details->in_date = $in_dat;
		$tbl_jobcard_details->out_date = $out_dat;
		$tbl_jobcard_details->kms_run = $kms;
		if(!empty($coupan_no))
		{
		$tbl_jobcard_details->coupan_no = $coupan_no;
		}
		$tbl_jobcard_details->save();

		//email format
		$user=DB::table('users')->where('id','=',$cus_id)->first();
		$email=$user->email;
		$firstname=$user->name;
		$logo = DB::table('tbl_settings')->first();
		$systemname=$logo->system_name;
		$servicedetails=DB::table('tbl_services')->where('job_no','=',$job_no)->first();
		$details=$servicedetails->detail;
		$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','successful_jobcard')->first();
		if($emailformats->is_send == 0)
		{
			if($tbl_jobcard_details->save())
			{
				$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','successful_jobcard')->first();
				$mail_format = $emailformat->notification_text;
				$mail_subjects = $emailformat->subject;
				$mail_send_from = $emailformat->send_from;
				$search1 = array('{ jobcard_number }');
				$replace1 = array($job_no);
				$mail_sub = str_replace($search1, $replace1, $mail_subjects);

				$search = array('{ system_name }','{ Customer_name }', '{ jobcard_number }', '{ service_date }', '{ detail }');
				$replace = array($systemname, $firstname, $job_no, $in_dat,$details);

				$email_content = str_replace($search, $replace, $mail_format);
				$actual_link = $_SERVER['HTTP_HOST'];
				$startip='0.0.0.0';
				$endip='255.255.255.255';
				if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
				{
					//local format email

					$data=array(
					'email'=>$email,
					'mail_sub1' => $mail_sub,
					'email_content1' => $email_content,
					'emailsend' =>$mail_send_from,
					);
					$data1 =	Mail::send('customer.customermail',$data, function ($message) use ($data){

							$message->from($data['emailsend'],'noreply');

							$message->to($data['email'])->subject($data['mail_sub1']);
						});
				}
				else
				{
					//live format email

					$headers = 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
					$headers .= 'From:'. $mail_send_from . "\r\n";

					$data = mail($email,$mail_sub,$email_content,$headers);
				}

				}

		}
		return redirect('/reception/jobcard/list')->with('message','Successfully Submitted');
	}

	//jobcard store
	public function store(Request $request)
    {

	  $job=Input::get('job_no');
      $vehicalnumber = Input::get('vehicalnumber');
      $Customername = Input::get('Customername');

      if ($Customername =="")
      {
          $Customername = Input::get('Companyname');
      }


      $accident_no = Input::get('accident_no');
      $AssigneTo = Input::get('AssigneTo');
      $reference_no = Input::get('reference_no');
      $job_type = Input::get('customer_type');
      $insurance_id = Input::get('insurance_id');
      $claim_no = Input::get('claim_no');
      $received_date = Input::get('received_date');
      $LPO = Input::get('LPO');
      $LPO_Date = Input::get('LPO_Date');


      $services= new tbl_services;
      $services->job_no=$job;
      $services->vehicle_id=$vehicalnumber;
      $services->service_date=$received_date;
      $services->LPO=$LPO;
      $services->LPO_Date=$LPO_Date;
      $services->assign_to=$AssigneTo;
      $services->accident_no=$accident_no;
      $services->reference_no=$reference_no;
      $services->job_type=$job_type;
      $services->insurance_id=$insurance_id;
      $services->customer_id=$Customername;
      $services->claim_no=$claim_no;
      $services->reception_id=auth('reception')->user()->id;
      $services->save();

      return redirect('/reception/jobcard/list')->with('message','Successfully Submitted');

    }

	//select checkpoints
	public function select_checkpt()
	{
		$value = Input::get('value');
		$id = Input::get('id');
		$service_id = Input::get('service_id');

		 $datas = DB::table('tbl_service_observation_points')->where([['services_id','=',$service_id],['observation_points_id','=',$id]])->first();

			if(!empty($datas))
			{
				$review = $datas->review;

				if($review == 1)
				{
					DB::update("update tbl_service_observation_points set review = 0 where services_id='$service_id' and observation_points_id='$id'");
				}
				else
				{
					DB::update("update tbl_service_observation_points set review = 1 where services_id='$service_id' and observation_points_id='$id'");
				}
			}
			else
			{
				$data = new tbl_service_observation_points;
				$data->services_id = $service_id;
				$data->observation_points_id = $id;
				$data->review = $value;
				$data->save();
			}
	}

	//get obs. points
	public function Get_Observation_Pts()
	{
		$s_id = Input::get('service_id');
		$product = DB::table('tbl_products')->get();
		$data = DB::table('tbl_points')
					->join('tbl_service_observation_points', 'tbl_service_observation_points.observation_points_id', '=', 'tbl_points.id')
					->where([['tbl_service_observation_points.services_id', '=', $s_id],['review','=',1]])
					->select('tbl_points.*', 'tbl_service_observation_points.id')
					->get()->toArray();
		$html = view('service.observationpoin')->with(compact('s_id','product','data'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}

	//service list
    public function servicelist()
    {
		$month = date('m');
		$year = date('Y');

		$start_date = "$year/$month/01";
		$end_date = "$year/$month/30";
		$current_month= DB::select("SELECT service_date FROM tbl_services where service_date BETWEEN  '$start_date' AND '$end_date'");

		   if(!empty($current_month))
		   {
			 foreach ($current_month as $list)
				   {
					 $date[] = $list->service_date;
				   }

				$available = json_encode($date);
			}

		$ser_id_jobcard_details = DB::table('tbl_jobcard_details')->get()->toArray();
		foreach($ser_id_jobcard_details as $ser_id)
		{
		  $servi_id = $ser_id->service_id;
		}

		$userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			$service=DB::table('tbl_services')->where('job_no','like','J%')->orderBy('id','DESC')->get()->toArray();
		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			$service=DB::table('tbl_services')->where([['job_no','like','J%'],['assign_to','=',Auth::User()->id]])->orderBy('id','DESC')->get()->toArray();
		}
		else
		{
			$service=DB::table('tbl_services')->where([['job_no','like','J%'],['customer_id','=',Auth::User()->id]])->orderBy('id','DESC')->get()->toArray();

	    }
		return view('/service/list',compact('service','selectdate','available','current_month','servi_id'));

    }

	//service delete
	public function destory($id)
	{
		$service1=DB::table('tbl_jobcard_details')->where('service_id','=',$id)->first();
		$tbl_invoices1=DB::table('tbl_invoices')->where('sales_service_id','=',$id)->first();
		if(!empty($tbl_invoices1))
		{
			$in_id=$tbl_invoices1->id;
			$tbl_payment_records=DB::table('tbl_payment_records')->where('invoices_id','=',$in_id)->delete();
			$tbl_invoices=DB::table('tbl_invoices')->where('id','=',$in_id)->first();
			$invoice_no=$tbl_invoices->invoice_number;
			$incomes_id=DB::table('tbl_incomes')->where('invoice_number','=',$invoice_no)->first();
			if(!empty($incomes_id))
			{
			$incomeid=$incomes_id->id;
			$tbl_incomes=DB::table('tbl_income_history_records')->where('tbl_income_id','=',$incomeid)->delete();
			$tbl_incomes=DB::table('tbl_incomes')->where('invoice_number','=',$invoice_no)->delete();
			}

		}
		if(!empty($service1))
		{
		$jobid=$service1->jocard_no;
		$tbl_gatepasses=DB::table('tbl_gatepasses')->where('jobcard_id','=',$jobid)->delete();
		}
		$tbl_jobcard_details=DB::table('tbl_jobcard_details')->where('service_id','=',$id)->delete();
		$tbl_service_pros=DB::table('tbl_service_pros')->where('service_id','=',$id)->delete();
		$tbl_invoices=DB::table('tbl_invoices')->where('sales_service_id','=',$id)->delete();
		$tbl_services=DB::table('tbl_services')->where('id','=',$id)->delete();

		return redirect('/reception/service/list')->with('message','Successfully Deleted');
	}

	//service edit
   public function serviceedit($id)
   {
     $vehical = DB::table('tbl_vehicles')->get()->toArray();
     $employee = DB::table('users')->where('role','employee')->get()->toArray();
     $customer = DB::table('users')->where('role','Customer')->get()->toArray();
     $service = DB::table('tbl_services')->where('id','=',$id)->first();
	 $cus_id = $service->customer_id;
	 $vah_id = $service->vehicle_id;
     $tbl_sales = DB::table('tbl_sales')->where('vehicle_id',$vah_id)->first();
	 if(!empty($tbl_sales))
	 {
		$regi = DB::table('tbl_sales')->where('customer_id',$cus_id)->first();
	 }
	 else
	 {
		$regi = DB::table('tbl_vehicles')->where('id',$vah_id)->first();
	 }

   	return view('/service/edit',compact('service','vehical','employee','customer','regi'));
   }

   //service update
   public function serviceupdate(Request $request, $id)
   {
	  $this->validate($request, [
         'charge' => 'nullable|numeric',
	      ]);
      $job=Input::get('jobno');
      $vehicalname=Input::get('vehicalname');
	  if(getDateFormat()== 'm-d-Y')
	  {
		$date=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('date'))));
	  }
	  else
	  {
		$date=date('Y-m-d H:i:s',strtotime(Input::get('date')));
	  }
      $title=Input::get('title');
      $AssigneTo=Input::get('AssigneTo');
	  $service_category = Input::get('repair_cat');
      $donestatus=Input::get('donestatus');
	  $ser_type=Input::get('service_type');

	   if($ser_type=='free')
	   {
		 $charge="0";
	   }
	   if($ser_type=='paid')
	  {
		$charge=Input::get('charge');
	  }

      $Customername=Input::get('Customername');
      $details=Input::get('details');

      $services= tbl_services::find($id);

      $services->job_no=$job;
      $services->vehicle_id=$vehicalname;
      $services->service_date=$date;
      $services->title=$title;
      $services->assign_to=$AssigneTo;
      $services->service_category=$service_category;
      $services->charge=$charge;

	  $tblservice=DB::table('tbl_services')->where('id','=',$id)->first();
	  $status=$tblservice->done_status;
	  if($status == 0)
	  {
      $services->done_status=0;
	  }elseif($status == 1)
	  {
		$services->done_status=1;
	  }elseif($status == 2)
	  {
		$services->done_status=2;
	  }
      $services->customer_id=$Customername;
      $services->detail=$details;
      $services->service_type=$ser_type;
      $services->save();
      return redirect('/reception/service/list')->with('message','Successfully Updated');;

   }

	//get used coupon data
   public function Used_Coupon_Data()
   {
		$cpn_no = Input::get('coupon_no');

		$used_cpn_data = DB::table('tbl_jobcard_details')->where('coupan_no',$cpn_no)->first();
		$status = $used_cpn_data->done_status;
		$jb_no = $used_cpn_data->jocard_no;

		$vhi_no = DB::table('tbl_services')->where('job_no',$cpn_no)->first();
		$vehi_name = $vhi_no->vehicle_id;
		$regi = DB::table('tbl_sales')->where('vehicle_id',$vehi_name)->first();
		$ser_tab = DB::table('tbl_services')->where('job_no',$jb_no)->first();
		$logo = DB::table('tbl_settings')->first();

		if(!empty($used_cpn_data))
		{
			$service_id = $used_cpn_data->service_id;
			$cus_id = $used_cpn_data->customer_id;
			$custo_info = DB::table('users')->where('id',$cus_id)->first();
			$mob = $custo_info->mobile_no;
			$city = $custo_info->city_id;
			$state = $custo_info->state_id;
			$country = $custo_info->country_id;

			$all_data = DB::table('tbl_service_pros')->where([['service_id',$service_id],['type','=',0]])->get()->toArray();
			$all_data2 = DB::table('tbl_service_pros')->where([['service_id',$service_id],['type','=',1]])->get()->toArray();
		}

		$html = view('reception-view.service.couponmodel')->with(compact('service_id','custo_info','logo','mob','custo_info','status','vehi_name','regi','city','state','country','all_data','all_data2','used_cpn_data','vhi_no','ser_tab','cpn_no'))->render();
		return response()->json(['success' => true, 'html' => $html]);
   }

   //service modal view
   public function serviceview()
   {
		$ser_id = Input::get('servicesid');


		$vhi_no = DB::table('tbl_services')->where('id',$ser_id)->first();
		$vehi_name = $vhi_no->vehicle_id;
		$cus_id = $vhi_no->customer_id;

		$tbl_sales = DB::table('tbl_sales')->where('vehicle_id',$vehi_name)->first();
		 if(!empty($tbl_sales))
		 {
			$regi = DB::table('tbl_sales')->where('vehicle_id',$vehi_name)->first();
		 }
		 else
		 {
			$regi = DB::table('tbl_vehicles')->where('id',$vehi_name)->first();
		 }
		$logo = DB::table('tbl_settings')->first();
		$custo_info = DB::table('users')->where('id',$cus_id)->first();

		// $mob = $custo_info->mobile_no;
		// $city = $custo_info->city_id;
		// $state = $custo_info->state_id;
		// $country = $custo_info->country_id;
		$used_cpn_data = DB::table('tbl_jobcard_details')->where('service_id',$ser_id)->first();
		if(!empty($used_cpn_data))
		{
			$status = $used_cpn_data->done_status;
			$service_id = $used_cpn_data->service_id;
			// $cus_id = $used_cpn_data->customer_id;



			$all_data = DB::table('tbl_service_pros')->where([['service_id',$service_id],['type','=',0]])->get()->toArray();
			$all_data2 = DB::table('tbl_service_pros')->where([['service_id',$service_id],['type','=',1]])->get()->toArray();
		}

		$html = view('service.servicemodel')->with(compact('service_id','custo_info','logo','mob','custo_info','status','vehi_name','regi','city','state','country','all_data','all_data2','used_cpn_data','vhi_no',''))->render();
		return response()->json(['success' => true, 'html' => $html]);
   }
}

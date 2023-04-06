<?php

namespace App\Http\Controllers\Reception;

use Illuminate\Http\Request;
use App\User;
use App\tbl_products;
use App\tbl_sales;
use App\tbl_services;
use App\tbl_jobcard_details;
use App\tbl_vehicles;
use App\tbl_business_hours;
use App\Http\Requests;
use DB;
use Auth;
use Mail;
use Illuminate\Mail\Mailer;
use App\tbl_mail_notifications;
use DateTime;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Config;
use App\Http\Controllers\Controller;

class homecontroller extends Controller
{



    public function dashboard()
    {

		$set_email_send = Session::get('email_sended');





		$logo = DB::table('tbl_settings')->first();
		$systemname=$logo->system_name;
		//Email notification for last monthly service for admin


		if(!empty($datediff))
		{
			foreach($datediff as $datediffs)
			{
			$days = $datediffs->days;
			if($days == 0)
			{
				$one_day = $datediffs->counts;

			}
			if($days == 1)
			{
				$two_day = $datediffs->counts;

			}
			if($days >1)
			{
				$more = $datediffs->counts;

			}
			}

		}

		$userid= auth('reception')->id();

		if(!empty(getActiveCustomer($userid)=='yes'))
		{

			 //count employee,customer,supplier,product,sales,service
            $roles = ['Reception','Head of Section','Quality Control'];
			$employee =DB::table('users')->whereIn('role', $roles)->count();
			$Customer =DB::table('users')->where('role','=','Customer')->count();
			$Supplier =DB::table('users')->where('role','=','Supplier')->count();
			$product =DB::table('services')->count();
			$sales =DB::table('tbl_sales')->count();
			$service =DB::table('sections')->count();

			//free service
			$sale=DB::table('tbl_services')
										// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
										// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
										->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])->orderBy('tbl_services.id','=','desc')->take(5)
										->select('tbl_services.*')
										->get()->toArray();
			//Paid service
			$sale1=DB::table('tbl_services')
										// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
										// ->join('tbl_vehicles', 'tbl_vehicles.id', '=', 'tbl_services.vehicle_id')
										// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
										->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])->orderBy('tbl_services.id','=','desc')->take(5)
										->select('tbl_services.*')
										->get()->toArray();
			//Repeat job service
			$sale2=DB::table('tbl_services')
										// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
										// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
										->where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									   ->orderBy('tbl_services.id','=','desc')->take(5)
										->select('tbl_services.*')
										->get()->toArray();
			//Recent join customer
			$Customere =DB::table('users')->where('role','=','Customer')->orderBy('id','=','desc')->take(5)->get()->toArray();

			//Calendar Events
			$serviceevent=DB::table('tbl_services')->where('tbl_services.done_status','!=',2)->get()->toArray();

			//holiday show Calendar
			$holiday =DB::table('tbl_holidays')->ORDERBY('date','ASC')->get()->toArray();
		}

         return view('reception-view.dashboard.dashboard',compact('employee','Customer','Supplier','product','sales','service','Customere','sale','sale1','sale2','serviceevent','one_day','two_day','more','holiday'));

    }

	//free service modal
    public function openmodel()
    {
		$serviceid = Input::get('open_id');

		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();

		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;

		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();

		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();

		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();

		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->get()->toArray();

		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();

		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();

		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
		  $service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
		  $service_taxes='';
		}
		$discount = $service_tax->discount;

		$logo = DB::table('tbl_settings')->first();

		$html = view('dashboard.freeservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);

	}

	//paid service modal
    public function closemodel()
    {
		$serviceid = Input::get('open_id');

		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();

		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;

		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();

		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();

		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();

		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->where('chargeable','=',1)
												  ->get()->toArray();

		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();

		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get();

		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes="";
		}
		$discount = $service_tax->discount;
		$logo = DB::table('tbl_settings')->first();


		$html = view('dashboard.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','service_taxes','discount'))->render();
		return response()->json(['success' => true, 'html' => $html]);

	}

	//repeat service modal
    public function upmodel()
    {
		$serviceid = Input::get('open_id');

		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();

		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;

		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();

		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();

		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();

		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->get()->toArray();

		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();

		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();

		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes="";
		}
		$discount = $service_tax->discount;

		$logo = DB::table('tbl_settings')->first();


		$html = view('dashboard.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);

	}
}

<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Auth;
use App\tbl_incomes;
use App\tbl_income_history_records;
use App\tbl_invoices;
use App\tbl_payment_records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Session;
use PDF;

class IncomeController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	//income add form
    public function index()
    {
		$invoice_no = DB::table('tbl_incomes')->get()->toArray();
		$invoices = array();
		foreach($invoice_no as $invoicess)
		{
			$invoices[] = $invoicess->invoice_number;
		}
		// $left_invoice = DB::table('tbl_invoices')->whereNotIn('tbl_invoices.invoice_number',$invoices)->get();
		$left_invoice = DB::table('tbl_invoices')->get()->toArray();
		$characterss = '0123456789';
		$codepay =  'P'.''.substr(str_shuffle($characterss),0,6);
		$tbl_payments = DB::table('tbl_payments')->get()->toArray();
		return view('income.add',compact('left_invoice','codepay','tbl_payments'));
    }

	//income store
	public function store(Request $request)
	{

		$Total_Amount=Input::get('Total_Amount');

		$income_entry = Input::get('income_entry');
		$amount_recevied1=0;
		if(!empty($income_entry))
		{
			foreach($income_entry as $key => $value)
			{
				$income_entr = $income_entry[$key];
				$amount_recevied1 +=$income_entr;
			}
		}


	if($Total_Amount >= $amount_recevied1)
	{
		 if(getDateFormat()== 'm-d-Y')
		{
			$dates=date('Y-m-d',strtotime(str_replace('-','/',Input::get('date'))));
		}
		else
		{
			$dates=date('Y-m-d',strtotime(Input::get('date')));
		}
		$invoiceno=Input::get('invoice');
		$tbl_invoices = DB::table('tbl_invoices')->where('invoice_number','=',$invoiceno)->first();
		$customer_id=$tbl_invoices->customer_id;
		$tbl_incomes = new tbl_incomes;
		$tbl_incomes->invoice_number = Input::get('invoice');
		$tbl_incomes->payment_number = Input::get('paymentno');
		$tbl_incomes->customer_id = $customer_id;
		$tbl_incomes->status = Input::get('status');
		$tbl_incomes->payment_type = Input::get('Payment_type');
		$tbl_incomes->date =$dates;

		$tbl_incomes->main_label = Input::get('main_label');
		$tbl_incomes->save();

		$income_entry = Input::get('income_entry');
		$income_label = Input::get('income_label');

		$total1=0;
		foreach($income_entry as $key => $value)
		{
			$income_entr = $income_entry[$key];

			$income_lbls = $income_label[$key];

			$tbl_income_id = DB::table('tbl_incomes')->orderBy('id','DESC')->first();

			$tbl_income_history_records = new tbl_income_history_records;
			$tbl_income_history_records->tbl_income_id = $tbl_income_id->id;
			$tbl_income_history_records->income_amount = $income_entr;
			$tbl_income_history_records->income_label = $income_lbls;
			$tbl_income_history_records->save();
			$total1 += $income_entr;
		}

		$tbl_invoices = DB::table('tbl_invoices')->where('invoice_number','=',$invoiceno)->first();
		$id=$tbl_invoices->id;
		$paid_amount=$tbl_invoices->paid_amount;
		$grandtotal=$tbl_invoices->grand_total;
		$total=$paid_amount + $total1;


		$tblin = tbl_invoices::find($id);
		$tblin->paid_amount =$total;
		if($grandtotal == $total )
		{
			$status=2;
			$tblin->payment_status =$status;

		}elseif($grandtotal > $total && $total > 0)
		{
			$status=1;
			$tblin->payment_status =$status;

		}elseif($total == 0)
		{
			$status=0;
			$tblin->payment_status =$status;
		}
		$tblin->save();

		$tbl_payment_records = new  tbl_payment_records;
		$tbl_payment_records->invoices_id = $id;
		$tbl_payment_records->payment_number = Input::get('paymentno');
		$tbl_payment_records->amount = $total1;
		$tbl_payment_records->payment_type = Input::get('Payment_type');
		$tbl_payment_records->payment_date = $dates;
		$tbl_payment_records->save();

		return redirect('/admin/income/list')->with('message','Successfully Submitted');
	}
    else
	{
		return redirect('/admin/income/add')->with('message','amount');
	}
    }

	//income list
    public function showall()
    {
		$income = DB::table('tbl_incomes')
					->join('tbl_income_history_records','tbl_incomes.id','=','tbl_income_history_records.tbl_income_id')
					->groupBy('tbl_income_history_records.tbl_income_id')
					->orderBy('tbl_incomes.id','DESC')
					->select('tbl_incomes.*', 'tbl_income_history_records.*')
					->get()->toArray();
        return view('income.list',compact('income'));
    }

	//income edit
    public function edit($id)
    {
        $first_data = DB::table("tbl_incomes")->where('id', $id )->first();

        $sec_data = DB::table("tbl_income_history_records")->where('tbl_income_id', $id )->get()->toArray();
		$customer = DB::table('users')->where('role','=','Customer')->get()->toArray();
		$invoice_no = DB::table('tbl_invoices')->get()->toArray();

		$tbl_payments = DB::table('tbl_payments')->get()->toArray();
        return view("income/edit",compact('first_data','sec_data','customer','invoice_no','tbl_payments'));
    }

    //income update
    public function update(Request $request, $id)
    {
		$paidamount=getSumOfIncome($id);

		$Total_Amount=Input::get('Total_Amount');

		$income_entry = Input::get('income_entry');
		$amount_recevied1=0;
		if(!empty($income_entry))
		{
			foreach($income_entry as $key => $value)
			{
				$income_entr = $income_entry[$key];
				$amount_recevied1 +=$income_entr;
			}
		}

		if($paidamount < $amount_recevied1)
		{
			$amount1 = $amount_recevied1 - $paidamount;
		}
		else{
			$amount1 = 0;
		}

		if($Total_Amount >= $amount1)
		{
			$tbl_income=DB::table('tbl_incomes')->where('id','=',$id)->first();

			$payment_number = $tbl_income->payment_number;
			$invoice_number = $tbl_income->invoice_number;
			 if(getDateFormat()== 'm-d-Y')
			{
				$dates=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('date'))));
			}
			else
			{
				$dates=date('Y-m-d',strtotime(Input::get('date')));
			}
			$tbl_income = tbl_incomes::find($id);
			$tbl_income->invoice_number = Input::get('invoice');
			$tbl_income->payment_number = $payment_number;
			$tbl_income->customer_id = Input::get('cus_id');
			$tbl_income->status = Input::get('status');
			$tbl_income->payment_type = Input::get('Payment_type');
			$tbl_income->date = $dates;
			$tbl_income->main_label = Input::get('main_label');
			$tbl_income->save();
			$paidamount=getSumOfIncome($id);
			$income_entry = Input::get('income_entry');
			$id = Input::get('autoid');
			$income_label = Input::get('income_label');
			DB::table('tbl_income_history_records')->where('tbl_income_id',$request->id)->delete();
			$amount_recevied=0;
			foreach($income_entry as $key => $value)
			{
				$income_entr = $income_entry[$key];
				$income_lbls = $income_label[$key];

				DB::insert("insert into tbl_income_history_records set tbl_income_id = $request->id, income_amount = $income_entr, income_label = '$income_lbls' ");
				$amount_recevied +=$income_entr;
			}

			$tbl_invoices = DB::table('tbl_invoices')->where('invoice_number','=',$invoice_number)->first();
			$invoice_id=$tbl_invoices->id;
			$paid_amount=$tbl_invoices->paid_amount;
			$payment_number1=$tbl_invoices->payment_number;

			if($amount_recevied > $paidamount )
			{
				$amount = $amount_recevied - $paidamount;
				$paid_amount1=$paid_amount + $amount;
			}
			if($amount_recevied < $paidamount )
			{
				$amount = $paidamount - $amount_recevied;
				$paid_amount1=$paid_amount - $amount;
			}
			if($amount_recevied == $paidamount )
			{
				$paid_amount1=$paid_amount;
			}

			if($payment_number == $payment_number1)
			{
				DB::update("update tbl_invoices set paid_amount='$paid_amount1',amount_recevied='$amount_recevied' where id=$invoice_id");
			}
			else
			{
				DB::update("update tbl_invoices set paid_amount='$paid_amount1' where id=$invoice_id");
			}


			$tbl_payment_recordss = DB::table('tbl_payment_records')->where('payment_number','=',$payment_number)->first();
			$tbl_payment_records_id=$tbl_payment_recordss->id;

			$tbl_payment_records =tbl_payment_records::find($tbl_payment_records_id);
			$tbl_payment_records->invoices_id = $invoice_id;
			$tbl_payment_records->payment_number = $payment_number;
			$tbl_payment_records->amount = $amount_recevied;
			$tbl_payment_records->payment_type = Input::get('Payment_type');
			$tbl_payment_records->payment_date = $dates;
			$tbl_payment_records->save();
			return redirect('/admin/income/list')->with('message','Successfully Updated');
		}
		else
		{
			return redirect('/admin/income/edit/'.$id)->with('message','amount');
		}
    }

   //income delete
    public function destroy($id)
    {
		$tbl_incomes=DB::table('tbl_incomes')->where('id', $id)->first();
		$idinvoice=$tbl_incomes->invoice_number;
		$payment_number=$tbl_incomes->payment_number;
		$amount=getSumOfIncome($id);

		$tbl_invoices = DB::table('tbl_invoices')->where('invoice_number','=',$idinvoice)->first();

			$invoice_id=$tbl_invoices->id;
			$paid_amount=$tbl_invoices->paid_amount;
			$payment_number1=$tbl_invoices->payment_number;

			$total_paid=$paid_amount-$amount;

			if($tbl_invoices == $payment_number1 )
			{
				DB::update("update tbl_invoices set paid_amount='$total_paid',amount_recevied='0',payment_status='1' where id=$invoice_id");
			}
			else
			{
				DB::update("update tbl_invoices set paid_amount='$total_paid',payment_status='1' where id=$invoice_id");
			}
        DB::table('tbl_payment_records')->where('payment_number', $payment_number)->delete();
        DB::table('tbl_incomes')->where('id', $id)->delete();

		DB::table('tbl_income_history_records')->where('tbl_income_id', '=', $id)->delete();

        return redirect("/admin/income/list")->with('message','Successfully Deleted');
    }

	//month income form
	public function monthly_income()
    {
        return view("income/month_income");
    }

	//month income list report
	public function get_month_income(Request $request)
    {
		  $this->validate($request,[
			// 'start_date'  => 'required|date',
			// 'end_date'  => 'date|after:start_date',
	      ]);
		if(getDateFormat()== 'm-d-Y')
		{
			$start_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('start_date'))));
			$end_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('end_date'))));
		}
		else
		{
			$start_date=date('Y-m-d',strtotime(Input::get('start_date')));
			$end_date=date('Y-m-d',strtotime(Input::get('end_date')));
		}

		$month_income = DB::table('tbl_incomes')
							->join('tbl_income_history_records','tbl_incomes.id','=','tbl_income_history_records.tbl_income_id')
							->whereBetween('date',[$start_date,$end_date])
							->select('tbl_incomes.*','tbl_income_history_records.*')
							->orderBy('tbl_income_history_records.id','DESC')
							->get()->toArray();
		if(empty($month_income))
		{
			Session::flash('message', 'Data Not Found !');
		}
		return view('income.income_report',compact('month_income','start_date','end_date'));
    }
}

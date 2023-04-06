<?php

namespace App\Http\Controllers;

use App\Insurance;
use App\Section;
use Illuminate\Http\Request;
use App\User;

use App\Http\Requests;
use DB;
use URL;
use Auth;
use Mail;
use Illuminate\Support\Facades\Input;

class InsuranceController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

	//insurance addform
	public function insuranceadd()
	{
        $signature_positions = ['Bottom Right','Bottom Center','Bottom Left'];
	   return view('insurance.add',compact('signature_positions'));
	}
	//insurance store
	public function storeinsurance(Request $request)
	{

        $this->validate($request, [
            'company_name' => 'required|unique:insurances|regex:/^[(a-zA-Z\s)]+$/u',
            'contact_no'=>'required|unique:insurances|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
            'email'=>'required|email',
            'subrogation' => 'image|mimes:jpg,png,jpeg',
            'signature_position'=>'required',
            'TRN'=>'required|string',
            'address'=>'required|string',
        ],[
            'company_name.regex' => 'Enter valid name',
        ]);




        $company_name = Input::get('company_name');
        $contact_no = Input::get('contact_no');
        $email = Input::get('email');
        $signature_position = Input::get('signature_position');
        $TRN = Input::get('TRN');
        $address = Input::get('address');



        $insurance = new Insurance();
        if(!empty(Input::hasFile('subrogation')))
        {
            $file= Input::file('subrogation');
            $filename=$file->getClientOriginalName();
            $file->move(public_path().'/insurance/', $file->getClientOriginalName());
            $insurance->subrogation = $filename;
        }

        $insurance->company_name=$company_name;
        $insurance->contact_no=$contact_no;
        $insurance->email=$email;
        $insurance->signature_position=$signature_position;
        $insurance->TRN=$TRN;
        $insurance->address=$address;
        $insurance -> save();

        return redirect('/insurance/list')->with('message','Successfully Submitted');
	}

	//insurance list
	public function index()
	{
        $insurances = Insurance::all();

        return view('insurance.list',compact('insurances'));
	}

	// insurance delete
    public function destory($id)
	 {

		DB::table('insurances')->where('id','=',$id)->delete();

		return redirect('/insurance/list')->with('message','Successfully Deleted');
	 }

}

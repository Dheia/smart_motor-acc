<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use App\User;

use App\Http\Requests;
use DB;
use URL;
use Auth;
use Mail;
use Illuminate\Support\Facades\Input;

class ServicesController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

	//service addform
	public function serviceadd()
	{
       $sections = DB::table('sections')->get()->toArray();
	   return view('services.add',compact('sections'));
	}
	//service store
	public function storeservice(Request $request)
	{
        $this->validate($request, [
            'name' => 'required|regex:/^[(a-zA-Z\s)]+$/u',
            'section_id'=>'required|exists:sections,id',
        ],[
            'name.regex' => 'Enter valid name',
        ]);

        $name = Input::get('name');
        $section_id = Input::get('section_id');

        $service = new Service();
        $service->name=$name;
        $service->section_id=$section_id;
        $service -> save();

        return redirect('/admin/services/list')->with('message','Successfully Submitted');
	}

	//service list
	public function index()
	{
        $services = Service::all();

        return view('services.list',compact('services'));
	}

	// service delete
    public function destory($id)
	 {

		DB::table('services')->where('id','=',$id)->delete();

		return redirect('/admin/services/list')->with('message','Successfully Deleted');
	 }

}

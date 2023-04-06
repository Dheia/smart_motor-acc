<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use Illuminate\Http\Request;
use App\User;

use App\Http\Requests;
use DB;
use URL;
use Auth;
use Mail;
use Illuminate\Support\Facades\Input;

class SectionController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

	//section addform
	public function sectionadd()
	{
       $headOfSections = DB::table('users')->where('role','Head of Section')->get()->toArray();
	   return view('section.add',compact('headOfSections'));
	}
	//section store
	public function storesection(Request $request)
	{
        $this->validate($request, [
            'name' => 'required|unique:sections|regex:/^[(a-zA-Z\s)]+$/u',
            'user_id'=>'required|exists:users,id',
        ],[
            'name.regex' => 'Enter valid name',
        ]);

        $name = Input::get('name');
        $user_id = Input::get('user_id');

        $section = new Section();
        $section->name=$name;
        $section->user_id=$user_id;
        $section -> save();

        return redirect('/admin/section/list')->with('message','Successfully Submitted');
	}

	//section list
	public function index()
	{
        $sections = Section::all();

        return view('section.list',compact('sections'));
	}

	// section delete
    public function destory($id)
	 {

		DB::table('sections')->where('id','=',$id)->delete();

		DB::table('services')->where('section_id','=',$id)->delete();

		return redirect('/admin/section/list')->with('message','Successfully Deleted');
	 }

}

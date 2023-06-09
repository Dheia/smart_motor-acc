<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Auth;
use App\tbl_observation_points;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;

class ObservationPointcontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	////observation points list
    public function index()
	{
		$tbl_observation_points = DB::table('tbl_observation_points')->get()->toArray();
		return view('observation_point.list',compact('tbl_observation_points'));
	}

	////observation points form
	public function addobservation()
	{
		$tbl_observation_types = DB::table('tbl_observation_types')->get()->toArray();
		return view('observation_point.add',compact('tbl_observation_types'));
	}

	////observation points store
	public function store(Request $request)
	{
		$tbl_observation_points = new tbl_observation_points;
		$tbl_observation_points->observation_type_id = Input::get('o_type_id');
		$tbl_observation_points->observation_point = Input::get('o_point');
		$tbl_observation_points->save();
		return redirect('/admin/observation_point/list')->with('message','Successfully Submitted');
	}

	////observation points delete
	public function destroy($id)
	{
		$delete = DB::table('tbl_observation_points')->where('id','=',$id)->delete();
		return redirect('/admin/observation_point/list')->with('message','Successfully Deleted');
	}

	////observation points edit
	public function edit($id)
	{
		$editid = $id;
		$tbl_observation_types = DB::table('tbl_observation_types')->get()->toArray();
		$tbl_observation_points = DB::table('tbl_observation_points')->where('id','=',$id)->first();
		return view('observation_point.edit',compact('editid','tbl_observation_types','tbl_observation_points'));
	}

	////observation points update
	public function update($id)
	{
		$tbl_observation_points = tbl_observation_points::find($id);
		$tbl_observation_points->observation_type_id = Input::get('o_type_id');
		$tbl_observation_points->observation_point = Input::get('o_point');
		$tbl_observation_points->save();
		return redirect('/admin/observation_point/list')->with('message','Successfully Updated');
	}
}

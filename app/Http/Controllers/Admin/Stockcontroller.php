<?php
namespace App\Http\Controllers\Admin;
use App\tbl_stock_records;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;

class Stockcontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	//stock list
    public function index()
	{
		  $stock=DB::table('tbl_products')
						->join('tbl_stock_records','tbl_products.id','=','tbl_stock_records.product_id')
						 ->orderBy('tbl_stock_records.id','DESC')->get()->toArray();
			// $cellstock=DB::table('tbl_service_pros')->where('product_id','=',$p_id)->get();

		return view('stoke.list',compact('stock'));
	}

   //stock edit
   public function edit($id)
   {
	 $product=DB::table('tbl_products')->get()->toArray();
	 $stock=DB::table('tbl_stock_records')->where('id','=',$id)->first();
    return view('stoke.edit',compact('product','stock'));
   }

   //stock update
   public function update($id)
   {
	   $stocks=DB::table('tbl_stock_records')->where('id','=',$id)->first();
	   $oldstock=$stocks->no_of_stoke;
	   $newstock=Input::get('qty');

	   $stock=tbl_stock_records::find($id);
	   $stock->product_id=Input::get('product');
	   $stock->no_of_stoke=$newstock;
	   $stock->save();
	   return redirect('/admin/stoke/list')->with('message','Successfully Updated');
   }

   //stock modal view
   public function stockview()
   {
		$stockid=Input::get('stockid');

		$logo = DB::table('tbl_settings')->first();
		$stockdata=DB::table('tbl_stock_records')
						->join('tbl_products','tbl_stock_records.product_id','=','tbl_products.id')
						->join('tbl_purchase_history_records','tbl_products.id','=','tbl_purchase_history_records.product_id')
						->join('tbl_purchases','tbl_purchase_history_records.purchase_id','=','tbl_purchases.id')
						->where('tbl_stock_records.id','=',$stockid)
						->orderBy('tbl_purchases.date','=','DESC')
						->get()->toArray();

		$currentstock = DB::table('tbl_stock_records')->where('id','=',$stockid)->first();

		$p_id=$currentstock->product_id;
		$product = DB::table('tbl_products')->find($p_id);
		if($product->category == 1)
		{
			$cellstock=DB::table('tbl_sale_parts')->where('product_id','=',$p_id)->get()->toArray();
			$celltotal=0;
			foreach($cellstock as $cellstocks)
			{
				$cell_stock=$cellstocks->quantity;
				$celltotal += $cell_stock;
			}
		}
		else
		{
			$cellstock=DB::table('tbl_service_pros')->where('product_id','=',$p_id)->get()->toArray();
			$celltotal=0;
			foreach($cellstock as $cellstocks)
			{
				$cell_stock=$cellstocks->quantity;
				$celltotal += $cell_stock;
			}
		}
		$html = view('stoke.stokemodel')->with(compact('stockid','stockdata','logo','currentstock','p_id','cellstock','cell_stock','celltotal'))->render();
		return response()->json(['success' => true, 'html' => $html]);
   }
}

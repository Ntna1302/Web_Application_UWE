<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
session_start();
use Toastr;
class CouponController extends Controller
{
	public function unset_coupon(){
		$coupon = Session::get('coupon');
        if($coupon==true){
          
            Session::forget('coupon');
						Toastr::success('Promotion code removed successfully','Successful');

            return redirect()->back();
        }
	}
    public function insert_coupon(){
    	return view('admin.coupon.insert_coupon');
    }
    public function delete_coupon($coupon_id){
    	$coupon = Coupon::find($coupon_id);
    	$coupon->delete();
			Toastr::success('Delete discount code successfully','Successful');
        return Redirect::to('list-coupon');
    }
    public function list_coupon(){
			$today = Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y');
    	$coupon = Coupon::orderby('coupon_id','DESC')->paginate(2);
    	return view('admin.coupon.list_coupon')->with(compact('coupon','today'));
    }
    public function insert_coupon_code(Request $request){
    	$data = $request->all();

    	$coupon = new Coupon;

    	$coupon->coupon_name = $data['coupon_name'];
    	$coupon->coupon_date_start = $data['coupon_date_start'];
    	$coupon->coupon_date_end = $data['coupon_date_end'];
    	$coupon->coupon_number = $data['coupon_number'];
    	$coupon->coupon_code = $data['coupon_code'];
    	$coupon->coupon_time = $data['coupon_time'];
    	$coupon->coupon_condition = $data['coupon_condition'];
    	$coupon->save();

			Toastr::success('Added discount code successfully','Successful');
        return Redirect::to('insert-coupon');


    }
}
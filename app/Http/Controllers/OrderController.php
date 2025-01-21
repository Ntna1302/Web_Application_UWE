<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Feeship;
use App\Shipping;
use App\Order;
use App\OrderDetails;
use App\Customer;
use App\Coupon;
use App\Statistic;
use App\Product;
use App\Contact;
use App\Brand;
use App\Slider;
use App\CatePost;
use Carbon\Carbon;
use DB;
use PDF;
use Session;
use Toastr;

class OrderController extends Controller
{

	public function huy_don_hang(Request $request){
		$data = $request->all();
		$order = Order::where('order_code',$data['order_code'])->first();
		$order->order_destroy = $data['lydo'];
		$order->order_status = 3;
		$order->save();
	}
	public function order_code(Request $request ,$order_code){
		$order = Order::where('order_code',$order_code)->first();
		$order->delete();
		 Toastr::success('Order deleted successfully','Successful');
        return redirect()->back();

	}
	public function update_qty(Request $request){
		$data = $request->all();
		$order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
		$order_details->product_sales_quantity = $data['order_qty'];
		$order_details->save();
	}
	public function update_order_qty(Request $request){
		//update order
		$data = $request->all();
		$order = Order::find($data['order_id']);
		$order->order_status = $data['order_status'];
		$order->save();

		//order_date
		$order_date = $order->order_date;
		$statistic = Statistic::where('order_date',$order_date)->get();

		if($statistic){
			$statistic_count = $statistic->count();
		}else{
			$statistic_count= 0;
		}
		if($order->order_status==2){

			$total_order = 0;
			$sales = 0;
			$profit = 0;
			$quantity = 0;


			foreach($data['order_product_id'] as $key => $product_id){
				$product = Product::find($product_id);
				$product_quantity = $product->product_quantity;
				$product_sold = $product->product_sold;

				
				$product_price = $product->product_price;
				$product_cost = $product->price_cost;
				$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

				foreach($data['quantity'] as $key2 => $qty){
						if($key==$key2){
								$pro_remain = $product_quantity - $qty;
								$product->product_quantity = $pro_remain;
								$product->product_sold = $product_sold + $qty;
								$product->save();
								$quantity += $qty;
								$total_order += 1;
								$sales += $product_price*$qty;
								$profit = $sales-($product_cost*$qty);
						}
				}

			}
			if($statistic_count>0){
				$statistic_update = Statistic::where('order_date',$order_date)->first();
				$statistic_update->sales = $statistic_update->sales + $sales;
				$statistic_update->profit = $statistic_update->profit + $profit;
				$statistic_update->quantity = $statistic_update->quantity + $quantity;
				$statistic_update->total_order = $statistic_update->total_order + $total_order;
				$statistic_update->save();
			} else{
				$statistic_new = new Statistic();
				$statistic_new->order_date = $order_date;
				$statistic_new->sales = $sales;
				$statistic_new->profit = $profit;
				$statistic_new->quantity = $quantity;
				$statistic_new->total_order = $total_order;
				$statistic_new->save();
			}

		}

	}
	public function print_order($checkout_code){
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->print_order_convert($checkout_code));
		
		return $pdf->stream();
	}
	
	public function print_order_convert($checkout_code) {
		$order_details = OrderDetails::where('order_code', $checkout_code)->get();
		$order = Order::where('order_code', $checkout_code)->get();
		
		foreach ($order as $ord) {
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
		}
		
		$customer = Customer::where('customer_id', $customer_id)->first();
		$shipping = Shipping::where('shipping_id', $shipping_id)->first();
		$order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();
	
		foreach ($order_details_product as $order_d) {
			$product_coupon = $order_d->product_coupon;
		}
	
		if ($product_coupon != 'no') {
			$coupon = Coupon::where('coupon_code', $product_coupon)->first();
			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;
	
			$coupon_echo = $coupon_condition == 1 
				? $coupon_number . '%' 
				: number_format($coupon_number, 0, ',', '.') . 'đ';
		} else {
			$coupon_condition = 2;
			$coupon_number = 0;
			$coupon_echo = '0';
		}
	
		$output = '<style>
			 .table-styling {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000;
    }
    .table-styling th, 
    .table-styling td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
    .table-styling th {
        background-color: #f2f2f2;
    }
		</style>
		<h1 style="text-align: center;">ABCD One Member LLC</h1>
		<h4 style="text-align: center;">Independence - Freedom - Happiness</h4>
		<p>Customer Information</p>
		<table class="table-styling">
			<thead>
				<tr>
					<th>Customer Name</th>
					<th>Phone Number</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>' . $customer->customer_name . '</td>
					<td>' . $customer->customer_phone . '</td>
					<td>' . $customer->customer_email . '</td>
				</tr>
			</tbody>
		</table>
	
		<p>Shipping Information</p>
		<table class="table-styling">
			<thead>
				<tr>
					<th>Recipient Name</th>
					<th>Address</th>
					<th>Phone Number</th>
					<th>Email</th>
					<th>Notes</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>' . $shipping->shipping_name . '</td>
					<td>' . $shipping->shipping_address . '</td>
					<td>' . $shipping->shipping_phone . '</td>
					<td>' . $shipping->shipping_email . '</td>
					<td>' . $shipping->shipping_notes . '</td>
				</tr>
			</tbody>
		</table>
	
		<p>Order Details</p>
		<table class="table-styling">
			<thead>
				<tr>
					<th>Product Name</th>
					<th>Discount Code</th>
					<th>Shipping Fee</th>
					<th>Quantity</th>
					<th>Product Price</th>
					<th>Total Price</th>
				</tr>
			</thead>
			<tbody>';
	
		$total = 0;
		foreach ($order_details_product as $product) {
			$subtotal = $product->product_price * $product->product_sales_quantity;
			$total += $subtotal;
			$product_coupon = $product->product_coupon != 'no' ? $product->product_coupon : 'No Code';
	
			$output .= '
				<tr>
					<td>' . $product->product_name . '</td>
					<td>' . $product_coupon . '</td>
					<td>' . number_format($product->product_feeship, 0, ',', '.') . 'đ</td>
					<td>' . $product->product_sales_quantity . '</td>
					<td>' . number_format($product->product_price, 0, ',', '.') . 'đ</td>
					<td>' . number_format($subtotal, 0, ',', '.') . 'đ</td>
				</tr>';
		}
	
		$total_coupon = $coupon_condition == 1 
			? $total - ($total * $coupon_number / 100) 
			: $total - $coupon_number;
	
		$output .= '
			<tr>
				<td colspan="6">
					<p>Total Discount: ' . $coupon_echo . '</p>
					<p>Shipping Fee: ' . number_format($product->product_feeship, 0, ',', '.') . 'đ</p>
					<p>Total Payment: ' . number_format($total_coupon + $product->product_feeship, 0, ',', '.') . 'đ</p>
				</td>
			</tr>
			</tbody>
		</table>
	
		<p>Signatures</p>
		<table style="width: 100%; margin-top: 20px;">
			<thead>
				<tr>
					<th style="width: 50%;">Creator</th>
					<th style="width: 50%;">Recipient</th>
				</tr>
			</thead>
		</table>';
	
		return $output;
	}
	
	
	public function view_order($order_code){
		$order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
		$getorder = Order::where('order_code',$order_code)->get();
		foreach($getorder as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
			$order_status = $ord->order_status;
		}
		$getcustomer = Customer::where('customer_id',$customer_id)->first();
		$shipping = Shipping::where('shipping_id',$shipping_id)->first();

		$order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

		foreach($order_details_product as $key => $order_d){

			$product_coupon = $order_d->product_coupon;
		}
		if($product_coupon != 'no'){
			$coupon = Coupon::where('coupon_code',$product_coupon)->first();
			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;
		}else{
			$coupon_condition = 2;
			$coupon_number = 0;
		}
		
		return view('admin.order.view_order')->with(compact('order_details','getcustomer','shipping','coupon_condition','coupon_number','getorder','order_status'));

	}
    public function manage_order(){
    	$getorder = Order::orderby('created_at','DESC')->paginate(5);
    	return view('admin.order.manage_order')->with(compact('getorder'));
    }

		public function history(Request $request){
			if(!Session::get('customer_id')){
				return redirect('dang-nhap')->with('error','Please log in to view purchase history');
			}
			else{
				// $getorder = Order::where('customer_id',Session::get('customer_id'))->orderby('order_id','DESC')->get();
    		// return view('pages.history.history')->with(compact('getorder'));
				   //slide
					 $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        //seo 
		$meta_desc = "Order history"; 
        $meta_keywords = "Order history";
        $meta_title = "Order history";
        $url_canonical = $request->url();
        //--seo
        
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        // ->orderby('tbl_product.product_id','desc')->get();
        
     
        $contact = Contact::where('info_id',1)->get();
				$getorder = Order::where('customer_id',Session::get('customer_id'))->orderby('order_id','desc')->paginate(10);

    		return view('pages.history.history')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('contact',$contact)->with('getorder',$getorder); //1
			}

		}		
		public function view_history_order(Request $request,$order_code){
			if(!Session::get('customer_id')){
				return redirect('dang-nhap')->with('error','Please log in to view purchase history');
				}else{
	
				   //slide
					 $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        //seo 
		$meta_desc = "Order history"; 
        $meta_keywords = "Order history";
        $meta_title = "Order history";
        $url_canonical = $request->url();
        //--seo
        
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

     
        $contact = Contact::where('info_id',1)->get();
			
			// xem lich su
					$order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
			$getorder = Order::where('order_code',$order_code)->first();
		
				$customer_id = $getorder->customer_id;
				$shipping_id = $getorder->shipping_id;
				$order_status = $getorder->order_status;
	
			$getcustomer = Customer::where('customer_id',$customer_id)->first();
			$shipping = Shipping::where('shipping_id',$shipping_id)->first();

			$order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

			foreach($order_details_product as $key => $order_d){

				$product_coupon = $order_d->product_coupon;
			}
			if($product_coupon != 'no'){
				$coupon = Coupon::where('coupon_code',$product_coupon)->first();
				$coupon_condition = $coupon->coupon_condition;
				$coupon_number = $coupon->coupon_number;
			}else{
				$coupon_condition = 2;
				$coupon_number = 0;
			}
			
    	return view('pages.history.view_history_order')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('contact',$contact)->with('getorder',$getorder)->with('order_details',$order_details)->with('getcustomer',$getcustomer)->with('shipping',$shipping)->with('coupon_condition',$coupon_condition)->with('getorder',$getorder)->with('order_status',$order_status)->with('coupon_number',$coupon_number)->with('order_code',$order_code); //1
			}
		}	
	
}
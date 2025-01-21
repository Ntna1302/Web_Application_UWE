<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Vnpay;



use App\City;
use App\Province;
use Carbon\Carbon;
use App\Wards;
use App\Feeship;
use App\Slider;
use App\Shipping;
use App\Order;
use App\Coupon;
use App\OrderDetails;
use App\Contact;
use Auth;
use Toastr;
session_start();

class CheckoutController extends Controller
{
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    // public function momo_payment(Request $request)
    // {

    //     $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    //     $partnerCode = 'MOMOBKUN20180529';
    //     $accessKey = 'klm05TvNBzhg7h7j';
    //     $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    //     $orderInfo = "Thanh toán qua ATM MoMo";
    //     $amount = $_POST['total_momo'];
    //     $orderId = time() . "";
    //     $redirectUrl = "http://laptopstore.com/checkout";
    //     $ipnUrl = "http://laptopstore.com/checkout";
    //     $extraData = "";


    //     $requestId = time() . "";
    //     $requestType = "payWithATM";
    //     // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //     //before sign HMAC SHA256 signature
    //     $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    //     $signature = hash_hmac("sha256", $rawHash, $secretKey);
    //     // dd($signature);
    //     $data = array(
    //         'partnerCode' => $partnerCode,
    //         'partnerName' => "Test",
    //         "storeId" => "MomoTestStore",
    //         'requestId' => $requestId,
    //         'amount' => $amount,
    //         'orderId' => $orderId,
    //         'orderInfo' => $orderInfo,
    //         'redirectUrl' => $redirectUrl,
    //         'ipnUrl' => $ipnUrl,
    //         'lang' => 'vi',
    //         'extraData' => $extraData,
    //         'requestType' => $requestType,
    //         'signature' => $signature,
    //     );
    //     $result = $this->execPostRequest($endpoint, json_encode($data));
    //     // dd($result);
    //     $jsonResult = json_decode($result, true);  // decode json

    //     //Just a example, please check more in there

    //     return redirect()->to($jsonResult['payUrl'])->with(
    //         Session::put('success_momo', true)
    //     );
    //     // header('Location: ' . $jsonResult['payUrl']);
    // }

    public function vnpay_payment(Request $request)
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data = $request->all();
        $code_cart = rand(00, 9999);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/laptopstore/checkout";
        $vnp_TmnCode = "NJJ0R8FS";
        $vnp_HashSecret = "BYKJBHPPZKQMKBIBGGXIYKWYFAYSJXCW";
    
        $vnp_TxnRef = $code_cart;
        $vnp_OrderInfo = 'VNPay Test Payment';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $data['total_vnpay'] * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
    
        ksort($inputData);
        $query = "";
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $hashdata = ltrim($hashdata, '&');
        $vnp_Url = $vnp_Url . "?" . $query;
    
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
    
        // Save order to database
        $vnpay = new Vnpay();
        $vnpay->vnp_amount = $vnp_Amount;
        $vnpay->vnp_bankcode = $vnp_BankCode;
        $vnpay->vnp_banktranno = $data['vnp_banktranno'] ?? 'N/A'; // Use a default value
        $vnpay->vnp_cardtype = $data['vnp_cardtype'] ?? 'N/A'; // Use a default value

        $vnpay->vnp_orderInfo = $vnp_OrderInfo;
        $vnpay->vnp_paydate = $data['vnp_paydate'] ?? 'N/A'; // Use a default value
        $vnpay->vnp_transactionno = $data['vnp_transactionno'] ?? 'N/A'; // Use a default value

        $vnpay->vnp_tmnCode = $vnp_TmnCode;
        $vnpay->save();
    
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
    
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }
    
    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = "BYKJBHPPZKQMKBIBGGXIYKWYFAYSJXCW";
        $inputData = [];
    
        // Extract VNPay data from the request
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) === "vnp_") {
                $inputData[$key] = $value;
            }
        }
    
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? null;
        unset($inputData['vnp_SecureHash']);
    
        // Generate the hash data
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
        }
        $hashData = ltrim($hashData, '&');
    
        // Verify the hash
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    
        if ($secureHash === $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] === '00') {
                // Payment successful
                $vnpay = new Vnpay();
                $vnpay->vnp_amount = $inputData['vnp_Amount'];
                $vnpay->vnp_bankcode = $inputData['vnp_BankCode'] ?? null;
                $vnpay->vnp_banktranno = $inputData['vnp_BankTranNo'] ?? null;
                $vnpay->vnp_cardtype = $inputData['vnp_CardType'] ?? null;
                $vnpay->vnp_orderInfo = $inputData['vnp_OrderInfo'] ?? null;
                $vnpay->vnp_paydate = $inputData['vnp_PayDate'] ?? null;
                $vnpay->vnp_tmnCode = $inputData['vnp_TmnCode'] ?? null;
                $vnpay->vnp_transactionno = $inputData['vnp_TransactionNo'] ?? null;
                $vnpay->save();
    
                // Update order payment status
                $order = Order::where('order_code', $inputData['vnp_TxnRef'])->first();
                if ($order) {
                    $order->transaction_id = $inputData['vnp_TransactionNo'];
                    $order->payment_status = 'paid';
                    $order->save();
                }
    
                return redirect('/order-history')->with('message', 'Payment successful!');
            } else {
                return redirect('/order-history')->with('message', 'Payment failed!');
            }
        } else {
            return redirect('/order-history')->with('message', 'Invalid payment response!');
        }
    }
    


    public function confirm_order(Request $request)
    {
        $data = $request->all();


        if (Session::get('coupon') != null) {
            $coupon = Coupon::where('coupon_code', $data['order_coupon'])->first();
            $coupon->coupon_used = $coupon->coupon_used . ',' . Session::get('customer_id');
            $coupon->coupon_time = $coupon->coupon_time - 1;
            $coupon->save();
            $shipping = new Shipping();
            $shipping->shipping_name = $data['shipping_name'];
            $shipping->shipping_email = $data['shipping_email'];
            $shipping->shipping_phone = $data['shipping_phone'];
            $shipping->shipping_address = $data['shipping_address'];
            $shipping->shipping_notes = $data['shipping_notes'];
            $shipping->shipping_method = $data['shipping_method'];
            $shipping->save();
            $shipping_id = $shipping->shipping_id;

            $checkout_code = substr(md5(microtime()), rand(0, 26), 5);

            //get order
            $order = new Order;
            $order->customer_id = Session::get('customer_id');
            $order->shipping_id = $shipping_id;
            $order->order_status = 1;
            $order->order_code = $checkout_code;

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            // $order->creat_at= now();

            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');

            $order_date = Carbon::now('Asia/Ho_Chi_Minh')
                ->format('Y-m-d');
            // $order->creat_at =  date('d-m-y h:i:s');
            $order->created_at = $today;
            $order->order_date = $order_date;
            $order->save();
        } else {
            //get shipping
            $shipping = new Shipping();
            $shipping->shipping_name = $data['shipping_name'];
            $shipping->shipping_email = $data['shipping_email'];
            $shipping->shipping_phone = $data['shipping_phone'];
            $shipping->shipping_address = $data['shipping_address'];
            $shipping->shipping_notes = $data['shipping_notes'];
            $shipping->shipping_method = $data['shipping_method'];
            $shipping->save();
            $shipping_id = $shipping->shipping_id;

            $checkout_code = substr(md5(microtime()), rand(0, 26), 5);

            //get order
            $order = new Order;
            $order->customer_id = Session::get('customer_id');
            $order->shipping_id = $shipping_id;
            $order->order_status = 1;
            $order->order_code = $checkout_code;

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            // $order->creat_at= now();

            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');

            $order_date = Carbon::now('Asia/Ho_Chi_Minh')
                ->format('Y-m-d');
            // $order->creat_at =  date('d-m-y h:i:s');
            $order->created_at = $today;
            $order->order_date = $order_date;
            $order->save();
        }
        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart) {
                $order_details = new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon =  $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }
        //  Session::forget('success_vnpay');
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
        Session::forget('success_paypal');
        Session::forget('success_vnpay');
        // Session::forget('success_momo');
        Session::forget('total_paypal');


        //  return view('pages.history.history');
    }
    public function del_fee()
    {
        Session::forget('fee');
        return redirect()->back();
    }

    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }
    public function calculate_fee(Request $request)
    {
        $data = $request->all();
        if ($data['matp']) {
            $feeship = Feeship::where('fee_matp', $data['matp'])->where('fee_maqh', $data['maqh'])->where('fee_xaid', $data['xaid'])->get();
            if ($feeship) {
                $count_feeship = $feeship->count();
                if ($count_feeship > 0) {
                    foreach ($feeship as $key => $fee) {
                        Session::put('fee', $fee->fee_feeship);
                        Session::save();
                    }
                } else {
                    Session::put('fee', 50000);
                    Session::save();
                }
            }
        }
    }
    public function select_delivery_home(Request $request)
    {
        $data = $request->all();
        if ($data['action']) {
            $output = '';
            if ($data['action'] == "city") {
                $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
                $output .= '<option>---Select District---</option>';
                foreach ($select_province as $key => $province) {
                    $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
                }
            } else {

                $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
                $output .= '<option>---Select commune and ward---</option>';
                foreach ($select_wards as $key => $ward) {
                    $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
                }
            }
            echo $output;
        }
    }
    public function view_order($orderId)
    {
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
            ->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
            ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
            ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
            ->select('tbl_order.*', 'tbl_customers.*', 'tbl_shipping.*', 'tbl_order_details.*')->first();

        $manager_order_by_id  = view('admin.order.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.order.view_order', $manager_order_by_id);
    }
    public function login_checkout(Request $request)
    {
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        $contact = Contact::where('info_id', 1)->get();

        //seo 
        $meta_desc = "Payment Login";
        $meta_keywords = "Payment Login";
        $meta_title = "Payment Login";
        $url_canonical = $request->url();
        //--seo 

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();



        return view('pages.checkout.login_checkout')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('slider', $slider)->with('contact', $contact);
    }
    //     public function validation($request){

    //         return $this->validate($request,[
    //     'customer_name' => 'required|max:255',
    //     'customer_phone' =>'required|max:255',
    //     'customer_email' =>'required|unique:tbl_customers,customer_email|max:255',
    //     'customer_password' =>'required|max:255',
    //     ]);
    // }
    public function add_customer(Request $request)
    {
        // $this->validation($request);

        $data = $request->validate(
            [
                'customer_email' => 'required|unique:tbl_customers|max:255|email',

                'customer_name' => 'required',
                'customer_phone' => 'required|numeric|digits_between:10,10',
                'customer_password' => 'required',


            ],
            [
                'customer_email.required' => 'Email address cannot be empty',
                'customer_email.unique' => 'Email address already exists, please choose another name',
                'customer_email.email' => 'Please fill in a valid Email address',

                'customer_name.required' => 'Please fill in your full name',


                'customer_phone.required' => 'Please fill in phone number',
                'customer_phone.numeric' => 'Please enter a valid phone number',
                'customer_phone.digits_between' => 'Please enter a 10-digit phone number',
                'customer_phone.digits_between' => 'Please enter a 10-digit phone number',

                'customer_password.required' => 'Please fill in password',


            ]
        );

        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);

        $customer_id = DB::table('tbl_customers')->where('customer_email', '<>', '')->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        Toastr::success('Registration successful, please log in', 'Success');

        return Redirect::to('/dang-nhap');
    }
   
    public function checkout(Request $request)
    {

        //seo 
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        $meta_desc = "Payment Login";
        $meta_keywords = "Payment Login";
        $meta_title = "Payment Login";
        $url_canonical = $request->url();
        //--seo 

        //contact
        $contact = Contact::where('info_id', 1)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();
        $city = City::orderby('matp', 'ASC')->get();


        return view('pages.checkout.show_checkout')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('city', $city)->with('slider', $slider)->with('contact', $contact);
    }
    public function save_checkout_customer(Request $request)
    {
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_address'] = $request->shipping_address;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id', $shipping_id);

        return Redirect::to('/payment');
    }
    public function payment(Request $request)
    {
        //seo 
        $meta_desc = "Payment Login";
        $meta_keywords = "Payment Login";
        $meta_title = "Payment Login";
        $url_canonical = $request->url();
        //--seo 
        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();
        $contact = Contact::where('info_id', 1)->get();

        return view('pages.checkout.payment')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('contact', $contact);
    }
    public function order_place(Request $request)
    {
        //insert payment_method
        //seo 
        $meta_desc = "Payment Login";
        $meta_keywords = "Payment Login";
        $meta_title = "Payment Login";
        $url_canonical = $request->url();
        //--seo 
        // contact
        $contact = Contact::where('info_id', 1)->get();

        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Pending';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Pending';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order_details
        $content = Cart::content();
        foreach ($content as $v_content) {
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if ($data['payment_method'] == 'chuyenkhoan') {

            Cart::destroy();

            $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

            return view('pages.checkout.handcash')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('contact', $contact);
        } elseif ($data['payment_method'] == 'tienmat') {
            Cart::destroy();

            $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();
            $contact = Contact::where('info_id', 1)->get();

            return view('pages.checkout.handcash')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('contact', $contact);
        } else {
            echo 'Debit card';
        }

        //return Redirect::to('/payment');
    }
    public function logout_checkout()
    {
        Session::forget('customer_id');
        Session::forget('coupon');
        Session::forget('cart');
        // Session::forget('success_vnpay');  
        Toastr::success('Signed out successfully', 'Success');

        return Redirect::to('/dang-nhap');
    }
    public function login_customer(Request $request)
    {
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customers')->where('customer_email', $email)->where('customer_password', $password)->first();
        if (Session::get('coupon') == true) {
            Session::forget('coupon');
        }

        if ($result) {

            Session::put('customer_id', $result->customer_id);
            Session::put('customer_name', $result->customer_name);
            Toastr::success('Successfully logged in', 'Successful');

            return Redirect::to('/checkout');
        } else {
            Toastr::error('Please try again to check your account and password', 'Failed');

            return Redirect::to('/dang-nhap');
        }
        Session::save();
    }
    public function manage_order()
    {

        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
            ->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
            ->select('tbl_order.*', 'tbl_customers.customer_name')
            ->orderby('tbl_order.order_id', 'desc')->get();
        $manager_order  = view('admin.order.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.order.manage_order', $manager_order);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Social;
use Socialite;
use App\Visitors;
use App\Login;
use App\Statistic;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Rules\Captcha; 
use Auth;
use Carbon\Carbon;
use App\Product;
use App\Post;
use App\Order;
use App\Video;
use App\Customer;
use App\CategoryProductModel;
use App\Brand;
use App\SocialCustomers;
use Toastr;

class AdminController extends Controller
{
   

    public function login_customer_google(){
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
        return Socialite::driver('google')->redirect();
    }
    public function callback_customer_google(){
    config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
    $users = Socialite::driver('google')->stateless()->user(); 
            $authUser = $this->findOrCreateCustomer($users,'google');
           if($authUser)
           {
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('customer_id',$account_name->customer_id);
            Session::put('customer_picture',$account_name->customer_picture);
            Session::put('customer_name',$account_name->customer_name);

           }elseif($customer_new){
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('customer_id',$account_name->customer_id);
            Session::put('customer_picture',$account_name->customer_picture);
            Session::put('customer_name',$account_name->customer_name);
           }
           Toastr::success('Sign in with your Google account successfully','Successful');

           return redirect('/checkout');  

    }
    public function findOrCreateCustomer($users, $provider){
            $authUser = SocialCustomers::where('provider_user_id', $users->id)->first();
            if($authUser){

                return $authUser;
            }
            else{
                $customer_new = new SocialCustomers([
                'provider_user_id' => $users->id,
                'provider_user_email' => $users->email,
                'provider' => strtoupper($provider)
            ]);

            $customer = Customer::where('customer_email',$users->email)->first();

                if(!$customer){
                    $customer = Customer::create([
                        'customer_name' => $users->name,
                        'customer_email' => $users->email,
                        'customer_picture' => $users->avatar,
                        'customer_password' => md5('123456'),
                        'customer_phone' => '97979799'
                        
                    ]);
                }

            $customer_new->customer()->associate($customer);
                
            $customer_new->save();
            return $customer_new;
            }
    
    }


    public function login_google(){
        config(['services.google.redirect_admin' => env('GOOGLE_URL')]);
        return Socialite::driver('google')->redirect();
    }

   

    public function callback_google(){
        config(['services.google.redirect_admin' => env('GOOGLE_URL')]);
            $users = Socialite::driver('google')->stateless()->user(); 
            $authUser = $this->findOrCreateUser($users,'google');
           if($authUser)
           {
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$account_name->admin_id);
           }elseif($customer_new){
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$account_name->admin_id);
           }
           return redirect('/dashboard')->with('message', 'Successfully logged in as Admin');  

    }

    public function findOrCreateUser($users, $provider){
            $authUser = Social::where('provider_user_id', $users->id)->first();
            if($authUser){

                return $authUser;
            }
            else{
                $customer_new = new Social([
                'provider_user_id' => $users->id,
                'provider_user_email' => $users->email,
                'provider' => strtoupper($provider)
            ]);

            $orang = Login::where('admin_email',$users->email)->first();

                if(!$orang){
                    $orang = Login::create([
                        'admin_name' => $users->name,
                        'admin_email' => $users->email,
                        'admin_password' => md5('123456'),
                        'admin_phone' => '0912345789',
                        'admin_status' => 1
                        
                    ]);
                }

            $customer_new->login()->associate($orang);
                
            $customer_new->save();
            return $customer_new;
            }
          
        

         

    }
    public function dashboard_filter(Request $request){
            $data= $request->all();


        //    echo $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

            $dau_thangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
            $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
            $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

            $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
            $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
            $now  = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

          

            if($data['dashboard_value']=='7ngay'){
                $get =Statistic::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','asc')->get();
            } elseif($data['dashboard_value']=='thangtruoc'){
                $get =Statistic::whereBetween('order_date',[$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','asc')->get();
            } elseif ($data['dashboard_value']=='thangnay') {
                $get =Statistic::whereBetween('order_date',[$dau_thangnay,$now])->orderBy('order_date','asc')->get();
            } else {
                $get =Statistic::whereBetween('order_date',[$sub365days,$now])->orderBy('order_date','asc')->get();
            }

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'order' =>$val->total_order,
                    'sales' =>$val->sales,
                    'profit' =>$val->profit,
                    'quantity' =>$val->quantity
                );
            }

            echo $data = json_encode($chart_data);

        }
        public function days_order(Request $request){
            $sub60days =   Carbon::now('Asia/Ho_Chi_Minh')->subdays(60)->toDateString();

            $now  = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $get = Statistic::whereBetween('order_date',[$sub60days,$now])->orderBy('order_date','asc')->get();

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'order' =>$val->total_order,
                    'sales' =>$val->sales,
                    'profit' =>$val->profit,
                    'quantity' =>$val->quantity
                );
            }

            echo $data = json_encode($chart_data);

        }

        public function filter_by_date(Request $request){
            $data = $request->all();
            $from_date = $data['from_date'];
            $to_date = $data['to_date'];

            $get= Statistic::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','ASC')->get();
            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'order' =>$val->total_order,
                    'sales' =>$val->sales,
                    'profit' =>$val->profit,
                    'quantity' =>$val->quantity
                );
            }

            echo $data = json_encode($chart_data);

        }

       
   


    // public function login_facebook(){
    //     return Socialite::driver('facebook')->redirect();
    // }

    // public function callback_facebook(){
    //     $provider = Socialite::driver('facebook')->user();
    //     $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
    //     if($account){
    //         $account_name = Login::where('admin_id',$account->user)->first();
    //         Session::put('admin_name',$account_name->admin_name);
    //         Session::put('admin_id',$account_name->admin_id);
    //         return redirect('/dashboard')->with('message', 'Successfully logged in as Admin');
    //     }else{

    //         $admin_login = new Social([
    //             'provider_user_id' => $provider->getId(),
    //             'provider' => 'facebook'
    //         ]);

    //         $orang = Login::where('admin_email', $provider->getEmail())->first();

    //         if (!$orang) {
    //             $orang = Login::create([
    //                 'admin_name' => $provider->getName(),
    //                 'admin_email' => $provider->getEmail(),
    //                 'admin_password' => '',
    //                 'admin_phone' => '',

    //             ]);
    //         }
    //         $admin_login->login()->associate($orang);
    //         $admin_login->save();

    //         $account_name = Login::where('admin_id', $admin_login->user)->first();

    //         Session::put('admin_name', $admin_login->admin_name);
    //         Session::put('login_normal', true);
    //         Session::put('admin_id', $admin_login->admin_id);
    //     }
    //     return redirect('/dashboard')->with('message', 'Successfully logged in as Admin');
    // }
    public function AuthLogin(){
        if(Session::get('login_normal')){
            $admin_id = Session::get('admin_id');
        }
        else{
            $admin_id = Auth::id();

        }
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin_auth')->send();
        }
       
      
    }

    public function index(){
    	return view('admin_login');
    }
    public function show_dashboard(Request $request){
        $this->AuthLogin();
        // $user_ip_address =$request->ip();
        $user_ip_address ='123.13.005.333';
        // $user_ip_address ='150.13.005.139';
        // $user_ip_address ='150.13.005.199';

     
        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $oneyear =  Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now  = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        //total last month
        $visitor_of_lastmonth = Visitors::whereBetween('date_visitor',[$early_last_month,$end_of_last_month])->get();
         $visitor_last_month_count = $visitor_of_lastmonth->count();

        //total this month
        $visitor_of_thismonth = Visitors::whereBetween('date_visitor',[$early_this_month,$now])->get();
        $visitor_this_month_count = $visitor_of_thismonth->count();

         //total in one year
         $visitor_of_year = Visitors::whereBetween('date_visitor',[$oneyear,$now])->get();
        $visitor_year_count = $visitor_of_year->count();
        // total visitor
        $visitors =Visitors::all();
        $visitors_total = $visitors->count();
        //current online
        $visitors_current = Visitors::where('ip_address',$user_ip_address)->get();
        $visitor_count = $visitors_current->count();
        if($visitor_count<1){
            $visitor = new Visitors();
            $visitor->ip_address = $user_ip_address;
            $visitor->date_visitor = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visitor->save();
         }

        // total
        $now  = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

         $product = Product::all()->count();
         $category = CategoryProductModel::all()->count();
         $brand = Brand::all()->count();
         $doanhthu = Statistic::where('sales',$now)->get();
        //  $post = Post::all()->count();
         $order = Order::all()->count();
        //  $video = Video::all()->count();
         $customer = Customer::all()->count();

         $product_views = Product::orderBy('product_views','desc')->take(20)->get();
        //  $post_views = Post::orderBy('post_views','desc')->take(20)->get();

    	return view('admin.dashboard')->with(compact('visitors_total','visitor_count','visitor_last_month_count','visitor_this_month_count','visitor_year_count','product','customer','order','product_views','brand','category','doanhthu'));
        
    }
    public function dashboard(Request $request){
        //$data = $request->all();
        $data = $request->validate([
            //validation laravel 
            'admin_email' => 'required',
            'admin_password' => 'required',
            'g-recaptcha-response' => new Captcha(),    
        ]);

        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login = Login::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($login){
            $login_count = $login->count();
            if($login_count>0){
                Session::put('admin_name',$login->admin_name);
                Session::put('admin_id',$login->admin_id);
                return Redirect::to('/dashboard');
            }
        }else{
                Session::put('message','Password or account is incorrect, please fill in again');
                return Redirect::to('/admin');
        }
       

    }
    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }
}
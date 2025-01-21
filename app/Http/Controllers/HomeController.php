<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Mail;
use App\Slider;
use App\Product;
use App\CategoryProductModel;
use App\Contact;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function error_page(){
        return view('errors.404');
    }
    public function send_mail(){
         //send mail
                $to_name = "Dzung Ho";
                $to_email = "ducdunggl2014@gmail.com";//send to this email
               
             
                $data = array("name"=>"Mail from Customer account","body"=>'Email sent about goods issue'); //body of mail.blade.php
                
                Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){

                    $message->to($to_email)->subject('Test sending email to google');//send this mail with subject
                    $message->from($to_email,$to_name);//send from this mail
                });
                // return redirect('/')->with('message','');
                //--send mail
    }

    public function index(Request $request){
        //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        //seo 
        $meta_desc = "Specializing in selling game accessories and equipment"; 
        $meta_keywords = "Game equipment, game accessories, computer accessories, entertainment";
        $meta_title = "Home | Laptop Store, specializing in selling Laptops and computer components";
        $url_canonical = $request->url();
        //--seo
        
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        // ->orderby('tbl_product.product_id','desc')->get();
        
        $all_product = DB::table('tbl_product')->where('product_status','1')->orderby(DB::raw('RAND()'))->paginate(8); 

        $cate_pro_tabs = CategoryProductModel::where('category_parent',1)->orderBy('category_id','desc')->get();

        $contact = Contact::where('info_id',1)->get();


    	return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('contact',$contact)->with('cate_pro_tabs',$cate_pro_tabs); //1
        // return view('pages.home')->with(compact('cate_product','brand_product','all_product')); //2
    }
    public function search(Request $request){
         //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        //seo 
        $meta_desc = "Search for products"; 
        $meta_keywords = "Search for products";
        $meta_title = "Search for products";
        $url_canonical = $request->url();
        //--seo
        $keywords = $request->keywords_submit;
        $contact = Contact::where('info_id',1)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

        $search_product = DB::table('tbl_product')->where('product_status','1')->where('product_name','like','%'.$keywords.'%')->get(); 


        return view('pages.sanpham.search')->with('category',$cate_product)->with('brand',$brand_product)->with('search_product',$search_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('contact',$contact);

    }

    public function autocomplete_ajax(Request $request){
        $data = $request->all();
        if($data['query']){
            $product = Product::where('product_status',1)->where('product_name','LIKE','%'.$data['query'].'%')->get();
            $output = '
            <ul class ="dropdown-menu" style="display:block; position:absolute; left: 3%;">';
            foreach ($product as $key => $val) {
                    $output .=  '
                    <li><a href="#">'.$val->product_name.'</a></li>';
                   
                }
            $output .='</ul>';
            echo $output;
        
        }
    }

    public function yeu_thich(Request $request){
        //category post
       $category_post = CatePost::orderBy('cate_post_id','DESC')->get();

       //slide
       $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
       //seo 
       $meta_desc = "Favourite"; 
       $meta_keywords = "Favourite";
       $meta_title = "Favourite";
       $url_canonical = $request->url();
       //--seo
       
       $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_parent','desc')->orderby('category_order','ASC')->get(); 
       
       $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

       // $all_product = DB::table('tbl_product')
       // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
       // ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
       // ->orderby('tbl_product.product_id','desc')->get();
       
       $all_product = DB::table('tbl_product')->where('product_status','0')->orderby(DB::raw('RAND()'))->paginate(6); 

       return view('pages.yeuthich.yeuthich')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('category_post',$category_post); //1

   }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Brand;
use App\Slider;
use Session;
use Auth;
use App\Product;
use App\Contact;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
use Toastr;
class BrandProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_brand_product(){
        $this->AuthLogin();
    	return view('admin.brand.add_brand_product');
    }
    public function all_brand_product(){
        $this->AuthLogin();
        $all_brand_product = Brand::orderBy('brand_id','DESC')->paginate(3);
    	$manager_brand_product  = view('admin.brand.all_brand_product')->with('all_brand_product',$all_brand_product);
    	return view('admin_layout')->with('admin.brand.all_brand_product', $manager_brand_product);


    }
    public function save_brand_product(Request $request){
        $this->AuthLogin();

        $data = $request->validate([
        'brand_name' => 'required|unique:tbl_brand|max:255',
        
        'brand_slug' => 'required',
        'brand_product_desc' => 'required',
        'brand_product_status' => 'required',
       
        
    ],[ 
'brand_name.required' => 'Brand name cannot be empty',
        'brand_name.unique' => 'Brand name already exists, please choose another name',

        'brand_slug.required' => 'Please fill in the brand slug',

        
        'brand_product_desc.required' => 'Please fill in brand description',
        
       
      
    ]
);
        $brand = new Brand();
        $brand->brand_name = $data['brand_name'];
        $brand->brand_slug = $data['brand_slug'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();
        Toastr::success('Adding successful product brands','Successful');

    	return Redirect::to('add-brand-product');
    }
    public function unactive_brand_product($brand_product_id){
        $this->AuthLogin();

        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        
        Toastr::success('Product brand deactivation successful','Successful');

        return redirect()->back();

    }
    public function active_brand_product($brand_product_id){
        $this->AuthLogin();

        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);

        Toastr::success('Successful product brand activation','Success');

        return redirect()->back();
        

    }
    public function edit_brand_product($brand_product_id){
        $this->AuthLogin();

        $edit_brand_product = Brand::where('brand_id',$brand_product_id)->get();
        $manager_brand_product  = view('admin.brand.edit_brand_product')->with('edit_brand_product',$edit_brand_product);

        return view('admin_layout')->with('admin.brand.edit_brand_product', $manager_brand_product);
    }
    public function update_brand_product(Request $request,$brand_product_id){
        $this->AuthLogin();
        $data = $request->all();
        $brand = Brand::find($brand_product_id);
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_slug = $data['brand_product_slug'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();
        Toastr::success('Successful product brand update','Successful');

        return Redirect::to('all-brand-product');
    }
    public function delete_brand_product($brand_product_id){
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->delete();
        Toastr::success('Successful product brand deletion','Successful');

        return Redirect::to('all-brand-product');
    }

    //End Function Admin Page
     
     public function show_brand_home(Request $request, $brand_slug){
        //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 
        

        $brand_by_slug = Brand::where('brand_slug',$brand_slug)->get();

        foreach ($brand_by_slug as $key => $brand) {
            $brand_id = $brand->brand_id;
        }

        if(isset($_GET['sort_by'])) {
          $sort_by = $_GET['sort_by'];
            if($sort_by =='giam_dan'){
                $brand_by_id = Product::with('brand')->where('brand_id',$brand_id)->orderBy('product_price','DESC')->paginate(6)->appends(request()->query());
            }elseif($sort_by =='tang_dan'){
                $brand_by_id = Product::with('brand')->where('brand_id',$brand_id)->orderBy('product_price','ASC')->paginate(6)->appends(request()->query());
            }elseif($sort_by =='kytu_za'){
                $brand_by_id = Product::with('brand')->where('brand_id',$brand_id)->orderBy('product_name','desc')->paginate(6)->appends(request()->query());
            }elseif($sort_by =='kytu_az'){
                $brand_by_id = Product::with('brand')->where('brand_id',$brand_id)->orderBy('product_name','asc')->paginate(6)->appends(request()->query());
            }
        }
            else{
                $brand_by_id = Product::with('brand')->where('brand_id',$brand_id)->orderBy('product_id','DESC')->paginate(6);
            }
        
        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_slug',$brand_slug)->limit(1)->get();
        $contact = Contact::where('info_id',1)->get();

        foreach($brand_name as $key => $val){
            //seo 
            $meta_desc = $val->brand_desc; 
            $meta_keywords = $val->brand_desc;
            $meta_title = $val->brand_name;
            $url_canonical = $request->url();
            //--seo
        }
         
        return view('pages.brand.show_brand')->with('category',$cate_product)->with('brand',$brand_product)->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('contact',$contact);
    }
}
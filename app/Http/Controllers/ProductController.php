<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Slider;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Product;
use App\Gallery;
use Auth;
use App\Contact;
use File;
use Toastr;
session_start();
class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_product(){
        //$this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get(); 
       

        // return view('admin.product.add_product')->with('cate_product', $cate_product)->with('brand_product',$brand_product);
        return view('admin.product.add_product')->with('cate_product', $cate_product)->with('brand_product',$brand_product);
    	

    }
    public function all_product(){
        //$this->AuthLogin();
    	$all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderby('tbl_product.product_id','desc')->get();
    	$manager_product  = view('admin.product.all_product')->with('all_product',$all_product);
    	return view('admin_layout')->with('admin.product.all_product', $manager_product);

    }
    public function save_product(Request $request){
         $this->AuthLogin();
    	// $data = array();

        $data = $request->validate([
        'product_name' => 'required|unique:tbl_product|max:255',
        'price_cost' => 'required|numeric|min:1|max:100000000',
        'product_quantity' => 'required|numeric|min:1|max:10000',
        'product_slug' => 'required',
        'product_price' => 'required|numeric|min:1|max:;100000000',
        'product_desc' => 'required',
        'product_content' => 'required',
        // 'category_id' => 'required',
        // 'brand_id' => 'required',
        'product_status' => 'required',
        'product_image' => 'required',
    ],
       [
        'product_name.required' => 'Please fill in product name',
        'product_name.unique' => 'The product name already exists, please enter another name',

        'price_cost.required'  => 'Please fill in the original product price',
        'price_cost.numeric'  => 'Original price needs to be filled in in the correct number format',
        'price_cost.max'  => 'Original price no more than 1 billion',
        'price_cost.min'  => 'Original price is a positive number',

        'product_quantity.required' => 'Please fill in product quantity',
        'product_quantity.numeric' => 'Product quantity needs to be filled in numeric format',
        'product_quantity.max' => 'Product quantity cannot exceed 10000',
        'product_quantity.min' => 'Product quantity is a positive number',

        'product_slug.required' => 'Please fill in product slug',

        'product_price.required' => 'Please fill in product price',
        'product_price.numeric' => 'Please fill in the correct number format',
        'product_price.max' => 'Product price no more than 1 billion',
        'product_price.min' => 'Product price is a positive number',
        'product_desc.required' => 'Please fill in product description',

        'product_content.required' => 'Please product content',
        'category_id.required' => 'Please fill in product category',
        'brand_id.required' => 'Please fill in product brand',
        'product_status.required' => 'Please fill in product status',
        'product_image.required' => 'Please fill in product image',
    ]
    );

        $product_price = filter_var($request->product_price,FILTER_SANITIZE_NUMBER_INT);
        $price_cost = filter_var($request->price_cost,FILTER_SANITIZE_NUMBER_INT);

    	$data['product_name'] = $request->product_name;
    	$data['price_cost'] =   $price_cost;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug'] = $request->product_slug;
    	$data['product_price'] =  $product_price;
    	$data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $data['product_image'] = $request->product_status;
        $get_image = $request->file('product_image');
        
        $path = 'public/uploads/product/';
        $path_gallery = 'public/uploads/gallery/';
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            File::copy($path.$new_image,$path_gallery.$new_image);
            $data['product_image'] = $new_image;
            
        }

        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();
        $gallery->gallery_images = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();
        Toastr::success('Successfully added product','Success');
        return Redirect::to('all-product');

       
    }
    public function unactive_product($product_id){
         $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
        Toastr::success('Product deactivation successful','Success');
        return redirect()->back();

    }
    public function active_product($product_id){
         $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
        Toastr::success('Product activation successful','Success');
        return redirect()->back();

    }
    public function edit_product($product_id){
         $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get(); 

        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();

        $manager_product  = view('admin.product.edit_product')->with('edit_product',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);

        return view('admin_layout')->with('admin.product.edit_product', $manager_product);
    }
    public function update_product(Request $request,$product_id){
         $this->AuthLogin();
         $product_price = filter_var($request->product_price,FILTER_SANITIZE_NUMBER_INT);
        $price_cost = filter_var($request->price_cost,FILTER_SANITIZE_NUMBER_INT);

        $data = array();
        $data['product_name'] = $request->product_name;
        $data['price_cost'] =   $price_cost;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug'] = $request->product_slug;
        $data['product_price'] =     $product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');
        
        if($get_image){
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image));
                    $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                    $get_image->move('public/uploads/product',$new_image);
                    $data['product_image'] = $new_image;
                    DB::table('tbl_product')->where('product_id',$product_id)->update($data);
                    Toastr::success('Product update successful','Success');
                    return Redirect::to('all-product');
        }
            
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Toastr::success('Successful product update','Successful');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Toastr::success('Product deletion successful','Successful');
        return Redirect::to('all-product');
    }
    //End Admin Page
    public function details_product($product_slug , Request $request){
         //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

       


        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

        $details_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_slug',$product_slug)->get();
        $contact = Contact::where('info_id',1)->get();

        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
            $product_id = $value->product_id;
            $product_cate = $value->category_name;
            $cate_slug = $value->slug_category_product;
             //seo 
             $meta_desc = $value->product_desc;
                $meta_keywords = $value->product_slug;
                $meta_title = $value->product_name;
                $url_canonical = $request->url();
                //--seo   
            }
            //update views product
            $product = Product::where('product_id',$product_id)->first();
            $product->product_views = $product->product_views+1;
            $product->save();

         // gallery
         $gallery = Gallery::where('product_id',$product_id)->get();
       // related product
        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_slug',[$product_slug])->orderby(DB::raw('RAND()'))->paginate(3);


        return view('pages.sanpham.show_details')->with('category',$cate_product)->with('brand',$brand_product)->with('product_details',$details_product)->with('relate',$related_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('contact',$contact)->with('gallery',$gallery)->with('product_cate',$product_cate)->with('cate_slug',$cate_slug);

    }
}
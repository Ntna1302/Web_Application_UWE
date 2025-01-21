<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Slider;
use App\Exports\ExcelExports;
use App\Imports\ExcelImports;
use Excel;
use App\CategoryProductModel;
use Session;
use App\Http\Requests;
use App\Product;
use App\Contact;
use Illuminate\Support\Facades\Redirect;
session_start();
use Auth;
use Toastr;

class CategoryProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_category_product(){
        $this->AuthLogin();
        $category=CategoryProductModel::where('category_parent',1)->orderBy('category_id','desc')->get();
    	return view('admin.category.add_category_product')->with(compact('category'));
        
    }
    public function all_category_product(){
        $this->AuthLogin();
        $category_product = CategoryProductModel::where('category_parent',1)->orderBy('category_id','desc')->get();
    	$all_category_product = DB::table('tbl_category_product')->orderBy('category_parent','desc')->paginate(5);
    	$manager_category_product  = view('admin.category.all_category_product')->with('all_category_product',$all_category_product)->with('category_product', $category_product);
        
    	return view('admin_layout')->with('admin.category.all_category_product', $manager_category_product);


    }
    public function save_category_product(Request $request){

        $this->AuthLogin();

        $data = $request->validate([
        'category_name' => 'required|unique:tbl_category_product|max:255',
        
        'category_parent' => 'required',
        'category_product_keywords' => 'required',
        'slug_category_product' => 'required',
        'category_product_desc' => 'required',
        'category_product_status' => 'required', 
        
    ],[ 
       'category_name.required' => 'Category name cannot be empty',
        'category_name.unique' => 'Category name already exists, please choose another name',

       
        'category_product_keywords.required' => 'Please fill in category keywords',
        'slug_category_product.required' => 'Please fill in the category slug',
        'category_product_desc.required' => 'Please fill in description',
    ]
);
        
        
        if($data){
        $category = new CategoryProductModel();
        $category->category_name = $data['category_name'];
        $category->category_parent = $data['category_parent'];
        $category->meta_keywords = $data['category_product_keywords'];
        $category->slug_category_product = $data['slug_category_product'];
        $category->category_desc = $data['category_product_desc'];
        $category->category_status = $data['category_product_status'];
        $category->save();
        Toastr::success('Add product category successfully','Successful');

    	return Redirect::to('add-category-product');
        }
        else{
            Session::put('message','Please fill in all fields');
        
    	    return Redirect::to('add-category-product');
        }
      
    }
    public function unactive_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        Toastr::success('Product category deactivation successful','Successful');
        return redirect()->back();

    }
    public function active_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        Toastr::success('Successful product catalog activation','Successful');
        return redirect()->back();
    }
    public function edit_category_product($category_product_id){
        $this->AuthLogin();
        $category=CategoryProductModel::orderBy('category_id','desc')->get();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();

        $manager_category_product  = view('admin.category.edit_category_product')->with('edit_category_product',$edit_category_product)->with('category',$category);

        return view('admin_layout')->with('admin.category.edit_category_product', $manager_category_product);
    }
    public function update_category_product(Request $request,$category_product_id){
        $this->AuthLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_parent'] = $request->category_parent;
        $data['meta_keywords'] = $request->category_product_keywords;
        $data['slug_category_product'] = $request->slug_category_product;
        $data['category_desc'] = $request->category_product_desc;
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Toastr::success('Successful product catalog update','Successful');
        return Redirect::to('all-category-product');
    }
    public function delete_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Toastr::success('Delete product category successfully','Successful');
        return Redirect::to('all-category-product');
    }

    //End Function Admin Page
    public function show_category_home(Request $request ,$slug_category_product){
       //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

        $category_by_slug = CategoryProductModel::where('slug_category_product',$slug_category_product)->get();
        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');

        $min_price_range =  $min_price - 500000;
        $max_price_range =  $max_price + 5000000;

        foreach ($category_by_slug as $key => $cate) {
            $category_id = $cate->category_id;
        }

        if(isset($_GET['sort_by'])) {
          $sort_by = $_GET['sort_by'];
            if($sort_by =='giam_dan'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_price','DESC')->paginate(6)->appends(request()->query());
            }elseif($sort_by =='tang_dan'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_price','ASC')->paginate(6)->appends(request()->query());
            }elseif($sort_by =='kytu_za'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_name','desc')->paginate(6)->appends(request()->query());
            }elseif($sort_by =='kytu_az'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_name','asc')->paginate(6)->appends(request()->query());
            }
        }
        elseif(isset($_GET['start_price']) && $_GET['end_price']){
                $min_price = $_GET['start_price'];
                $max_price = $_GET['end_price'];

                $category_by_id = Product::with('category')->where('category_id',$category_id)->whereBetween('product_price',[$min_price,$max_price])->orderBy('product_price','desc')->paginate(6)->appends(request()->query());
            }

        

            else{
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_id','DESC')->paginate(6);
            }
             
       
        $contact = Contact::where('info_id',1)->get();

        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.slug_category_product',$slug_category_product)->limit(1)->get();


        foreach($category_name as $key => $val){
                //seo 
                $meta_desc = $val->category_desc; 
                $meta_keywords = $val->meta_keywords;
                $meta_title = $val->category_name;
                $url_canonical = $request->url();
                //--seo
                }


        return view('pages.category.show_category')->with('category',$cate_product)->with('brand',$brand_product)->with('category_by_id',$category_by_id)->with('category_name',$category_name)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('contact',$contact)->with('min_price',$min_price)->with('max_price',$max_price)->with('max_price_range',$max_price_range)->with('min_price_range',$min_price_range);
        
    }



    public function export_csv(){
        return Excel::download(new ExcelExports , 'category_product.xlsx');
    }
    public function import_csv(Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new ExcelImports, $path);
        return back();
    }

    public function product_tabs(Request $request){
        $data = $request->all();

        $output = '';

        $subcategory = CategoryProductModel::where('category_parent',$data['cate_id'])->get();

        $sub_array = array();
        foreach ($subcategory as $key => $sub) {
            $sub_array[] =$sub->category_id;
        }
        array_push($sub_array,$data['cate_id']);
        $product = Product::whereIn('category_id',$sub_array)->orderBy('product_id','desc')->get();

        $product_count = $product->count();
        if($product_count>0){
            $output .= ' <div class="tab-content">
            <div class="tab-pane fade active in" id="tshirt">';
                foreach ($product as $key => $val) {
                
               
              $output .= '<div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="'.url('public/uploads/product/'.$val->product_image).'" alt="'.$val->product_name.'" />
                                <h2>'.number_format($val->product_price,0,',','.').' VNĐ</h2>
                                <p>'.$val->product_name.'</p>
                                <a href="'.url('/chi-tiet/'.$val->product_slug).'" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>See details</a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
                
                $output .= '</div>



        </div>';
        }else{
            $output .= ' <div class="tab-content">
            <div class="tab-pane fade active in" id="tshirt">
                <div class="col-sm-12">
                    <p>There are currently no products</p>

                </div>


            </div>



        </div>';
        }
        echo $output;
    }
  

}
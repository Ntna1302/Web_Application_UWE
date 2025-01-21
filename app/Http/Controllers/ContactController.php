<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Contact;
use App\Slider;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class ContactController extends Controller
{
   public function lien_he(Request $request){
        //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        //seo 
        $meta_desc = "Contact"; 
        $meta_keywords = "Contact";
        $meta_title = "Contact us";
        $url_canonical = $request->url();
        //--seo
        
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

        $contact = Contact::where('info_id',1)->get();

        return view('pages.lienhe.contact')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('contact',$contact); 
   }

   public function information(){
    $contact = Contact::where('info_id',1)->get();
    // dd($contact);
    return view('admin.information.add_information')->with(compact('contact'));
   }
public function update_info(Request $request,$info_id){
    $data=$request->all();
    $contact = Contact::find($info_id);
    $contact->info_contact = $data['info_contact'];
    $contact->info_map = $data['info_map'];
    $contact->slogan_logo = $data['slogan_logo'];
    $contact->info_fanpage = $data['info_fanpage'];
    $get_image = $request->file('info_image');
    $path = 'public/uploads/contact/';
    if($get_image){
        
        unlink($path.$contact->info_logo);
        $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/contact',$new_image);
            $contact->info_logo = $new_image; 
        }
        $contact->save();
        return redirect()->back()->with('message','Successfully updated website information');
}
   public function save_info(Request $request){
    $data=$request->all();
    $contact = new Contact();
    $contact->info_contact = $data['info_contact'];
    $contact->info_map = $data['info_map'];
    $contact->info_fanpage = $data['info_fanpage'];
    $get_image = $request->file('info_image');
    if($get_image){
        $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/contact',$new_image);
            $contact->info_logo = $new_image; 
        }
        $contact->save();
        return redirect()->back()->with('message','Successfully updated website information');
   }
}
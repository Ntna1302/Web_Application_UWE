<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Product;
use App\Post;
use App\Order;
use App\Video;
use App\Customer;
use App\Contact;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*',function($view){
        
        $contact = Contact::where('info_id',1)->get();

        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');

        $min_price_range =  $min_price - 500000;
        $max_price_range =  $max_price + 5000000;

       //  total
       $product = Product::all()->count();
        //  $post = Post::all()->count();
         $order = Order::all()->count();
        //  $video = Video::all()->count();
         $customer = Customer::all()->count();


         $view->with('product',$product)->with('order',$order)->with('customer',$customer)->with('min_price',$min_price)->with('max_price',$max_price)->with('max_price_range',$max_price_range)->with('min_price_range',$min_price_range)->with('contact',$contact);
        });
    }
}
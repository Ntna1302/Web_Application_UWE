@extends('layout')
@section('content')
<div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Search results</h2>
    @foreach($search_product as $key => $product)
    <div class="col-sm-3">
        <div class="product-image-wrapper">
            <a href="{{URL::to('/chi-tiet/'.$product->product_slug)}}">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                            @csrf
                            <input type="hidden" value="{{$product->product_id}}"
                                class="cart_product_id_{{$product->product_id}}">
                            <input type="hidden" value="{{$product->product_name}}"
                                class="cart_product_name_{{$product->product_id}}">
                            <input type="hidden" value="{{$product->product_image}}"
                                class="cart_product_image_{{$product->product_id}}">
                            <input type="hidden" value="{{$product->product_quantity}}"
                                class="cart_product_quantity_{{$product->product_id}}">
                            <input type="hidden" value="{{$product->product_price}}"
                                class="cart_product_price_{{$product->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                            <a href="{{URL::to('/chi-tiet/'.$product->product_slug)}}">
                                <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                <h2>{{number_format($product->product_price,0,',','.').' '.'VNĐ'}}</h2>
                                <p>{{$product->product_name}}</p>


                            </a>
                            @if(!Session::get('success_paypal')==true)

                            <input type="button" value="Add to cart" class="btn btn-default add-to-cart"
                                data-id_product="{{$product->product_id}}" name="add-to-cart">
                            @endif
                        </form>

                    </div>

                </div>
            </a>
            {{-- <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                </ul>
            </div> --}}
        </div>
    </div>
    @endforeach
</div>
<!--features_items-->
<!--/recommended_items-->
@endsection
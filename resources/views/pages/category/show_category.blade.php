@extends('layout')
@section('content_category')
<div class="features_items">
    <!-- Features Items Section -->

    @foreach($category_name as $key => $name)
        <h2 class="title text-center">{{$name->category_name}}</h2>
    @endforeach

    <!-- Sorting and Price Filtering -->
    <div class="row">
        <!-- Sorting Options -->
        <div class="col-md-4">
            <label for="amount">Sort By</label>
            <form>
                @csrf
                <select name="sort" id="sort" class="form-control">
                    <option value="{{Request::url()}}?sort_by=none">--Filter--</option>
                    <option value="{{Request::url()}}?sort_by=tang_dan">--Price: Low to High--</option>
                    <option value="{{Request::url()}}?sort_by=giam_dan">--Price: High to Low--</option>
                    <option value="{{Request::url()}}?sort_by=kytu_az">--Name: A to Z--</option>
                    <option value="{{Request::url()}}?sort_by=kytu_za">--Name: Z to A--</option>
                </select>
            </form>
        </div>

        <!-- Price Filtering -->
        <div class="col-md-4">
            <label for="amount">Filter by Price</label>
            <form>
                <div id="slider-range"></div>
                <div class="style-range">
                    <style type="text/css">
                        .style-range p {
                            float: left;
                            width: 50%;
                        }
                    </style>
                    <p>
                        <input type="text" id="amount_start" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    </p>
                    <p>
                        <input type="text" id="amount_end" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    </p>
                    <input type="hidden" id="start_price" name="start_price">
                </div>

                <input type="hidden" id="end_price" name="end_price">
                <br>
                <div class="clearfix"></div>
                <input type="submit" name="filter_price" value="Filter by Price" class="btn btn-sm btn-default">
            </form>
        </div>
    </div>

    <!-- Product List -->
    @foreach($category_by_id as $key => $product)
        @if(!Session::get('success_paypal') == true)
            <a href="{{URL::to('/chi-tiet/'.$product->product_slug)}}">
        @else
            <a href="{{URL::to('/checkout')}}">
        @endif
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                @csrf
                                <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                                <a href="{{URL::to('/chi-tiet/'.$product->product_slug)}}">
                                    <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                    <h2>{{number_format($product->product_price,0,',','.').' VNĐ'}}</h2>
                                    <p>{{$product->product_name}}</p>
                                </a>

                                @if(!Session::get('success_paypal') == true)
                                    <input type="button" value="Add to Cart" class="btn btn-default add-to-cart"
                                           data-id_product="{{$product->product_id}}" name="add-to-cart">
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#"><i class="fa fa-plus-square"></i> Add to Wishlist</a></li>
                            <li><a href="#"><i class="fa fa-plus-square"></i> Compare</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>

<!-- Pagination -->
<ul class="pagination pagination-sm m-t-none m-b-none">
    {!! $category_by_id->links() !!}
</ul>
@endsection

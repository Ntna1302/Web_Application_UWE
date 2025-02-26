@extends('layout')
@section('content')
@foreach($product_details as $key => $value)
<div class="product-details">

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb" style=" background:none">
			<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
			<li class="breadcrumb-item"><a href="{{url('/danh-muc/'.$cate_slug)}}">{{$product_cate}}</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{$meta_title}}</li>
		</ol>
	</nav>
	<!--product-details-->
	<div class="col-sm-7">
		<ul id="imageGallery">
			@foreach($gallery as $key => $gal)

			<li data-thumb="{{asset('public/uploads/gallery/'.$gal->gallery_images)}}"
				data-src="{{asset('public/uploads/gallery/'.$gal->gallery_images)}}">
				<img width="100%" alt="{{$gal->gallery_name}}"
					src="{{asset('public/uploads/gallery/'.$gal->gallery_images)}}" />
			</li>
			@endforeach

		</ul>

	</div>
	<div class="col-sm-5">
		<div class="product-information">
			<!--/product-information-->
			<img src="images/product-details/new.jpg" class="newarrival" alt="" />
			<h2>{{$value->product_name}}</h2>
			<p>CODE ID: {{$value->product_id}}</p>
			<img src="images/product-details/rating.png" alt="" />

			<form action="{{URL::to('/save-cart')}}" method="POST">
				@csrf
				<input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">

				<input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">

				<input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">

				<input type="hidden" value="{{$value->product_quantity}}" class="cart_product_quantity_{{$value->product_id}}">

				<input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">

				<span>
					<span>{{number_format($value->product_price,0,',','.').'VNĐ'}}</span>

					<label>Quantity:</label>
					<input name="qty" type="number" min="1" class="cart_product_qty_{{$value->product_id}}" value="1" />
					<input name="productid_hidden" type="hidden" value="{{$value->product_id}}" />
				</span>
				@if(!Session::get('success_paypal')==true)

				<input type="button" value="Add to cart" class="btn btn-primary btn-sm add-to-cart"
					data-id_product="{{$value->product_id}}" name="add-to-cart">
				@endif
			</form>

			{{-- <p><b>Tình trạng:</b> Còn hàng</p> --}}
			<p><b>Condition:</b> <span>
					New Seal 100%</span>
			</p>
			<p><b>Quantity:</b> <span>{{$value->product_quantity}}</span></p>
			<p><b>Brand: </b><span style="text-transform: uppercase">{{ $value->brand_name}}</span></p>
			<p><b>Categories:</b> <span>{{$value->category_name}}</span></p>
			<a href=""><img src="images/product-details/share.png" class="share img-responsive" alt="" /></a>
		</div>
		<!--/product-information-->
	</div>
</div>
<!--/product-details-->

<div class="category-tab shop-details-tab">
	<!--category-tab-->
	<div class="col-sm-12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#details" data-toggle="tab">Descriptions</a></li>
			<li><a href="#companyprofile" data-toggle="tab">Items details</a></li>

			<li><a href="#reviews" data-toggle="tab">Reviews</a></li>
		</ul>
	</div>
	<div class="tab-content">
		<div class="tab-pane fade active in" id="details">
			<p>{!!$value->product_desc!!}</p>

		</div>

		<div class="tab-pane fade" id="companyprofile">
			<p>{!!$value->product_content!!}</p>


		</div>

		<div class="tab-pane fade" id="reviews">
			<div class="col-sm-12">
				<ul>
					<li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
					<li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
					<li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
				</ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
					dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
					commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
					pariatur.</p>
				<p><b>Write Your Review</b></p>

				<form action="#">
					<span>
						<input type="text" placeholder="Your Name" />
						<input type="email" placeholder="Email Address" />
					</span>
					<textarea name=""></textarea>
					<b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
					<button type="button" class="btn btn-default pull-right">
						Submit
					</button>
				</form>
			</div>
		</div>

	</div>
</div>
<!--/category-tab-->
@endforeach
<div class="recommended_items">
	<!--recommended_items-->
	<h2 class="title text-center">Related Items</h2>

	<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="item active">
				@foreach($relate as $key => $lienquan)
				<div class="col-sm-4">
					<div class="product-image-wrapper">
						<div class="single-products">

							<div class="productinfo text-center product-related">
								<a href="{{URL::to('/chi-tiet/'.$lienquan->product_slug)}}">
									<img src="{{URL::to('public/uploads/product/'.$lienquan->product_image)}}" alt="" />
									<h2>{{number_format($lienquan->product_price,0,',','.').' '.'VNĐ'}}</h2>
									<p>{{$lienquan->product_name}}</p>
								</a>
							</div>

						</div>
					</div>
				</div>
				@endforeach


			</div>

		</div>

	</div>
</div>
<!--/recommended_items-->
{{-- <ul class="pagination pagination-sm m-t-none m-b-none">
	{!!$relate->links()!!}
</ul> --}}

@endsection
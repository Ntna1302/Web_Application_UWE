@extends('layout')
@section('content_cart')

<section id="cart_items">
	<div class="container" style="width:900px">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{URL::to('/')}}">Home</a></li>
				<li class="active">Your Cart</li>
			</ol>
		</div>
		@if(session()->has('message'))
		<div class="alert alert-success">
			{!! session()->get('message') !!}
		</div>
		@elseif(session()->has('error'))
		<div class="alert alert-danger">
			{!! session()->get('error') !!}
		</div>
		@endif
		<div class="table-responsive cart_info">

			<form action="{{url('/update-cart')}}" method="POST">
				@csrf
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Image</td>
							<td class="description">Product Name</td>
							<td class="price">Product Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Subtotal</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@if(Session::get('cart')==true)
						@php
						$total = 0;
						@endphp
						@foreach(Session::get('cart') as $key => $cart)
						@php
						$subtotal = $cart['product_price']*$cart['product_qty'];
						$total+=$subtotal;
						@endphp

						<tr>
							<td class="cart_product">
								<img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="90"
									alt="{{$cart['product_name']}}" />
							</td>
							<td class="cart_description">

								<p style="width:150px;">{{$cart['product_name']}}</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">


									<input class="cart_quantity" style="width:50px" type="number"
										@if(Session::get('success_paypal')==true) readonly @endif min="1"
										name="cart_qty[{{$cart['session_id']}}]" size="10" value="{{$cart['product_qty']}}">


								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									{{number_format($subtotal,0,',','.')}}đ

								</p>
							</td>
							@if(!Session::get('success_paypal')==true)

							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i
										class="fa fa-times"></i></a>
							</td>
							@endif
						</tr>

						@endforeach
						<tr>
							@if(!Session::get('success_paypal')==true)
							<td><input type="submit" value="Update Cart" name="update_qty"
									class="check_out btn btn-default btn-sm"></td>
							<td><a class="btn btn-default check_out" href="{{url('/del-all-product')}}">Delete All</a></td>
							@endif

							<td>
								@if(Session::get('customer_id'))
								<a class="btn btn-success" style="margin-top:16px" href=" {{url('/checkout')}}">
									Proceed to Checkout
									@else
									<a class="btn btn-success" style="margin-top:16px" href=" {{url('/dang-nhap')}}">Proceed to Checkout</a>
									@endif
							</td>


							<td colspan="2">
								<li>Total:<span>{{number_format($total,0,',','.')}}đ</span></li>
								@if(Session::get('coupon'))
								<li>
									@foreach(Session::get('coupon') as $key => $cou)
									@if($cou['coupon_condition']==1)
									Discount Code: {{$cou['coupon_number']}} %

									@php
									$total_coupon = ($total*$cou['coupon_number'])/100;
									@endphp


									@php
									$total_after_coupon = $total-$total_coupon;
									@endphp

									@elseif($cou['coupon_condition']==2)
									Discount Code: {{number_format($cou['coupon_number'],0,',','.')}}đ

									@php
									$total_coupon = $total - $cou['coupon_number'];
									@endphp

									@php
									$total_after_coupon = $total_coupon;
									@endphp
									@endif
									@endforeach



								</li>
								@endif

								@if(Session::get('fee'))
								<li>Shipping Fee: <span>{{number_format(Session::get('fee'),0,',','.')}}đ</span>
									<a class="cart_quantity_delete" href="{{url('/del-fee')}}"><i class="fa fa-times"></i></a>
								</li>
								<?php $total_after_fee = $total + Session::get('fee'); ?>
								@endif
								<li style="font-weight:bold">Final Total:
									@php
									if(Session::get('fee') && !Session::get('coupon')){
									$total_after = $total_after_fee;
									echo number_format($total_after,0,',','.').'đ';
									}elseif(!Session::get('fee') && Session::get('coupon')){
									$total_after = $total_after_coupon;
									echo number_format($total_after,0,',','.').'đ';
									}elseif(Session::get('fee') && Session::get('coupon')){
									$total_after = $total_after_coupon;
									$total_after = $total_after + Session::get('fee');
									echo number_format($total_after,0,',','.').'đ';
									}elseif(!Session::get('fee') && !Session::get('coupon')){
									$total_after = $total;
									echo number_format($total_after,0,',','.').'đ';
									}

									@endphp
								</li>

							</td>

						</tr>
						@else
						<tr>
							<td colspan="5">
								<center>
									@php
									echo 'Please add products to your cart.';
									@endphp
								</center>
							</td>
						</tr>
						@endif
					</tbody>



			</form>
			@if(!Session::get('success_paypal')==true)
			@if(Session::get('cart'))
			<tr>
				<td>

					<form method="POST" action="{{url('/check-coupon')}}">
						@csrf
						<input type="text" class="form-control" name="coupon" placeholder="Enter discount code"><br>

						<input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Apply Discount Code">





					</form>
				</td>
				<td>
					@if(Session::get('coupon'))
					<a class="btn btn-default check_out" style="margin-bottom: 70px;" href="{{url('/unset-coupon')}}">Remove Discount Code</a>
					@endif
				</td>
			</tr>
			@endif
			@endif

			</table>

		</div>
	</div>
</section>
<!--/#cart_items-->

@endsection

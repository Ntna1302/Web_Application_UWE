<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Send coupon to customer </title>
</head>

<body>
	<div class="coupon">
		<div class="container">
			<h3>Discount coupon form Na computer store <a target="_blank" href="http://laptopstore.com/LaptopStore/">LapTop Store
				</a></h3>

		</div>
		<div class="container">
			<h2 class="note">
				@if($coupon['coupon_condition'] == 1)
				Discount {{$coupon['coupon_number']}}%
				@else
				Discount {{number_format($coupon['coupon_number'],0,',','.')}}k
				@endif
				for all of your bill
			</h2>
		</div>
		<div class="container">
			<p class="code">Use this code: <span class="promo">{{$coupon['coupon_code']}}</span> with
			  {{$coupon['coupon_time']}} discount coupon, hurry up!
			</p>
			<p class="expire">Start date: {{$coupon['start_coupon']}} - Expired date:{{$coupon['end_coupon']}} </p>
		  </div>
	</div>

</body>

</html>
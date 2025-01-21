@extends('admin_layout')
@section('admin_content')
<div class="tables">
  <h2 class="title1">Login information</h2>


  <div class="bs-example widget-shadow" data-example-id="hoverable-table">
    <h4>
      @php
      $message = Session::get('message');
      if($message){
      echo '<span class="text-alert">'.$message.'</span>';
      Session::put('message',null);
      }
      @endphp
    </h4>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Customer name</th>
          <th>Phone number</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{$getcustomer->customer_name}}</td>
          <td>{{$getcustomer->customer_phone}}</td>
          <td>{{$getcustomer->customer_email}}</td>
        </tr>

      </tbody>
    </table>
  </div>

</div>
<br>
<div class="tables">
  <h2 class="title1">Shipping information
  </h2>


  <div class="bs-example widget-shadow" data-example-id="hoverable-table">
    <h4>
      @php
      $message = Session::get('message');
      if($message){
      echo '<span class="text-alert">'.$message.'</span>';
      Session::put('message',null);
      }
      @endphp
    </h4>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Carrier name</th>
          <th>Address</th>
          <th>Phone number</th>
          <th>Email</th>
          <th>Notes</th>
          <th>Payment method</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{$shipping->shipping_name}}</td>
          <td>{{$shipping->shipping_address}}</td>
          <td>{{$shipping->shipping_phone}}</td>
          <td>{{$shipping->shipping_email}}</td>
          <td>{{$shipping->shipping_notes}}</td>
          <td>@if($shipping->shipping_method=='chuyenkhoan') Transfer @elseif($shipping->shipping_method=='tienmat')
            Cash
            @else VNPAY
            @endif</td>


        </tr>
      </tbody>
    </table>
  </div>


</div>

<br>
<div class="tables">
  <h2 class="title1">List order details
  </h2>


  <div class="bs-example widget-shadow" data-example-id="hoverable-table">
    <h4>
      @php
      $message = Session::get('message');
      if($message){
      echo '<span class="text-alert">'.$message.'</span>';
      Session::put('message',null);
      }
      @endphp
    </h4>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Product name</th>
          <th>Quantity in stock</th>
          <th>Discount code</th>
          <th>Shipping fee</th>
          <th>Quantity</th>
          <th>Selling price</th>
          <th>Original price</th>
          <th>Total amount</th>
        </tr>
      </thead>
      <tbody>

        @php
        $total = 0;
        @endphp
        @foreach($order_details as $key => $details)
        @php
        $subtotal = $details->product_price*$details->product_sales_quantity;
        $total+=$subtotal;
        @endphp
        <tr class="color_qty_{{$details->product_id}}">

          <th scope="row">{{1 + $key++}}</th>
          <td>{{$details->product_name}}</td>
          <td>{{$details->product->product_quantity}}</td>
          <td>@if($details->product_coupon!='no')
            {{$details->product_coupon}}
            @else
            No discount
            @endif
          </td>
          <td>{{number_format($details->product_feeship ,0,',','.')}}đ</td>
          <td>

            <input type="number" min="1" {{$order_status==2 ? 'disabled' : '' }}
              class="order_qty_{{$details->product_id}}" value="{{$details->product_sales_quantity}}"
              name="product_sales_quantity">

            <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}"
              value="{{$details->product->product_quantity}}">

            <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">

            <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">

            @if($order_status!=2)

            <button class="btn btn-default update_quantity_order" data-product_id="{{$details->product_id}}"
              name="update_quantity_order">Update</button>

            @endif

          </td>
          <td>{{number_format($details->product_price ,0,',','.')}}đ</td>
          <td>{{number_format($details->product->price_cost ,0,',','.')}}đ</td>
          <td>{{number_format($subtotal ,0,',','.')}}đ</td>
        </tr>
        @endforeach
        <tr>
          <td colspan="2">
            @php
            $total_coupon = 0;
            @endphp
            @if($coupon_condition==1)
            @php
            $total_after_coupon = ($total*$coupon_number)/100;
            echo 'Total Discount: '.number_format($total_after_coupon,0,',','.').'</br>';
            $total_coupon = $total + $details->product_feeship - $total_after_coupon ;
            @endphp
            @else
            @php
            echo 'Total Discount: '.number_format($coupon_number,0,',','.').'k'.'</br>';
            $total_coupon = $total + $details->product_feeship - $coupon_number ;

            @endphp
            @endif

            Shipping fee : {{number_format($details->product_feeship,0,',','.')}}đ</br>
            Paid: {{number_format($total_coupon,0,',','.')}}đ
          </td>
        </tr>
        <tr>
          <td colspan="6">
            @foreach($getorder as $key => $or)
            @if($or->order_status==1)

            <form>
              @csrf
              <select class="form-control order_details">
                <option id="{{$or->order_id}}" selected value="1">Not processed yet</option>
                <option id="{{$or->order_id}}" value="2">Processed - Delivered</option>

            </form>

            @else
            <form>
              @csrf
              <select class="form-control order_details">

                <option disabled id="{{$or->order_id}}" value="1">Not processed yet</option>
                <option id="{{$or->order_id}}" selected value="2">Processed - Delivered</option>

              </select>
            </form>
            @endif
            @endforeach
          </td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-success">
      <a target="_blank" href="{{url('/print-order/'.$details->order_code)}}">Print orders</a></button>
  </div>


</div>
@endsection
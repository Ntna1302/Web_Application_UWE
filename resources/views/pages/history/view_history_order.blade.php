@extends('layout')
@section('content')

<div class="container">
    <!-- Display Message -->
    <h4>
        @php
            $message = Session::get('message');
            if ($message) {
                echo '<span class="text-alert">' . $message . '</span>';
                Session::put('message', null);
            }
        @endphp
    </h4>

    <!-- Order Details Section -->
    <div class="tables">
        <h2 class="title1">Order Details [{{ $order_code }}]</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Mobile Number</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $getcustomer->customer_name }}</td>
                    <td>{{ $getcustomer->customer_phone }}</td>
                    <td>{{ $getcustomer->customer_email }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Shipping Information Section -->
    <div class="tables">
        <h2 class="title1">Shipping Information</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Notes</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $shipping->shipping_name }}</td>
                    <td>{{ $shipping->shipping_address }}</td>
                    <td>{{ $shipping->shipping_phone }}</td>
                    <td>{{ $shipping->shipping_email }}</td>
                    <td>{{ $shipping->shipping_notes }}</td>
                    <td>
                        @if ($shipping->shipping_method == 'chuyenkhoan')
                            Bank Transfer
                        @elseif ($shipping->shipping_method == 'tienmat')
                            Cash
                        @else
                            VNPay
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- VNPay Transaction Details Section -->
    <div class="tables">
        <h2 class="title1">VNPay Transaction Details</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Bank Code</th>
                    <th>Card Type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $transaction_id ?? 'N/A' }}</td>
                    <td>{{ $vnp_bankcode ?? 'N/A' }}</td>
                    <td>{{ $vnp_cardtype ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Order Items Section -->
    <div class="tables">
        <h2 class="title1">Order Items</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Discount Code</th>
                    <th>Shipping Fee</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($order_details as $key => $details)
                    @php
                        $subtotal = $details->product_price * $details->product_sales_quantity;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $details->product_name }}</td>
                        <td>{{ $details->product_coupon != 'no' ? $details->product_coupon : 'No Discount' }}</td>
                        <td>{{ number_format($details->product_feeship, 0, ',', '.') }}đ</td>
                        <td>{{ $details->product_sales_quantity }}</td>
                        <td>{{ number_format($details->product_price, 0, ',', '.') }}đ</td>
                        <td>{{ number_format($subtotal, 0, ',', '.') }}đ</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6"><strong>Total Amount</strong></td>
                    <td><strong>{{ number_format($total, 0, ',', '.') }}đ</strong></td>
                </tr>
                <tr>
                    <td colspan="6">Shipping Fee</td>
                    <td>{{ number_format($details->product_feeship, 0, ',', '.') }}đ</td>
                </tr>
                <tr>
                    <td colspan="6">Total Discount</td>
                    <td>
                        @if ($coupon_condition == 1)
                            {{ number_format(($total * $coupon_number) / 100, 0, ',', '.') }}đ
                        @else
                            {{ number_format($coupon_number, 0, ',', '.') }}đ
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="6"><strong>Final Payable Amount</strong></td>
                    <td>
                        <strong>
                            @php
                                $final_total = $coupon_condition == 1
                                    ? $total + $details->product_feeship - (($total * $coupon_number) / 100)
                                    : $total + $details->product_feeship - $coupon_number;
                            @endphp
                            {{ number_format($final_total, 0, ',', '.') }}đ
                        </strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

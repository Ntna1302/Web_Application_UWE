@extends('admin_layout')
@section('admin_content')
    <div class="tables">
        <h2 class="title1">List discount codes</h2>


        <div class="bs-example widget-shadow" data-example-id="hoverable-table">

            <h4>
                @php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session::put('message', null);
                    }
                @endphp
            </h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Discount code name</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Discount code</th>
                        <th>Discount quantity</th>
                        <th>Discount conditions</th>
                        <th>Decrease number</th>
                        <th>Expires</th>
                        <th>Management</th>
                        <th>Send code </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupon as $key => $cou)
                        <tr>
                            <th scope="row">{{ 1 + $key++ }}</th>
                            <td>{{ $cou->coupon_name }}</td>
                            <td>{{ $cou->coupon_date_start }}</td>
                            <td>{{ $cou->coupon_date_end }}</td>
                            <td>{{ $cou->coupon_code }}</td>
                            <td>{{ $cou->coupon_time }}</td>
                            <td><span class="text-ellipsis">
                                    <?php
               if($cou->coupon_condition==1){
                ?>
                                    Reduced by %
                                    <?php
                 }else{
                ?>
                                    Reduced by money
                                    <?php
               }
              ?>
                                </span>
                            </td>
                            <td><span class="text-ellipsis">
                                    <?php
               if($cou->coupon_condition==1){
                ?>
                                    Discount {{ $cou->coupon_number }} %
                                    <?php
   }else{
  ?>
                                    Decrease {{ $cou->coupon_number }} k
                                    <?php
               }
              ?>
                                </span></td>



                            <td>

                              @if ($cou->coupon_date_end >= $today)
                              <span style="color: green">Unexpired</span>
                          @else
                              <span style="color: red">Expired</span>
                          @endif

                            </td>
                            <td>


                                <a onclick="return confirm('Are you sure you want to delete this code?')"
                                    href="{{ URL::to('/delete-coupon/' . $cou->coupon_id) }}" class="active styling-edit"
                                    ui-toggle-class="">
                                    <i class="fa fa-times text-danger text"></i>
                                </a>
                            </td>

                            <td>
                                <p><a href="{{ url('/send-coupon-vip', [
                                    'coupon_time' => $cou->coupon_time,
                                    'coupon_condition' => $cou->coupon_condition,
                                    'coupon_number' => $cou->coupon_number,
                                    'coupon_code' => $cou->coupon_code,
                                ]) }}"
                                        class="btn btn-primary">Send Discount to VIP guests</a>
                                </p>
                                <br>
                                <p><a href="{{ url('/send-coupon', [
                                    'coupon_time' => $cou->coupon_time,
                                    'coupon_condition' => $cou->coupon_condition,
                                    'coupon_number' => $cou->coupon_number,
                                    'coupon_code' => $cou->coupon_code,
                                ]) }}"
                                        class="btn btn-success">Send Discount to regular customers</a></p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $coupon->links() !!}

    </div>
@endsection

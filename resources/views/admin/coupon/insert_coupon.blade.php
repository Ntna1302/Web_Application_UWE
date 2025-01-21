@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>Add discount code:</h4>
    </div>

    @php
    $message = Session::get('message');
    if($message){
    echo '<span class="text-alert">'.$message.'</span>';
    Session::put('message',null);
    }
    @endphp

    <div class="form-body">
        <form role="form" action="{{URL::to('/insert-coupon-code')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Discount code name</label>
                <input type="text" name="coupon_name" class="form-control" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Start date</label>
                <input type="text" name="coupon_date_start" class="form-control" id="start_coupon">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">End date</label>
                <input type="text" name="coupon_date_end" class="form-control" id="end_coupon">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Discount code</label>
                <input type="text" name="coupon_code" class="form-control" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Number of codes</label>
                <input type="text" name="coupon_time" class="form-control" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Code features</label>
                <select name="coupon_condition" class="form-control input-sm m-bot15">
                    <option value="0">----Select-----</option>
                    <option value="1">Reduce by percentage</option>
                    <option value="2">Reduce by amount</option>

                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Enter the % or discount</label>
                <input type="text" name="coupon_number" class="form-control" id="exampleInputEmail1">
            </div>


            <button type="submit" name="add_coupon" class="btn btn-info">Add code</button>
        </form>
    </div>
</div>
@endsection
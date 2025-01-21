@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>Add special fee :</h4>
    </div>

    @php
    $message = Session::get('message');
    if($message){
    echo '<span class="text-alert">'.$message.'</span>';
    Session::put('message',null);
    }
    @endphp

    <div class="form-body">
        <form>
            @csrf

            <div class="form-group">
                <label for="exampleInputPassword1">Select province and city</label>
                <select name="city" id="city" class="form-control input-sm m-bot15 choose city">

                    <option value="">--Select province and city--</option>
                    @foreach($city as $key => $ci)
                    <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Select Disctric</label>
                <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                    <option value="">--Select Disctric--</option>

                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Select commune and ward</label>
                <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                    <option value="">--Select commune and ward--</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Shipping fee</label>
                <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1"
                    placeholder="Shipping fee">
            </div>

            <button type="button" name="add_delivery" class="btn btn-info add_delivery">Add shipping fee</button>
        </form>
    </div>
    <div id="load_delivery">

    </div>
    @endsection
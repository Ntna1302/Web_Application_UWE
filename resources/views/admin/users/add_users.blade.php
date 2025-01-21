@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>Add user :</h4>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @php
    $message = Session::get('message');
    if($message){
    echo '<span class="text-alert">'.$message.'</span>';
    Session::put('message',null);
    }
    @endphp

    <div class="form-body">
        <form role="form" action="{{URL::to('store-users')}}" method="post">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="text" name="admin_email" class="form-control" id="exampleInputEmail1" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Full name</label>
                <input type="text" name="admin_name" class="form-control" id="exampleInputEmail1"
                    placeholder="Fill your full name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Phone</label>
                <input type="text" name="admin_phone" class="form-control" id="exampleInputEmail1"
                    placeholder="Phone number ...">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                <input type="text" name="admin_password" class="form-control" id="exampleInputEmail1"
                    placeholder="Password...">
            </div>

            <button type="submit" name="add_category_product" class="btn btn-info">Add users</button>
        </form>
    </div>
</div>
@endsection
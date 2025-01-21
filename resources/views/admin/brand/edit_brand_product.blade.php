@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>Update product brand:</h4>
    </div>

    @php
    $message = Session::get('message');
    if($message){
    echo '<span class="text-alert">'.$message.'</span>';
    Session::put('message',null);
    }
    @endphp

    <div class="form-body">
        @foreach($edit_brand_product as $key => $edit_value)
        <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleInputEmail1">Brand name: </label>
                <input type="text" value="{{$edit_value->brand_name}}" onkeyup="ChangeToSlug();"
                    name="brand_product_name" class="form-control" id="slug">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Slug</label>
                <input type="text" value="{{$edit_value->brand_slug}}" name="brand_product_slug" class="form-control"
                    id="convert_slug">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Brand description</label>
                <textarea style="resize: none" rows="8" class="form-control" name="brand_product_desc"
                    id="exampleInputPassword1">{{$edit_value->brand_desc}}</textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Show</label>
                <select name="brand_product_status" class="form-control input-sm m-bot15">
                    <option value="0">Hide</option>
                    <option value="1">Show</option>

                </select>
            </div>
            <button type="submit" name="update_brand_product" class="btn btn-info">Brand update</button>
        </form>
        @endforeach

    </div>
</div>
@endsection
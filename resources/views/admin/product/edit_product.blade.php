@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>Product updates:</h4>
    </div>

    @php
    $message = Session::get('message');
    if($message){
    echo '<span class="text-alert">'.$message.'</span>';
    Session::put('message',null);
    }
    @endphp

    <div class="form-body">
        @foreach($edit_product as $key => $pro)
        <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="post"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleInputEmail1">Product name</label>
                <input type="text" name="product_name" class="form-control" onkeyup="ChangeToSlug();" id="slug"
                    value="{{$pro->product_name}}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Quantity</label>
                <input type="text" data-validation="number" data-validation-error-msg="Please fill in quantity"
                    name="product_quantity" class="form-control" value="{{$pro->product_quantity}}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Slug</label>
                <input type="text" name="product_slug" id="convert_slug" class="form-control" id="exampleInputEmail1"
                    value="{{$pro->product_slug}}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Price</label>
                <input type="text" value="{{$pro->product_price}}" name="product_price"
                    class="form-control price_format" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Original Price</label>
                <input type="text" value="{{$pro->price_cost}}" name="price_cost" class="form-control price_format"
                    id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Product images</label>
                <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                <img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" height="100" width="100">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Product descriptions</label>
                <textarea style="resize: none" rows="8" class="form-control" name="product_desc"
                    id="ckeditor2">{{$pro->product_desc}}</textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Product contents</label>
                <textarea style="resize: none" rows="8" class="form-control" name="product_content"
                    id="ckeditor3">{{$pro->product_content}}</textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Product category</label>
                <select name="product_cate" class="form-control input-sm m-bot15">
                    @foreach($cate_product as $key => $cate)
                    @if($cate->category_id==$pro->category_id)
                    <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                    @else
                    <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                    @endif
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Brand</label>
                <select name="product_brand" class="form-control input-sm m-bot15">
                    @foreach($brand_product as $key => $brand)
                    @if($cate->category_id==$pro->category_id)
                    <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                    @else
                    <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                    @endif
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Show</label>
                <select name="product_status" class="form-control input-sm m-bot15">
                    @if($pro->product_status == 1){
                    <option selected value="1">Show</option>
                    <option value="0">Hide</option>

                    }
                    @else{
                    <option selected value="0">Hide</option>
                    <option value="1">Show</option>
                    }
                    @endif

                </select>
            </div>

            <button type="submit" name="add_product" class="btn btn-info">Update Product</button>
        </form>
        @endforeach

    </div>
</div>
@endsection
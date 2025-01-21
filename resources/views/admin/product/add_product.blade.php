@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>Add Product :</h4>
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
        <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleInputEmail1">Product Name</label>
                <input type="text" data-validation="length" data-validation-length="min10"
                    data-validation-error-msg="Please enter at least 10 characters" name="product_name" class="form-control "
                    id="slug" placeholder="Category name" onkeyup="ChangeToSlug();">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Quantity</label>
                <input type="text" data-validation="number" data-validation-error-msg="Please fill in quantity"
                    name="product_quantity" class="form-control" id="exampleInputEmail1" placeholder="Fill in quantity">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Slug</label>
                <input type="text" name="product_slug" class="form-control " id="convert_slug" placeholder="slug">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Price</label>
                <input type="text" data-validation="length" data-validation-length="min5"
                    data-validation-error-msg="Please fill in the amount" name="product_price" class="form-control " id=""
                    placeholder="Fill in the selling price">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail1">Original price</label>
                <input type="text" data-validation="length" data-validation-length="min5"
                    data-validation-error-msg="Please fill in the amount" name="price_cost" class="form-control " id=""
                    placeholder="Original price">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Product images</label>
                <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Product description</label>
                <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="ckeditor1"
                    placeholder="Product description"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Product content</label>
                <textarea style="resize: none" rows="8" class="form-control" name="product_content" id="id4"
                    placeholder="Product content"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Product category</label>
                <select name="product_cate" class="form-control input-sm m-bot15">
                    @foreach($cate_product as $key => $cate)
                    @if($cate->category_parent==1)
                    <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                    @foreach($cate_product as $key => $cate_sub)
                    @if($cate_sub->category_parent !=0 && $cate_sub->category_parent ==$cate->category_id)
                    <option style="color:red;" value="{{$cate_sub->category_id}}">---{{$cate_sub->category_name}}
                    </option>
                    @endif
                    @endforeach
                    @endif
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Brand</label>
                <select name="product_brand" class="form-control input-sm m-bot15">
                    @foreach($brand_product as $key => $brand)
                    <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Show</label>
                <select name="product_status" class="form-control input-sm m-bot15">
                    <option value="1">Show</option>
                    <option value="0">Hide</option>

                </select>
            </div>

            <button type="submit" name="add_product" class="btn btn-default">Add Product</button>
        </form>
    </div>
</div>
@endsection
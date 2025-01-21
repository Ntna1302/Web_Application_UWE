@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>Add product categories:</h4>
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
        <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleInputEmail1">Category name</label>
                <input type="text" class="form-control" onkeyup="ChangeToSlug();" name="category_name" id="slug"
                    placeholder="Enter category name" />
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Slug</label>
                <input type="text" name="slug_category_product" class="form-control" id="convert_slug"
                    placeholder="Enter category name">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Category description</label>
                <textarea style="resize: none" rows="8" class="form-control" name="category_product_desc"
                    id="exampleInputPassword1" placeholder="Category description"></textarea>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Category keywords</label>
                <textarea style="resize: none" rows="8" class="form-control" name="category_product_keywords"
                    id="exampleInputPassword1" placeholder="Category keywords"></textarea>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Belongs to the category</label>
                <select name="category_parent" class="form-control input-sm m-bot15">
                    <option value="1">---Parent category---</option>
                    @foreach($category as $key => $val)

                    <option value="{{$val->category_id}}">{{$val->category_name}}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Show</label>
                <select name="category_product_status" class="form-control input-sm m-bot15">
                    <option value="1">Show</option>
                    <option value="0">Hide</option>

                </select>
            </div>

            <button type="submit" name="add_category_product" class="btn btn-default">Add categories</button>
        </form>
    </div>
</div>
@endsection
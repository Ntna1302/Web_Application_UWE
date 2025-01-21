@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>Add product brand: </h4>
    </div>
    {{-- Error nếu chưa điền đủ validation --}}
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
        <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleInputEmail1">Brand name</label>
                <input type="text" name="brand_name" class="form-control" onkeyup="ChangeToSlug();" id="slug"
                    placeholder="Category Name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Slug</label>
                <input type="text" name="brand_slug" class="form-control" id="convert_slug" placeholder="Slug">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Brand description</label>
                <textarea style="resize: none" rows="8" class="form-control" name="brand_product_desc"
                    id="exampleInputPassword1" placeholder="Brand description"></textarea>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Show</label>
                <select name="brand_product_status" class="form-control input-sm m-bot15">
                    <option value="1">Show</option>
                    <option value="0">Hide</option>

                </select>
            </div>


            <button type="submit" name="add_category_product" class="btn btn-default">Add brand</button>
        </form>
    </div>
</div>
@endsection
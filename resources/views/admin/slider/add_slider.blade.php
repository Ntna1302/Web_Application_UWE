@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>Add Slider:</h4>
    </div>

    @php
    $message = Session::get('message');
    if($message){
    echo '<span class="text-alert">'.$message.'</span>';
    Session::put('message',null);
    }
    @endphp

    <div class="form-body">
        <form role="form" action="{{URL::to('/insert-slider')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleInputEmail1">Slide name</label>
                <input type="text" name="slider_name" class="form-control" id="exampleInputEmail1"
                    placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Image</label>
                <input type="file" name="slider_image" class="form-control" id="exampleInputEmail1" placeholder="Slide">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Slider description</label>
                <textarea style="resize: none" rows="8" class="form-control" name="slider_desc"
                    id="exampleInputPassword1" placeholder="Slider description"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Show</label>
                <select name="slider_status" class="form-control input-sm m-bot15">
                    <option value="0">Show</option>
                    <option value="1">Hide</option>

                </select>
            </div>

            <button type="submit" name="add_slider" class="btn btn-info">Add slider</button>
        </form>
    </div>
</div>
@endsection
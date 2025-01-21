@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
  <div class="form-title">
    <h4>Add website information:</h4>
  </div>

  @php
  $message = Session::get('message');
  if($message){
  echo '<span class="text-alert">'.$message.'</span>';
  Session::put('message',null);
  }
  @endphp

  <div class="form-body">
    @foreach($contact as $key => $cont)
    <form role="form" action="{{URL::to('/update-info/'.$cont->info_id)}}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}


      <div class="form-group">
        <label for="exampleInputPassword1">Contact information</label>
        <textarea style="resize: none" data-validation="length" data-validation-length="min10"
          data-validation-error-msg="Please fill in at least 10 characters" rows="8" class="form-control" name="info_contact"
          id="ckeditor" placeholder="Brand description">{{$cont->info_contact}}</textarea>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Map</label>
        <textarea style="resize: none" data-validation="length" data-validation-length="min10"
          data-validation-error-msg="Please fill in at least 10 characters" rows="8" class="form-control" name="info_map"
          id="exampleInputPassword1" placeholder="Brand description">{{$cont->info_map}}</textarea>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Fanpage</label>
        <textarea style="resize: none" data-validation="length" data-validation-length="min10"
          data-validation-error-msg="Please fill in at least 10 characters" rows="8" class="form-control" name="info_fanpage"
          id="exampleInputPassword1" placeholder="Brand description">{{$cont->info_fanpage}}</textarea>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Logo image</label>
        <input type="file" name="info_image" class="form-control" id="exampleInputEmail1">
        <img src="{{URL::to('public/uploads/contact/'.$cont->info_logo)}}" height="100" width="100">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Slogan Logo</label>
        <input type="text" name="slogan_logo" class="form-control" id="exampleInputEmail1"
          value="{{$cont->slogan_logo}}">

      </div>


      <button type="submit" name="add_info" class="btn btn-default">Update information</button>
    </form>
    @endforeach

  </div>
</div>
@endsection
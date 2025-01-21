@extends('admin_layout')
@section('admin_content')
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
  <div class="form-title">
    <h4>Add photo gallery:</h4>
  </div>

  @php
  $message = Session::get('message');
  if($message){
  echo '<span class="text-alert">'.$message.'</span>';
  Session::put('message',null);
  }
  @endphp
  <form action="{{url('/insert-gallery/'.$pro_id)}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <input type="file" id="file" class="form-control" name="file[]" accept="image/*" multiple>
        <span id="error_gallery"></span>


      </div>
      <div class="col-md-3">
        <input type="submit" name="upload" value="Upload photos" class="btn btn-success">
      </div>
    </div>
  </form>
  <div class="form-body">
    <input type="hidden" value="{{$pro_id}}" name="pro_id" class="pro_id">
    <form>
      @csrf
      <div id="gallery_load">

      </div>
    </form>
  </div>
</div>
@endsection
@extends('admin_layout')
@section('admin_content')
<div class="tables">
  <h2 class="title1">List product brands</h2>


  <div class="bs-example widget-shadow" data-example-id="hoverable-table">
    <h4>
      @php
      $message = Session::get('message');
      if($message){
      echo '<span class="text-alert">'.$message.'</span>';
      Session::put('message',null);
      }
      @endphp
    </h4>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Brand name</th>
          <th>Brand Slug</th>
          <th>Display</th>
        </tr>
      </thead>
      <tbody>

        @foreach($all_brand_product as $key => $brand_pro)
        <tr>
          <th scope="row">{{1 + $key++}}</th>
          <td>{{ $brand_pro->brand_name }}</td>
          <td>{{ $brand_pro->brand_slug }}</td>
          <td><span class="text-ellipsis">
              <?php
             if($brand_pro->brand_status==1){
              ?>
              <a href="{{URL::to('/unactive-brand-product/'.$brand_pro->brand_id)}}"><i
                  class="fa-solid fa-toggle-on"></i></a>
              <?php
               }else{
              ?>

              <a href="{{URL::to('/active-brand-product/'.$brand_pro->brand_id)}}"><i
                  class="fa-solid fa-toggle-off"></i></a>
              <?php
             }
            ?>
            </span></td>

          <td>
            <a href="{{URL::to('/edit-brand-product/'.$brand_pro->brand_id)}}" class="active styling-edit"
              ui-toggle-class="">
              <i class="fa fa-pencil-square-o text-success text-active"></i></a>
            <a onclick="return confirm('Are you sure you want to delete this brand?')"
              href="{{URL::to('/delete-brand-product/'.$brand_pro->brand_id)}}" class="active styling-edit"
              ui-toggle-class="">
              <i class="fa fa-times text-danger text"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {!!$all_brand_product->links()!!}


</div>
@endsection
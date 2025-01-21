@extends('admin_layout')
@section('admin_content')
<div class="tables">
  <h2 class="title1">List product categories</h2>


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
          <th>Category name</th>
          <th>In category</th>
          <th>Slug</th>
          <th>Display</th>

        </tr>
      </thead>
      <tbody>
        @foreach($all_category_product as $key => $cate_pro)
        <tr>
          <th scope="row">{{1 + $key++}}</th>
          <td>{{ $cate_pro->category_name }}</td>

          <td>
            @if($cate_pro->category_parent == 1)
            <span style="color: red"> -----------
            </span>

            @else
            @foreach($category_product as $key => $cate_sub_pro)
            @if($cate_sub_pro->category_id == $cate_pro->category_parent)
            <span style="color: green">{{$cate_sub_pro->category_name}}
            </span>
            @endif
            @endforeach
            @endif

          <td>{{ $cate_pro->slug_category_product }}</td>
          <td><span class="text-ellipsis">
              <?php
               if($cate_pro->category_status==1){
                ?>
              <a href="{{URL::to('/unactive-category-product/'.$cate_pro->category_id)}}"><span
                  class="fa-solid fa-toggle-on"></span></a>
              <?php
                 }else{
                ?>
              <a href="{{URL::to('/active-category-product/'.$cate_pro->category_id)}}"><span
                  class="fa-solid fa-toggle-off"></span></a>
              <?php
               }
              ?>
            </span></td>

          <td>
            <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" class="active styling-edit"
              ui-toggle-class="">
              <i class="fa fa-pencil-square-o text-success text-active"></i></a>
            <a onclick="return confirm('Are you sure you want to delete this category?')"
              href="{{URL::to('/delete-category-product/'.$cate_pro->category_id)}}" class="active styling-edit"
              ui-toggle-class="">
              <i class="fa fa-times text-danger text"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {!!$all_category_product->links()!!}


</div>
@endsection
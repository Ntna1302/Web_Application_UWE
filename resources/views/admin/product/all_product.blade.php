@extends('admin_layout')
@section('admin_content')
<div class="tables">
  <h2 class="title1">List products</h2>


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
    <table class="table table-hover" id="myTable">
      <thead>
        <tr>
          <th>#</th>
          <th>Product name</th>
          <th>Photo gallery</th>
          <th>Quantity</th>
          <th>Slug</th>
          <th>Selling price</th>
          <th>Original price</th>
          <th>Product image</th>
          <th>Category</th>
          <th>Brand</th>
          <th>Display</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody>
        @foreach($all_product as $key => $pro)
        <tr>
          <th scope="row">{{1 + $key++}}</th>
          <td>{{ $pro->product_name }}</td>
          <td><a href="{{url('add-gallery/'.$pro->product_id)}}">Add photo gallery</a></td>
          <td>{{ $pro->product_quantity }}</td>
          <td>{{ $pro->product_slug }}</td>
          <td>{{ number_format($pro->product_price,0,',','.') }}đ</td>
          <td>{{ number_format($pro->price_cost,0,',','.') }}đ</td>
          <td><img src="public/uploads/product/{{ $pro->product_image }}" height="100" width="100"></td>
          <td>{{ $pro->category_name }}</td>
          <td>{{ $pro->brand_name }}</td>

          <td>



            <span class="text-ellipsis">

              @if($pro->product_status==1 )
              <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}"><i class="fa-solid fa-toggle-on"></i></a>
              @else

              <a href="{{URL::to('/active-product/'.$pro->product_id)}}"><i class="fa-solid fa-toggle-off"></i></a>
              @endif
            </span>


          </td>
          <td>
            <a href="{{URL::to('/edit-product/'.$pro->product_id)}}" class="active styling-edit" ui-toggle-class="">
              <i class="fa fa-pencil-square-o text-success text-active"></i></a>
            <a onclick="return confirm('Are you sure you want to delete this product?')"
              href="{{URL::to('/delete-product/'.$pro->product_id)}}" class="active styling-edit" ui-toggle-class="">
              <i class="fa fa-times text-danger text"></i>
            </a>
          </td>

        </tr>
        @endforeach

      </tbody>
    </table>
  </div>

  {{-- {!!$all_product->links()!!} --}}

</div>
@endsection
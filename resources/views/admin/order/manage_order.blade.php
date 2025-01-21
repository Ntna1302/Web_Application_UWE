@extends('admin_layout')
@section('admin_content')
<div class="tables">
  <h2 class="title1">List orders</h2>


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
          <th>Order code</th>
          <th>Order date</th>
          <th>Order status</th>
          <th>Reason for cancellation</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>

        @foreach($getorder as $key => $ord)

        <tr>
          <th scope="row">{{1 + $key++}}</th>
          <td>{{ $ord->order_code }}</td>
          <td>{{ $ord->created_at }}</td>

          <td>@if($ord->order_status==1)
            <span class="text text-success">
              New order
            </span>
            @elseif($ord->order_status==2)
            <span class="text text-primary">

              Processed - delivered
              </span>
            @else

            <span class="text text-danger">

              The order has been cancelled
            </span>
            @endif
          </td>
          <td>{{$ord->order_destroy}}</td>


          <td>
            <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class="">
              <i class="fa fa-eye text-success text-active"></i></a>

            <a onclick="return confirm('Are you sure you want to delete this order?')"
              href="{{URL::to('/delete-order/'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class="">
              <i class="fa fa-times text-danger text"></i>
            </a>

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {!!$getorder->links()!!}

</div>
@endsection
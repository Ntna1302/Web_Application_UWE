@extends('layout')
@section('content')

<section id="form">
  <!--form-->
  <div class="container">
    <div class="row">

      <div class="col-sm-3">

        <div class="signup-form">
          <!--sign up form-->
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
          {{-- Error nếu chưa điền đủ validation --}}
          <h2>Please enter your mobile phone</h2>
          <form action="{{URL::to('/add-phone')}}" method="POST">
            {{ csrf_field() }}
            <input type="text" name="customer_phone" placeholder="Phone" />
            <button type="submit" class="btn btn-default">Sign-up</button>
          </form>
        </div>
        <!--/sign up form-->
      </div>

    </div>
  </div>
</section>
<!--/form-->

@endsection
@extends('layout')
@section('content')

<section id="form">
  <!--form-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-sm-offset-1">
        @if(session()->has('message'))
        <div class="alert alert-success">
          {!! session()->get('message') !!}
        </div>
        @elseif(session()->has('error'))
        <div class="alert alert-danger">
          {!! session()->get('error') !!}
        </div>
        @endif
        <div class="login-form">
          <!--login form-->
          <h2>Enter your email to change your password</h2>

          <form action="{{URL::to('/recover-password')}}" method="POST">
            {{csrf_field()}}
            <input type="text" name="email_account" placeholder="Enter email" />



            <button type="submit" class="btn btn-default">Send</button>
          </form>
        </div>
        <!--/login form-->
      </div>

    </div>
  </div>
  </div>
</section>
<!--/form-->

@endsection
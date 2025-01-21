@extends('admin_layout')
@section('admin_content')
<div class="tables">
  <h2 class="title1">List users</h2>


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
          <th>User name</th>
          <th>Email</th>
          <th>Phone</th>
          {{-- <th>Password</th> --}}
          <th>Employee</th>
          <th>Admin</th>
          {{-- <th>User</th> --}}

        </tr>
      </thead>
      <tbody>
        @foreach($admin as $key => $user)
        <form action="{{url('/assign-roles')}}" method="POST">
          @csrf
          <tr>

            <th scope="row">{{1 + $key++}}</th>

            <td>{{ $user->admin_name }}</td>
            <td>{{ $user->admin_email }}
              <input type="hidden" name="admin_email" value="{{ $user->admin_email }}">
              <input type="hidden" name="admin_id" value="{{ $user->admin_id }}">
            </td>
            <td>{{ $user->admin_phone }}</td>
            {{-- <td>{{ $user->admin_password }}</td> --}}

            <td><input type="checkbox" name="author_role" {{$user->hasRole('author') ? 'checked' : ''}}></td>
            <td><input type="checkbox" name="admin_role" {{$user->hasRole('admin') ? 'checked' : ''}}></td>
           

            <td>



              <p> <input type="submit" value="Assign roles" class="btn btn-sm btn-info"></p>
              <p> <a style="margin:5px 0;" class="btn btn-sm btn-danger"
                  href="{{url('/delete-user-roles/'.$user->admin_id)}}">Delete
                  user</a> </p>
              <p> <a style="margin:5px 0;" class="btn btn-sm btn-success"
                  href="{{url('/impersonate/'.$user->admin_id)}}">Transfer role</a> </p>

            </td>

          </tr>
        </form>
        @endforeach
      </tbody>
    </table>
  </div>
  {!!$admin->links()!!}


</div>
@endsection
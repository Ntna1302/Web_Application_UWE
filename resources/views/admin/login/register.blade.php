<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>

<head>
  <title>Glance Design Dashboard an Admin Panel Category Flat Bootstrap Responsive Website Template | SignUp Page ::
    w3layouts</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
  <script type="application/x-javascript">
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 
  </script>

  <!-- Bootstrap Core CSS -->
  <link href="{{('public/backend/css/bootstrap.css')}}" rel='stylesheet' type='text/css' />

  <!-- Custom CSS -->
  <link href="{{('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />

  <!-- font-awesome icons CSS -->
  <link href="{{('public/backend/css/font-awesome.css')}}" rel="stylesheet">
  <!-- //font-awesome icons CSS -->

  <!-- side nav css file -->
  <link href='{{(' public/backend/css/SidebarNav.min.css')}}' media='all' rel='stylesheet' type='text/css' />
  <!-- side nav css file -->

  <!-- js-->
  <script src="{{('public/backend/js/jquery-1.11.1.min.js')}}"></script>
  <script src="{{('public/backend/js/modernizr.custom.js')}}"></script>

  <!--webfonts-->
  <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
    rel="stylesheet">
  <!--//webfonts-->

  <!-- Metis Menu -->
  <script src="{{('public/backend/js/metisMenu.min.js')}}"></script>
  <script src="{{('public/backend/js/custom.js')}}"></script>
  <link href="{{('public/backend/css/custom.css')}}" rel="stylesheet">
  <!--//Metis Menu -->

</head>

<body class="">
  <div class="main-content">




    <!-- main content start-->
    <div id="page-wrapper">
      <div class="main-page signup-page">
        <h2 class="title1">Register</h2>
        <div class="sign-up-row widget-shadow">
          <h5>Registration information:</h5>
          @php

          $message = Session::get('message');
          if($message){
          echo '<span class="text-alert">'.$message.'</span>';
          Session::put('message',null);
          }

          @endphp
          <form action="{{URL::to('/register')}}" method="post">
            {{ csrf_field() }}
            @foreach($errors->all() as $val)
            <ul>
              <li>{{$val}}</li>
            </ul>
            @endforeach
            <div class="sign-u">
              <input type="text" name="admin_name" placeholder="Full name" required="">
              <div class="clearfix"> </div>
            </div>

            <div class="sign-u">
              <input type="email" name="admin_email" placeholder="Email" required="">
              <div class="clearfix"> </div>
            </div>
            <div class="sign-u">
              <input type="text" name="admin_phone" placeholder="Phone number" required="">
              <div class="clearfix"> </div>
            </div>

            <div class="sign-u">
              <input type="password" name="admin_password" placeholder="Password" required="">
              <div class="clearfix"> </div>
            </div>

            <div class="clearfix"> </div>
            <div class="sub_home">
              <input type="submit" value="Register">
              <div class="clearfix"> </div>
            </div>
            <div class="registration">
              Already have an account.
              <a class="" href="{{url('/login-auth')}}">
                Register
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--footer-->
    <div class="footer">
      <p>&copy; <a href="https://w3layouts.com/"
          target="_blank">w3layouts</a></p>
    </div>
    <!--//footer-->
  </div>

  <!-- side nav js -->
  <script src='{{(' public />backend/js/SidebarNav.min.js')}}' type='text/javascript'></script>
  <script>
    $('.sidebar-menu').SidebarNav()
  </script>
  <!-- //side nav js -->

  <!-- Classie -->
  <!-- for toggle left push menu script -->
  <script src="{{('public/backend/js/classie.js')}}"></script>
  <script>
    var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
  </script>
  <!-- //Classie -->
  <!-- //for toggle left push menu script -->

  <!--scrolling js-->
  <script src="{{('public/backend/js/jquery.nicescroll.js')}}"></script>
  <script src="{{('public/backend/js/scripts.js')}}"></script>
  <!--//scrolling js-->

  <!-- Bootstrap Core JavaScript -->
  <script src="{{('public/backend/js/bootstrap.js')}}"> </script>

</body>

</html>
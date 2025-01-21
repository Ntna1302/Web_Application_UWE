<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>

<head>
  <title>Admin - Management Login page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
  <script type="application/x-javascript">
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 
  </script>
  <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

  <!-- Bootstrap Core CSS -->
  <link href="{{('public/backend/css/bootstrap.css')}}" rel='stylesheet' type='text/css' />

  <!-- Custom CSS -->
  <link href="{{('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />

  <!-- font-awesome icons CSS-->
  <link href="{{('public/backend/css/font-awesome.css')}}" rel="stylesheet">
  <!-- //font-awesome icons CSS-->

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
      <div class="main-page login-page ">
        <h2 class="title1">Login</h2>


        <div class="widget-shadow">
          <div class="login-body">
            @php

            $message = Session::get('message');
            if($message){
            echo '<span class="text-alert">'.$message.'</span>';
            Session::put('message',null);
            }
            @endphp
            <form action="{{URL::to('/login')}}" method="post">
              {{ csrf_field() }}


              @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif


              <input type="email" class="user" name="admin_email" placeholder="Email">
              <input type="password" name="admin_password" class="lock" placeholder="Password">
              <div class="forgot-grid">
            
                <div class="clearfix"> </div>
              </div>
              <input type="submit" name="login" value="Login">
             
            
            </form>
          
          </div>
        </div>

      </div>
    </div>
    <!--footer-->
    <div class="footer">
      <p>&copy; Management page | Admin Page</p>
    </div>
    <!--//footer-->
  </div>

  <!-- side nav js -->
  <script src='{{(' public/backend/js/SidebarNav.min.js')}}' type='text/javascript'></script>
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
  <!-- //Bootstrap Core JavaScript -->

  <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
  {!! Toastr::message() !!}
</body>

</html>
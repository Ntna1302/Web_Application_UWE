<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>

<head>
  <title>
    Admin Page | Home 
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
  <script type="application/x-javascript">
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);

                      function hideURLbar() { window.scrollTo(0, 1); }
  </script>
  <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

  <!-- Bootstrap Core CSS -->
  <link href="{{asset('public/backend/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />
  <!-- Custom CSS -->
  <link href="{{asset('public/backend/css/style.css')}}" rel="stylesheet" type="text/css" />
  <!-- font-awesome icons CSS -->
  <link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet" />
  <!-- //font-awesome icons CSS-->
  <!-- side nav css file -->
  <link href="{{asset('public/backend/css/SidebarNav.min.css')}}" media="all" rel="stylesheet" type="text/css" />
  <meta name="csrf-token" content="{{csrf_token()}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  {{--
  <link rel="stylesheet" type="text/css" href="{{asset('public/backend/css/datatable.css')}}" /> --}}
  <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <!-- //side nav css file -->
  <!-- js-->

  <script src="{{asset('public/backend/js/modernizr.custom.js')}}"></script>
  <!--webfonts-->
  <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
    rel="stylesheet" />
  <!--//webfonts-->
  <!-- chart -->
  <script src="{{asset('public/backend/js/Chart.js')}}"></script>
  <!-- //chart -->
  <!-- Metis Menu -->
  <script src="{{asset('public/backend/js/metisMenu.min.js')}}"></script>
  <script src="{{asset('public/backend/js/custom.js')}}"></script>
  <link href="{{asset('public/backend/css/custom.css')}}" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <!--//Metis Menu -->
  <style>
    #chartdiv {
      width: 100%;
      height: 295px;
    }
  </style>
  <!--pie-chart -->
  <!-- index page sales reviews visitors pie chart -->
  <script src="{{asset('public/backend/js/pie-chart.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function () {
        $('#demo-pie-1').pieChart({
          barColor: '#2dde98',
          trackColor: '#eee',
          lineCap: 'round',
          lineWidth: 8,
          onStep: function (from, to, percent) {
            $(this.element)
              .find('.pie-value')
              .text(Math.round(percent) + '%');
          },
        });

        $('#demo-pie-2').pieChart({
          barColor: '#8e43e7',
          trackColor: '#eee',
          lineCap: 'butt',
          lineWidth: 8,
          onStep: function (from, to, percent) {
            $(this.element)
              .find('.pie-value')
              .text(Math.round(percent) + '%');
          },
        });

        $('#demo-pie-3').pieChart({
          barColor: '#ffc168',
          trackColor: '#eee',
          lineCap: 'square',
          lineWidth: 8,
          onStep: function (from, to, percent) {
            $(this.element)
              .find('.pie-value')
              .text(Math.round(percent) + '%');
          },
        });
      });
  </script>
  <!-- //pie-chart -->
  <!-- index page sales reviews visitors pie chart -->
  <!-- requried-jsfiles-for owl -->
  <link href="{{asset('public/backend/css/owl.carousel.css')}}" rel="stylesheet" />
  <script src="{{asset('public/backend/js/owl.carousel.js')}}"></script>
  <script>
    $(document).ready(function () {
        $('#owl-demo').owlCarousel({
          items: 3,
          lazyLoad: true,
          autoPlay: true,
          pagination: true,
          nav: true,
        });
      });
  </script>
  <!-- //requried-jsfiles-for owl -->
</head>

<body class="cbp-spmenu-push">
  <div class="main-content">
    <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
      <!--left-fixed -navigation-->
      <aside class="sidebar-left">
        <nav class="navbar navbar-inverse">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse"
              aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <h1>
              <a class="navbar-brand" href="{{url('/dashboard')}}"><span class="fa fa-area-chart"></span> Laptop<span
                  class="dashboard_text">Admin Page</span></a>
            </h1>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="sidebar-menu">
              <li class="header">MAIN NAVIGATION</li>
              <li class="treeview">
                <a href="{{url('/dashboard')}}">
                  <i class="fa fa-dashboard"></i> <span>Overview</span>
                </a>
              </li>

              <li class="treeview ">
                <a href="{{URL::to('/manage-order')}}">
                  <i class="fas fa-shopping-cart"></i>
                  <span>Order management</span>
                </a>

              </li>
              <li class="treeview ">
                <a href="#">
                  <i class="fas fa-gift"></i>
                  <span>Discount code</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{{URL::to('/insert-coupon')}}"><i class="fa fa-angle-right"></i> Manage discount codes</a>
                  </li>
                  <li>
                    <a href="{{URL::to('/list-coupon')}}"><i class="fa fa-angle-right"></i> List discount codes</a>
                  </li>
                </ul>
              </li>
              <li class="treeview ">
                <a href="{{URL::to('/delivery')}}">
                  <i class="fas fa-shipping-fast"></i>
                  <span>Transportation management</span>

                </a>

              </li>
              <li class="header">Manage guest pages</li>
              <li class="treeview">
                <a href="{{url('/information')}}">
                  <i class="fas fa-thumbtack"></i> <span>Website information</span>
                </a>
              </li>
              <li class="treeview ">
                <a href="#">
                  <i class="fa fa-archive"></i>
                  <span>Product brand</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{{URL::to('/add-brand-product')}}"><i class="fa fa-angle-right"></i> Add brand
                      product</a>
                  </li>
                  <li>
                    <a href="{{URL::to('/all-brand-product')}}"><i class="fa fa-angle-right"></i> List brands
                      product</a>
                  </li>
                </ul>
              </li>
              <li class="treeview ">
                <a href="#">
                  <i class="fa fa-window-restore"></i>
                  <span>Product category</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{{URL::to('/add-category-product')}}"><i class="fa fa-angle-right"></i> Add categories
                      product</a>
                  </li>
                  <li>
                    <a href="{{URL::to('/all-category-product')}}"><i class="fa fa-angle-right"></i>List categories
                      product</a>
                  </li>
                </ul>
              </li>
              <li class="treeview ">
                <a href="#">
                  <i class="fas fa-boxes"></i>
                  <span>Product</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{{URL::to('/add-product')}}"><i class="fa fa-angle-right"></i> Add products</a>
                  </li>
                  <li>
                    <a href="{{URL::to('/all-product')}}"><i class="fa fa-angle-right"></i> List products
                      product</a>
                  </li>
                </ul>
              </li>
              <li class="treeview ">
                <a href="#">
                  <i class="fas fa-images"></i>
                  <span>Slider</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{{URL::to('/manage-slider')}}"><i class="fa fa-angle-right"></i> List
                      slider</a>
                  </li>
                  <li>
                    <a href="{{URL::to('/add-slider')}}"><i class="fa fa-angle-right"></i> Add slider</a>
                  </li>
                </ul>
              </li>




              <li class="header">LABELS</li>

              @impersonate
              <li class="treeview ">
                <a href="{{URL::to('/impersonate-destroy')}}">
                  <i class="fa fa-laptop"></i>
                  <span>Stop transferring role</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
              </li>
              @endimpersonate

              {{-- @hasrole(['admin','author']) --}}
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-address-card"></i>
                  <span>Users</span>

                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{{URL::to('/add-users')}}"><i class="fa fa-angle-right"></i> Add user</a>
                  </li>
                  <li>
                    <a href="{{URL::to('/users')}}"><i class="fa fa-angle-right"></i> List user</a>
                  </li>
                </ul>
              </li>
              {{-- @endhasrole --}}

              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
        </nav>
      </aside>
    </div>
    <!--left-fixed -navigation-->
    <!-- header-starts -->
    <div class="sticky-header header-section">
      <div class="header-left">
        <!--toggle button start-->
        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
        <!--toggle button end-->


      </div>
      <div class="header-right">
        <!--search-box-->
        {{-- <div class="search-box">
          <form class="input">
            <input class="sb-search-input input__field--madoka" placeholder="Search..." type="search" id="input-31" />
            <label class="input__label" for="input-31">
              <svg class="graphic" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
                <path d="m0,0l404,0l0,77l-404,0l0,-77z" />
              </svg>
            </label>
          </form>
        </div> --}}
        <!--//end-search-box-->
        <div class="profile_details">
          <ul>
            <li class="dropdown profile_details_drop">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <div class="profile_img">
                  <span class="prfil-img"><img src="{{asset('public/backend/images/6.jpg')}}" alt="" />
                  </span>
                  <div class="user-name">
                    <p>
                      <?php
                      if(Session::get('login_normal')){
                        $name = Session::get('admin_name');

                      }else{
                        $name = Auth::user()->admin_name;
                      }
                      if($name){
                        echo $name;
                        
                      }
                      ?>
                    </p>
                    @hasrole(['admin'])
                    <span>
                      Admin</span>
                    @endhasrole
                    @hasrole(['author'])
                    <span>
                      Author</span>
                    @endhasrole
                    @hasrole(['user'])
                    <span>
                      User</span>
                    @endhasrole
                  </div>
                  <i class="fa fa-angle-down lnr"></i>
                  <i class="fa fa-angle-up lnr"></i>
                  <div class="clearfix"></div>
                </div>
              </a>
              <ul class="dropdown-menu drp-mnu">
                <li>
                  <a href="#"><i class="fa fa-cog"></i> Settings</a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-user"></i> My Account</a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-suitcase"></i> Profile</a>
                </li>
                <li>
                  <a href="{{URL::to('/logout-auth')}}"><i class="fa fa-sign-out"></i>Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
    </div>
    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
      <div class="main-page">




        <!-- for amcharts js -->
        <script src="{{asset('public/backend/js/amcharts.js')}}"></script>
        <script src="{{asset('public/backend/js/serial.js')}}"></script>
        <script src="{{asset('public/backend/js/export.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('public/backend/css/export.css')}}" type="text/css" media="all" />
        <script src="{{asset('public/backend/js/light.js')}}"></script>
        <!-- for amcharts js -->
        <script src="{{asset('public/backend/js/index1.js')}}"></script>

        @yield('admin_content')
      </div>
    </div>
    <!--footer-->
    <div class="footer">
      <p>
        &copy; 2022 Dashboard
      </p>
    </div>
    <!--//footer-->
  </div>
  <!-- new added graphs chart js-->
  <script src="{{asset('public/backend/js/Chart.bundle.js')}}"></script>
  <script src="{{asset('public/backend/js/utils.js')}}"></script>

  <!-- new added graphs chart js-->
  <!-- Classie -->
  <!-- for toggle left push menu script -->
  <script src="{{asset('public/backend/js/classie.js')}}"></script>
  <script>
    var menuLeft = document.getElementById('cbp-spmenu-s1'),
        showLeftPush = document.getElementById('showLeftPush'),
        body = document.body;

      showLeftPush.onclick = function () {
        classie.toggle(this, 'active');
        classie.toggle(body, 'cbp-spmenu-push-toright');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        disableOther('showLeftPush');
      };

      function disableOther(button) {
        if (button !== 'showLeftPush') {
          classie.toggle(showLeftPush, 'disabled');
        }
      }
  </script>
  <!-- //Classie -->
  <!-- //for toggle left push menu script -->
  <!--scrolling js-->
  <script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
  <script src="{{asset('public/backend/js/scripts.js')}}"></script>
  <!--//scrolling js-->
  <!-- side nav js -->
  <script src="{{asset('public/backend/js/SidebarNav.min.js')}}" type="text/javascript"></script>
  <script>
    $('.sidebar-menu').SidebarNav();
  </script>
  <!-- //side nav js -->
  <!-- for index page weekly sales java script -->
  <script src="{{asset('public/backend/js/SimpleChart.js')}}"></script>
  <script src="{{asset('public/backend/js/simple.money.format.js')}}"></script>


  <!-- //for index page weekly sales java script -->
  <!-- Bootstrap Core JavaScript -->
  <script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
  <!-- //Bootstrap Core JavaScript -->


  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  {{-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}

  <script type="text/javascript" src="{{asset('public/backend/js/datatables.js')}}"> </script>


  <script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>


  <script type="text/javascript">
    $('.price_format').simpleMoneyFormat();
  </script>


  <script type="text/javascript">
    $(function() {
        $( "#start_coupon" ).datepicker({
          prevText:"Last month",
          nextText:"Next month",
          dateFormat:"dd/mm/yy",
          monthNames:["January", "February", "March", "April", "May", "June", "July", "August", "September", "Month 10", "November", "December"],
          dayNamesMin:["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
          duration:"slow"
        });
        $( "#end_coupon" ).datepicker({
          prevText:"Last month",
          nextText:"Next month",
          dateFormat:"dd/mm/yy",
          monthNames:["January", "February", "March", "April", "May", "June", "July", "August", "September", "Month 10", "November", "December"],
          dayNamesMin:["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
          duration:"slow"
        });
      } );
  </script>
  <script>
    // Replace the <textarea id="editor1"> with a CKEditor instance, using default configuration.
  
    CKEDITOR.replace('ckeditor');
    CKEDITOR.replace('ckeditor1');
    CKEDITOR.replace('ckeditor2');
    CKEDITOR.replace('ckeditor3');
    CKEDITOR.replace('id4');
  </script>
  <script type="text/javascript">
    $(document).ready( function () {
  $('#myTable').DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/2.2.1/i18n/en-GB.json',
    },
  });
} );
  </script>
  <script type="text/javascript">
    function ChangeToSlug()
    {
        var slug;
     
        slug = document.getElementById("slug").value;
        slug = slug.toLowerCase();
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            slug = slug.replace(/ /gi, "-");

            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
        document.getElementById('convert_slug').value = slug;
    }
    
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      load_gallery();

      function load_gallery(){
        var pro_id = $('.pro_id').val();
        var _token = $('input[name="_token"]').val();
        // alert(pro_id);
        $.ajax({
            url:"{{url('/select-gallery')}}",
            method:"POST",
            data:{pro_id:pro_id,_token:_token},
            success:function(data){
                $('#gallery_load').html(data);
            }
        });
        }

        $('#file').change(function(){
          var error = '';
          var files = $('#file')[0].files;
          if(files.length>5){
            error += '<p>You can only select a maximum of 5 photos</p>';
          } else if(files.length == '') {
            error += '<p>You cannot leave images blank</p>';
          } else if(files.size >2000000){

            error += '<p>Image files cannot exceed 2MB</p>';
          }

          if(error == ''){

          }
          else{
            $('#file').val('');
            $('#error_gallery').html('<span class="text-danger">'+error+'</span>');
            return false;
          }
        });


        $(document).on('blur','.edit_gal_name' ,function(){
            var gal_id = $(this).data('gal_id');
            var gal_text = $(this).text();
            var _token = $('input[name="_token"]').val();

            $.ajax({
            url:"{{url('/update-gallery-name')}}",
            method:"POST",
            data:{gal_id:gal_id,gal_text:gal_text,_token:_token},
            success:function(data){
                load_gallery();
                $('#error_gallery').html('<span class="text-danger">Update image name successfully</span>');
            }
        });
        });

        $(document).on('click','.delete-gallery' ,function(){
            var gal_id = $(this).data('gal_id');
            var _token = $('input[name="_token"]').val();
          if(confirm('Do you want to delete this image?'))
          {
            $.ajax({
            url:"{{url('/delete-gallery')}}",
            method:"POST",
            data:{gal_id:gal_id,_token:_token},
            success:function(data){
                load_gallery();
                $('#error_gallery').html('<span class="text-danger">Successfully deleted product images</span>');
            }
        });
          };
        });
    
    
        $(document).on('change','.file_image' ,function(){
            var gal_id = $(this).data('gal_id');
            var image= document.getElementById('file-'+gal_id).files[0];
           
            var form_data = new FormData();

            form_data.append("file",document.getElementById('file-'+gal_id).files[0]);
            form_data.append("gal_id",gal_id);
        
            $.ajax({
            url:"{{url('/update-gallery')}}",
            method:"POST",
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
            data:form_data,
            contentType:false,
            cache:false,
            processData:false,
            success:function(data){
                load_gallery();
                $('#error_gallery').html('<span class="text-danger">Image updated successfully</span>');
            }
        });
      
      });


        
 });
  </script>
  <script type="text/javascript">
    $(document).ready(function(){

      
      var colorDanger = "#FF1744";
            Morris.Donut({
            element: 'donut',
            resize: true,
            colors: [
                '#E0F7FA',
                '#B2EBF2',
                '#80DEEA',
                '#4DD0E1',
                '#26C6DA',
                '#00BCD4',
                '#00ACC1',
                '#0097A7',
                '#00838F',
                '#006064'
            ],
            //labelColor:"#cccccc", // text color
            //backgroundColor: '#333333', // border color
            data: [
                {label:"Product", value:<?php echo $product ?>},
                //value test
                {label:"Article", value:5},
                {label:"Video", value:6},
                //value test 
            
                {label:"Order", value:<?php echo $order ?>},
                {label:"Customer", value:<?php echo $customer ?>}
            ]
            });



      chart60daysorder();

      var chart = new Morris.Bar({
            // ID of the element in which to draw the chart.
            element: 'chart',
            //option 
            lineColors:['#819C79','#fc8710','#ff6541','#a4add3','#766856'],
            parseTime:false,
            hideHover:'auto',
            xkey: 'period',
            ykeys: ['order','sales','profit','quantity'],
            labels: ['orders','sales','profit','quantity']
        });

        function chart60daysorder(){
            var _token =$('input[name="_token"]').val();

            $.ajax({
                url: "{{url('/days-order')}}",
                method:'post',
                dataType:"JSON",
                data:{_token:_token},

                success:function(data){
                    chart.setData(data)
                }
            });
        }   

    $('.dashboard-filter').change(function(){
            var dashboard_value = $(this).val();
            var _token =$('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/dashboard-filter')}}",
                method:"POST",
                dataType:"JSON",
                data:{dashboard_value:dashboard_value,_token:_token},

                success:function(data){
                    chart.setData(data);
                    // chart.setData(JSON.parse(data));

                }
            });
        });

        
        $('#btn-dashboard-filter').click(function(){
        var _token =$('input[name="_token"]').val();

        var from_date= $('#datepicker').val();
        var to_date= $('#datepicker2').val();
      
        $.ajax({
            url:"{{url('filter-by-date')}}",
            method:"post",
            dateType:"JSON",
            data:{from_date:from_date,to_date:to_date,_token:_token},
            success:function(data){
                chart.setData(JSON.parse(data));
            }
        });
    });
    
  });

  </script>



  <script type="text/javascript">
    $(function() {
        $( "#datepicker" ).datepicker({
          prevText:"Last month",
          nextText:"Next month",
          dateFormat:"yy-mm-dd",
          monthNames:["January", "February", "March", "April", "May", "June", "July", "August", "September", "Month 10", "November", "December"],
          dayNamesMin:["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
          duration:"slow"
        });
        $( "#datepicker2" ).datepicker({
          prevText:"Last month",
          nextText:"Next month",
          dateFormat:"yy-mm-dd",
          monthNames:["January", "February", "March", "April", "May", "June", "July", "August", "September", "Month 10", "November", "December"],
          dayNamesMin:["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
          duration:"slow"
        });
      } );
  </script>



  <script type="text/javascript">
    $('.update_quantity_order').click(function(){
        var order_product_id = $(this).data('product_id');
        var order_qty = $('.order_qty_'+order_product_id).val();
        var order_code = $('.order_code').val();
        var _token = $('input[name="_token"]').val();
        // alert(order_product_id);
        // alert(order_qty);
        // alert(order_code);
        $.ajax({
                url : '{{url('/update-qty')}}',

                method: 'POST',

                data:{_token:_token, order_product_id:order_product_id ,order_qty:order_qty ,order_code:order_code},
                // dataType:"JSON",
                success:function(data){

                    alert('Updated quantity successfully');
                 
                   location.reload();
                    
              
                    

                }
        });

    });
  </script>
  <script type="text/javascript">
    $('.order_details').change(function(){
        var order_status = $(this).val();
        var order_id = $(this).children(":selected").attr("id");
        var _token = $('input[name="_token"]').val();

        quantity = [];
        $("input[name='product_sales_quantity']").each(function(){
            quantity.push($(this).val());
        });
        order_product_id = [];
        $("input[name='order_product_id']").each(function(){
            order_product_id.push($(this).val());
        });
        j = 0;
        for(i=0;i<order_product_id.length;i++){
            var order_qty = $('.order_qty_' + order_product_id[i]).val();
            var order_qty_storage = $('.order_qty_storage_' + order_product_id[i]).val();

            if(parseInt(order_qty)>parseInt(order_qty_storage)){
                j = j + 1;
                if(j==1){
                    alert('Quantity in stock is not enough');
                }
                $('.color_qty_'+order_product_id[i]).css('background','#000');
            }
        }
        if(j==0){
          
                $.ajax({
                        url : '{{url('/update-order-qty')}}',
                            method: 'POST',
                            data:{_token:_token, order_status:order_status ,order_id:order_id ,quantity:quantity, order_product_id:order_product_id},
                            success:function(data){
                                alert('Change order status successfully');
                                location.reload();
                            }
                });
            
        }

    });
 
  </script>
  // <script src="{{asset('public/backend/js/jquery.form-validator.min.js')}}">
    // 
  // 
  // 
  </script>
  // <script type="text/javascript">
    //   $.validate({
           
  //   });
  // 
  // 
  // 
  </script>
  <script type="text/javascript">
    $(document).ready(function(){

        fetch_delivery();

        function fetch_delivery(){
            var _token = $('input[name="_token"]').val();
             $.ajax({
                url : '{{url('/select-feeship')}}',
                method: 'POST',
                data:{_token:_token},
                success:function(data){
                   $('#load_delivery').html(data);
                }
            });
        }
       
        $(document).on('click','.delete-ship',function(){

var feeship_id = $(this).data('feeship_id');

 var _token = $('input[name="_token"]').val();
// alert(feeship_id);
// alert(fee_value);
$.ajax({
    url : '{{url('/delete-delivery')}}',
    method: 'POST',
    data:{feeship_id:feeship_id,  _token:_token},
    success:function(data){
       fetch_delivery();
    }
});

});
        $(document).on('blur','.fee_feeship_edit',function(){

            var feeship_id = $(this).data('feeship_id');
            var fee_value = $(this).text();
             var _token = $('input[name="_token"]').val();
            // alert(feeship_id);
            // alert(fee_value);
            $.ajax({
                url : '{{url('/update-delivery')}}',
                method: 'POST',
                data:{feeship_id:feeship_id, fee_value:fee_value, _token:_token},
                success:function(data){
                   fetch_delivery();
                }
            });

        });
        $('.add_delivery').click(function(){

           var city = $('.city').val();
           var province = $('.province').val();
           var wards = $('.wards').val();
           var fee_ship = $('.fee_ship').val();
            var _token = $('input[name="_token"]').val();
           // alert(city);
           // alert(province);
           // alert(wards);
           // alert(fee_ship);
            $.ajax({
                url : '{{url('/insert-delivery')}}',
                method: 'POST',
                data:{city:city, province:province, _token:_token, wards:wards, fee_ship:fee_ship},
                success:function(data){
                   fetch_delivery();
                }
            });


        });
        $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
            // alert(action);
            //  alert(matp);
            //   alert(_token);

            if(action=='city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            $.ajax({
                url : '{{url('/select-delivery')}}',
                method: 'POST',
                data:{action:action,ma_id:ma_id,_token:_token},
                success:function(data){
                   $('#'+result).html(data);     
                }
            });
        }); 
    })
  </script>
  <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
  {!! Toastr::message() !!}

</body>

</html>
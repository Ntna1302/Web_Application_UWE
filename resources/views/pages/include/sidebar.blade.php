<div class="col-sm-3">
  <div class="left-sidebar">
    <h2>Categories</h2>
    <div class="panel-group category-products" id="accordian">
      <!--category-productsr-->
      @foreach($category as $key => $cate)

      <div class="panel panel-default">
        @if($cate->category_parent==1)

        <div class="panel-heading">
          <h4 class="panel-title">
            @if(!Session::get('success_paypal')==true)

            <a data-toggle="collapse" data-parent="#accordian"
              href="#{{$cate->slug_category_product}}">{{$cate->category_name}} <span class="badge pull-right"><i
                  class="fa fa-plus"></i></span></a>
            @else
            <a data-toggle="collapse" data-parent="#accordian" href="{{URL::to('/checkout')}}">{{$cate->category_name}}
              <span class="badge pull-right"><i class="fa fa-plus"></i></span></a>

            @endif
          </h4>
        </div>
        <div id="{{$cate->slug_category_product}}" class="panel-collapse collapse">
          <div class="panel-body">
            <ul>
              @foreach($category as $key => $cate_sub)
              @if($cate_sub->category_parent == $cate->category_id)

              <li style="margin-bottom:10px;"><a
                  href="{{URL::to('/danh-muc/'.$cate_sub->slug_category_product)}}">{{$cate_sub->category_name}} </a>
              </li>
              @endif
              @endforeach

            </ul>
          </div>
        </div>
        @endif

      </div>
      @endforeach
    </div>
    <!--/category-products-->

    <div class="brands_products">
      <!--brands_products-->
      <h2>Brands</h2>
      <div class="brands-name">
        <ul class="nav nav-pills nav-stacked">
          @foreach($brand as $key => $brand)


          <li>
            @if(!Session::get('success_paypal')==true)

            <a href="{{URL::to('/thuong-hieu/'.$brand->brand_slug)}}"> <span
                class="pull-right"></span>{{$brand->brand_name}}</a>
            @else
            <a href="{{URL::to('/thuong-hieu/'.$brand->brand_slug)}}"> <span
                class="pull-right"></span>{{$brand->brand_name}}</a>
            @endif

          </li>
          @endforeach
        </ul>
      </div>
    </div>
    <!--/brands_products-->

    {{-- <div class="brands_products"><!--brands_products-->
      <h2>Sản phẩm yêu thích</h2>
      <div class="brands-name ">

          <div id="row_wishlist" class="row">    

          </div>

      </div>
  </div> --}}






  </div>
  
</div>
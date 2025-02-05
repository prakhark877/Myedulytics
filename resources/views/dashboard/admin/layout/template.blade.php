
<!--Header start-->
      @include('dashboard.admin.includes.header') 
<!--Header end-->
                    

<div id="wrapper" class="my-flex-item flex-grow-1">
<!--container start-->
      @yield('content')
<!--container end-->
</div>
  @include('dashboard.admin.cms_layouts.footer')


   

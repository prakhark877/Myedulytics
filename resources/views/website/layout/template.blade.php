
<!--Header start-->
      @include('website.includes.header') 
<!--Header end-->
                    

<div id="wrapper" class="my-flex-item flex-grow-1">
<!--container start-->
      @yield('content')
      <script>
         var vrApiUrl = "http://localhost:8002";

      </script>
<!--container end-->
</div>
  @include('website.cms_layouts.footer')


   

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="../../dist/img/user-default.png" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="../../dist/img/user-default.png" class="img-circle elevation-2" alt="User Image">

            <p>
              <small>{{ $user->name }}</small>
              <small>{{ $user->email }}</small>
            </p>
          </li>
        
          <!-- Menu Footer-->
          <li class="user-footer">
            <form method="POST" action="{{ url('logout') }}">
                @csrf
           <button type="submit" class="btn btn-default btn-flat float-right"> Log out</button>
        </form>
          </li>
        </ul>
      </li>
      <form method="POST" action="{{ url('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-log-out"></span> Log out</button>
    </form>
      {{-- <a href="{{ url('logout') }}" class="btn btn-danger btn-lg" ><span class="glyphicon glyphicon-log-out"></span> Log out</a> --}}
  
    </ul>
  </nav>


  <!--- Left Side Bar ---->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="https://d34hmiuaex7c0.cloudfront.net/5718/uploads/page_featured_img_1732603210590.png" alt="Little Adventure" class=" img-elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="width: 100% !important;">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user-default.png" class="img-circle elevation-2" alt="#">
        </div>
        <div class="info">
          <a href="/dashboard" class="d-block">Student Portal</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Student
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">2</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li  class="nav-item">
                <a href="/student-profile" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
              <li  class="nav-item">
                <a href="/student-attempt-quiz" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Attempt Quiz</p>
                </a>
              </li>

            
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
               Books
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">0</span>
              </p>
            </a>
            {{-- <ul class="nav nav-treeview">
              <li  class="nav-item">
                <a href="/block_users_chat" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Block Users(Chat)</p>
                </a>
              </li>

             <li  class="nav-item">
                <a href="/block_users_feed" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Block Users(Feed)</p>
                </a>
              </li>

            </ul> --}}
          </li>

          
        </ul>        
      </nav>       
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/dashboard') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/contact') }}" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img 
                    src="{{ $user && $user->profile_image ? asset('storage/'.$user->profile_image) : asset('dist/img/user-default.png') }}" 
                    class="user-image img-circle elevation-2" 
                    alt="User Image"
                >
                <span class="d-none d-md-inline">
                    {{ $user ? $user->name : 'Guest' }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img 
                        src="{{ $user && $user->profile_image ? asset('storage/'.$user->profile_image) : asset('dist/img/user-default.png') }}" 
                        class="img-circle elevation-2" 
                        alt="User Image"
                    >
                    <p>
                        {{ $user ? $user->name : 'Guest User' }}<br>
                        <small>{{ $user ? $user->email : 'No email available' }}</small>
                    </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                    @if($user)
                        <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-flat w-100">Login</a>
                    @endif
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

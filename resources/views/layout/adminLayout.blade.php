<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <link rel="shortcut icon" href="{{asset('/')}}images/magazine_icon.png">

    <!-- Title Page-->
    <title>@yield('title') | Admin panel</title>

    <!-- Fontfaces CSS-->
    <link href="{{asset('/')}}adminScript/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{asset('/')}}adminScript/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{asset('/')}}css/theme.css" rel="stylesheet" media="all">
    <link href="{{asset('/')}}css/paginacija.css" rel="stylesheet">
    <link href="{{asset('/')}}css/custom-custom.css" rel="stylesheet">
    <style>
    .bs-example
    {
        margin: 5px 50px;
        width: 300px;
    }
    </style>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="{{asset('/')}}">
                    <img src="{{asset('/')}}img/logo.png" alt="" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="{{ request()->routeIs('admin_users') ? 'active has-sub' : null }}">
                            <a class="js-arrow" href="{{asset('/admin/users')}}">
                                <i class="fa fa-user"></i>Users</a>
                        </li>
                        <li class="{{ request()->routeIs('admin_posts') ? 'active has-sub' : null }}">
                            <a href="{{asset('/admin/posts')}}">
                                <i class="fa fa-newspaper"></i>Posts</a>
                        </li>
                        <li class="{{ request()->routeIs('admin_images') ? 'active has-sub' : null }}">
                            <a href="{{asset('/admin/images')}}">
                                <i class="fa fa-image"></i>Images</a>
                        </li>
                        <li class="{{ request()->routeIs('admin_comments') ? 'active has-sub' : null }}">
                            <a href="{{asset('/admin/comments')}}">
                                <i class="fa fa-comment"></i>Comments</a>
                        </li>
                        <li class="{{ request()->routeIs('admin_navigation') ? 'active has-sub' : null }}">
                            <a href="{{asset('/admin/navigation')}}">
                                <i class="fa fa-bars"></i>Navigation</a>
                        </li>
                        <li class="{{ request()->routeIs('admin_roles') ? 'active has-sub' : null }}">
                            <a href="{{asset('/admin/roles')}}">
                                <i class="fa fa-users"></i>Roles</a>
                        </li>
                        <li>
                            <a href="{{asset('/logout')}}">
                                <i class="fa fa-power-off"></i>Log out</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="page-container">
            <header class="header-desktop">
                @empty(!session('success'))
                <div class="bs-example"> 
                <div class="alert alert-dark alert-dismissible fade show">
                    <strong>{{ session('success') }} </strong>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                </div> 
                @endempty

                @empty(!session('error'))
                <div class="bs-example"> 
                <div class="alert alert-warning alert-dismissible fade show">
                    <strong>Alert! {{ session('error') }} </strong>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                </div>
                @endempty

                @isset($errors)

                <div class="errors">
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="bs-example"> 
                            <div class="alert alert-warning alert-dismissible fade show">
                                <strong>Alert! {{ $error }} </strong>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                @endisset
            </header>
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <script src="{{asset('/')}}js/jquery.min.3.3.1.js"></script>
    <script src="{{asset('/')}}js/vendor/bootstrap.min.js"></script>
    <script src="{{asset('/')}}js/paginacija.js"></script>
    
</body>

</html>
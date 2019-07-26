<html lang="zxx" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="{{asset('/')}}images/magazine_icon.png">
		<!-- Author Meta -->
		<meta name="author" content="colorlib">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title>@yield('title') | Phone reviews</title>
		<link href="{{asset('/')}}css/fonts.googleapis.css" rel="stylesheet">
		<!--
		CSS
		============================================= -->
                @section('css')		
		<link rel="stylesheet" href="{{asset('/')}}css/font-awesome.min.css">
		<link rel="stylesheet" href="{{asset('/')}}css/bootstrap.css"> 	
		<link rel="stylesheet" href="{{asset('/')}}css/main.css">
                <link rel="stylesheet" href="{{asset('/')}}css/custom-custom.css">
                <link rel="stylesheet" href="{{asset('/')}}css/linearicons.css">
                <link rel="stylesheet" href="{{asset('/')}}css/owl.carousel.css">
                @show
                <style>
                .bs-example
                {
                    margin: 5px 50px;
                    width: 300px;
                }
                </style>
	</head>
        <body>
		<header>			
			<div class="header-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-6 header-top-left no-padding">
							<ul>
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-behance"></i></a></li>
							</ul>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-6 header-top-right no-padding">
							<ul>
                                                            @if(session()->has('user'))
                                                            <li><a href="#">Logged in as:&nbsp<b>{{ session()->get('user')[0]->username }}</b></a></li>
                                                            @endif
                                                            
                                                            @if(session()->has('user'))
                                                                @isset($logout)
                                                                    @foreach($logout as $l)
                                                                        <li><a href="{{ url($l->putanja) }}">{{ ($l->naziv) }}</a></li>
                                                                    @endforeach
                                                                @endisset
                                                            @else
                                                                @isset($sign)
                                                                    @foreach($sign as $s)
                                                                        <li><a href="{{ url($s->putanja) }}">{{ ($s->naziv) }}</a></li>
                                                                    @endforeach
                                                                @endisset
                                                            @endif
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="logo-wrap">
				<div class="container">
					<div class="row justify-content-between align-items-center">
						<div class="col-lg-4 col-md-4 col-sm-12 logo-left no-padding">
							<a href="{{asset('/')}}">
								<img class="img-fluid" src="{{asset('/')}}img/logo.png" alt="">
							</a>
						</div>						
					</div>
				</div>
			</div>
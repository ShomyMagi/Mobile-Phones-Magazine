@extends('layout.frontLayout')

@section('title')
    Home
@endsection

@section('content')
    <!-- Start top-post Area -->
			<section class="top-post-area pt-10">
				<div class="container no-padding">
					<div class="row small-gutters">
                                            
                                            @isset($prvi)
                                            
						<div class="col-lg-8 top-post-left">
							<div class="feature-image-thumb relative">
								<div class="overlay overlay-bg"></div>
								<img class="img-fluid" src="{{asset($prvi->putanja)}}" alt="{{$prvi->alt}}">
							</div>
							<div class="top-post-details">
								<ul class="tags">
									<li><a href="{{asset('onePost/'.$prvi->id_uredjaj)}}">{{$prvi->naziv}}</a></li>
								</ul>
								<a href="{{asset('onePost/'.$prvi->id_uredjaj)}}">
									<h3>{{$prvi->headline}}</h3>
								</a>
								<ul class="meta">
									<li><span class="lnr lnr-calendar-full"></span>{{date('d F, Y', strtotime($prvi->created_at))}}</li>
								</ul>
							</div>
						</div>
                                                
                                            @endisset
                                            
						<div class="col-lg-4 top-post-right">
                                                    
                                                    @isset($drugi)
                                                    
							<div class="single-top-post">
								<div class="feature-image-thumb relative">
									<div class="overlay overlay-bg"></div>
									<img class="img-fluid" src="{{asset($drugi->putanja)}}" alt="{{$drugi->alt}}">
								</div>
								<div class="top-post-details">
									<ul class="tags">
										<li><a href="{{asset('onePost/'.$drugi->id_uredjaj)}}">{{$drugi->naziv}}</a></li>
									</ul>
									<a href="{{asset('onePost/'.$drugi->id_uredjaj)}}">
										<h4>{{$drugi->headline}}</h4>
									</a>
									<ul class="meta">
										<li><span class="lnr lnr-calendar-full"></span>{{date('d F, Y', strtotime($drugi->created_at))}}</li>
									</ul>
								</div>
							</div>
                                                                                              
                                                    @endisset
                                                    
                                                    @isset($treci)
                                                    
							<div class="single-top-post mt-10">
								<div class="feature-image-thumb relative">
									<div class="overlay overlay-bg"></div>
									<img class="img-fluid" src="{{asset($treci->putanja)}}" alt="{{$treci->alt}}">
								</div>
								<div class="top-post-details">
									<ul class="tags">
										<li><a href="{{asset('onePost/'.$treci->id_uredjaj)}}">{{$treci->naziv}}</a></li>
									</ul>
									<a href="{{asset('onePost/'.$treci->id_uredjaj)}}">
										<h4>{{$treci->headline}}</h4>
									</a>
									<ul class="meta">										
										<li><span class="lnr lnr-calendar-full"></span>{{date('d F, Y', strtotime($treci->created_at))}}</li>
									</ul>
								</div>
							</div>
                                                                                              
                                                    @endisset
                                                    
						</div>                                            						
					</div>
				</div>
			</section>
			<!-- End top-post Area -->
			<!-- Start latest-post Area -->
			<section class="latest-post-area pb-120">
				<div class="container no-padding">
					<div class="row">
						<div class="col-lg-8 post-list">
							<!-- Start latest-post Area -->
							<div class="latest-post-wrap">
								<h4 class="cat-title">Latest News</h4>                                                                                                                                
                                                                
                                                                @isset($ostali)
                                                                @foreach($ostali as $o)
                                                                
								<div class="single-latest-post row align-items-center">                                                                   
									<div class="col-lg-5 post-left">
										<div class="feature-img relative">
											<div class="overlay overlay-bg"></div>
											<img class="img-fluid" src="{{asset($o->putanja)}}" alt="{{$o->alt}}">
										</div>
										<ul class="tags">
											<li><a href="{{asset('onePost/'.$o->id_uredjaj)}}">{{$o->naziv}}</a></li>
										</ul>
									</div>
									<div class="col-lg-7 post-right">
										<a href="{{asset('onePost/'.$o->id_uredjaj)}}">
											<h4>{{$o->naziv}}</h4>
										</a>
										<ul class="meta">
											<li><span class="lnr lnr-calendar-full"></span>{{date('d F, Y', strtotime($o->created_at))}}</li>
										</ul>
										<p class="excert">
											{{$o->headline}}
										</p>
									</div>
								</div>
                                                                
                                                                @endforeach
                                                                @endisset
                                                                
							</div>
							<!-- End latest-post Area -->							
							<!-- Start relavent-story-post Area -->
							<div class="relavent-story-post-wrap mt-30">
								<h4 class="title">Popular News</h4>
                                                                @isset($popular)
                                                                @foreach($popular as $p)
								<div class="relavent-story-list-wrap">
									<div class="single-relavent-post row align-items-center">
										<div class="col-lg-5 post-left">
											<div class="feature-img relative">
												<div class="overlay overlay-bg"></div>
												<img class="img-fluid" src="{{asset($p->putanja)}}" alt="{{asset($p->alt)}}">
											</div>
											<ul class="tags">
												<li><a href="{{asset('onePost/'.$p->id_uredjaj)}}">{{$p->naziv}}</a></li>
											</ul>
										</div>
										<div class="col-lg-7 post-right">
											<a href="{{asset('onePost/'.$p->id_uredjaj)}}">
												<h4>{{$p->naziv}}</h4>
											</a>
											<ul class="meta">
												<li><span class="lnr lnr-calendar-full"></span>{{date('d F, Y', strtotime($p->created_at))}}</li>
											</ul>
											<p class="excert">
												{{$p->headline}}
											</p>
										</div>
									</div>
								</div>
                                                                @endforeach
                                                                @endisset
							</div>
							<!-- End relavent-story-post Area -->
						</div>
						@include('components.sideBar');
					</div>
				</div>
			</section>
			<!-- End latest-post Area -->
@endsection
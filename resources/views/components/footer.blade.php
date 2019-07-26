		<footer class="footer-area section-gap">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-6 single-footer-widget">
						<h4>Footer Menu</h4>
						<h5><ul>
							@if(session()->has('user'))
                                                        @if(session()->get('user')[0]->naziv == 'admin')
                                                            @isset($admin)
                                                                @foreach($admin as $adm)
                                                                    <li><a href="{{ url($adm->putanja) }}">{{ ($adm->naziv) }}</a></li>
                                                                @endforeach
                                                            @endisset
                                                        @elseif(session()->get('user')[0]->naziv == 'user')
                                                            @isset($user)
                                                                @foreach($user as $u)
                                                                    <li><a href="{{ url($u->putanja) }}">{{ ($u->naziv) }}</a></li>
                                                                @endforeach
                                                            @endisset
                                                        @endif
                                                        @else
                                                            @isset($all)
                                                                @foreach($all as $a)
                                                                    <li><a href="{{ url($a->putanja) }}">{{ ($a->naziv) }}</a></li>
                                                                @endforeach
                                                            @endisset
                                                    @endif
						</ul></h5>
					</div>
					<div class="col-lg-2 col-md-6 single-footer-widget">
						<h4>Quick Links</h4>
						<ul>
							<li><a href="#">Jobs</a></li>
							<li><a href="#">Brand Assets</a></li>
							<li><a href="#">Investor Relations</a></li>
							<li><a href="#">Terms of Service</a></li>
						</ul>
					</div>
					<div class="col-lg-2 col-md-6 single-footer-widget">
						<h4>Features</h4>
						<ul>
							<li><a href="#">Jobs</a></li>
							<li><a href="#">Brand Assets</a></li>
							<li><a href="#">Investor Relations</a></li>
							<li><a href="#">Terms of Service</a></li>
						</ul>
					</div>
					<div class="col-lg-2 col-md-6 single-footer-widget">
						<h4>Resources</h4>
						<ul>
							<li><a href="#">Guides</a></li>
							<li><a href="#">Research</a></li>
							<li><a href="#">Experts</a></li>
							<li><a href="#">Agencies</a></li>
						</ul>
					</div>
					<div class="col-lg-3 col-md-6 single-footer-widget">
						<h4>Instragram Feed</h4>
						<ul class="instafeed d-flex flex-wrap">
                                                    @foreach($instaImages as $instaImage)
							<li><img src="{{asset($instaImage->putanja)}}" alt="{{$instaImage->alt}}" height="60px"></li>
							
                                                    @endforeach
						</ul>
					</div>
				</div>
				<div class="footer-bottom row align-items-center">
					<p class="footer-text m-0 col-lg-8 col-md-12">
                                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Miloš Simić 113/13</p>
					<div class="col-lg-4 col-md-12 footer-social">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-dribbble"></i></a>
						<a href="#"><i class="fa fa-behance"></i></a>
					</div>
				</div>
			</div>
		</footer>
		<!-- End footer Area -->
                @section('javaScript')
		<script src="{{asset('/')}}js/vendor/jquery-2.2.4.min.js"></script>		
		<script src="{{asset('/')}}js/vendor/bootstrap.min.js"></script>						
		<script src="{{asset('/')}}js/main.js"></script>
                <script src="{{asset('/')}}js/owl.carousel.min.js"></script>
                <script src="{{asset('/')}}js/jquery.magnific-popup.min.js"></script>
                <script src="{{asset('/')}}js/superfish.min.js"></script>
                @show
	</body>
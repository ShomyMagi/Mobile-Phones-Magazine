<div class="container main-menu" id="main-menu">
				<div class="row align-items-center justify-content-between">
					<nav id="nav-menu-container">
						<ul class="nav-menu">
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
                                                </ul>
					</nav><!-- #nav-menu-container -->
					<div class="navbar-right">
                                            <form action="{{ asset('/search') }}" method="get">
                                                    <input type="text" name="searchValue" id="searchValue" placeholder="Search"/>
                                                    <input type="submit" value="Search" class="btn btn-light btn-sm"/>
                                            </form>
					</div>
				</div>
			</div>
		</header>
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
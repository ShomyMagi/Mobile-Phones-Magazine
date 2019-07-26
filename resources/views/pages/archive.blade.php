@extends('layout.frontLayout')

@section('title')
    Archive
@endsection

@section('content')
    <section class="latest-post-area pb-120">
        <div class="container no-padding">
                <div class="row">
                        <div class="col-lg-8 post-list">
                                <!-- Start latest-post Area -->
                                <div class="latest-post-wrap">
                                        <h4 class="cat-title">All posts</h4>
                                        
                                        <div class="dropdown" id="dropdown">
                                            <form action="{{asset('/archive')}}" method="post" name="sort">
                                                {{csrf_field()}}
                                                <select class="form-control" id="sortiranje" name="sortiranje" onchange="sortThis(this);">
                                                        <option value="0">Sort by</option>
                                                        <option value="1">Oldest</option>
                                                        <option value="2">Latest</option>
                                                </select>
                                            </form>
                                        </div>
                                        
                                        <div class="promena">
                                        @isset($postName)
                                        @foreach($postName as $name)
                                        
                                        <div class="single-latest-post row align-items-center">
                                                <div class="col-lg-5 post-left">
                                                        <div class="feature-img relative">
                                                                <div class="overlay overlay-bg"></div>
                                                                <img class="img-fluid" src="{{asset($name->putanja)}}" alt="{{$name->alt}}">
                                                        </div>
                                                        <ul class="tags">
                                                                <li><a href="{{asset('onePost/'.$name->id_uredjaj)}}">{{$name->naziv}}</a></li>
                                                        </ul>
                                                </div>
                                                <div class="col-lg-7 post-right">
                                                        <a href="{{asset('onePost/'.$name->id_uredjaj)}}">
                                                                <h4>{{$name->naziv}}</h4>
                                                        </a>
                                                        <ul class="meta">
                                                                <li><a href="#"><span class="lnr lnr-calendar-full"></span>{{date('d F, Y', strtotime($name->created_at))}}</a></li>
                                                        </ul>
                                                        <p class="excert">
                                                                {{$name->headline}}
                                                        </p>
                                                </div>
                                        </div>
                                        
                                        @endforeach
                                        @endisset
                                        </div>
                                </div>
                                <!-- End latest-post Area -->
                        </div>
                        @include('components.sideBar')
                </div>
        </div>
</section>
@section('javaScript')
    @parent
    <script src="{{asset('/')}}js/sort.js"></script>
@endsection
<!-- End latest-post Area -->
@endsection
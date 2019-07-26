@extends('layout.frontLayout')

@section('title')
    Search
@endsection

@section('content')
<!-- Start latest-post Area -->
<section class="latest-post-area pb-120">
        <div class="container no-padding">
                <div class="row">
                        <div class="col-lg-8 post-list">
                                <!-- Start latest-post Area -->
                                <div class="latest-post-wrap">
                                        <h4 class="cat-title">Search Results</h4><br>
                                        <h6>Result: {{$rezultat->count()}} </h6><br>
                                        
                                        @if($rezultat->count())
                                        @foreach($rezultat as $rez)

                                        <div class="single-latest-post row align-items-center">                                                                   
                                                <div class="col-lg-5 post-left">
                                                        <div class="feature-img relative">
                                                                <div class="overlay overlay-bg"></div>
                                                                <img class="img-fluid" src="{{asset($rez->putanja)}}" alt="{{$rez->alt}}">
                                                        </div>
                                                        <ul class="tags">
                                                                <li><a href="{{asset('onePost/'.$rez->id_uredjaj)}}">{{$rez->naziv}}</a></li>
                                                        </ul>
                                                </div>
                                                <div class="col-lg-7 post-right">
                                                        <a href="{{asset('onePost/'.$rez->id_uredjaj)}}">
                                                                <h4>{{$rez->naziv}}</h4>
                                                        </a>
                                                        <ul class="meta">
                                                                <li><a href="#"><span class="lnr lnr-calendar-full"></span>{{date('d F, Y', strtotime($rez->created_at))}}</a></li>
                                                        </ul>
                                                        <p class="excert">
                                                                {{$rez->headline}}
                                                        </p>
                                                </div>
                                        </div>

                                        @endforeach
                                        @endif

                                </div>
                                <!-- End latest-post Area -->														
                        </div>
                        @include('components.sideBar');
                </div>
        </div>
</section>
<!-- End latest-post Area -->
@endsection


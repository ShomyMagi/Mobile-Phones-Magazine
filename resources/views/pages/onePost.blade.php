@extends('layout.frontLayout')

@section('title')
    Post
@endsection

@section('content')
<section class="latest-post-area pb-120">
        <div class="container no-padding">
                <div class="row">
                    <div class="col-lg-8 post-list">
                        <!-- Start single-post Area -->
                        <div class="single-post-wrap">
                                <div class="feature-img-thumb relative">
                                        <div class="active-gallery-carusel">
                                            @foreach($getImages as $image)
                                                <div class="single-img relative">
                                                        <div class="overlay overlay-bg"></div>
                                                        <img class="img-fluid item" src="{{asset($image->putanja)}}" alt="{{$image->alt}}">
                                                </div>
                                            @endforeach
                                        </div>
                                </div>
                                <div class="content-wrap">
                                        <ul class="tags mt-10">
                                                <li><a href="#">{{$onePost->naziv}}</a></li>
                                        </ul>
                                        <a href="#">
                                                <h3>{{$onePost->headline}}</h3>
                                        </a>
                                        <ul class="meta pb-20">
                                                <li><a href="#"><span class="lnr lnr-calendar-full"></span>{{ date("F d, Y ", strtotime($onePost->created_at)) }}</a></li>
                                        </ul>
                                        <p>
                                                {{$onePost->text}}
                                        </p>
                                <!--<blockquote>{{$onePost->text}}</blockquote>-->

                                <div class="comment-sec-area">
                                        <div class="container">
                                                <div class="row flex-column">
                                                    <span><h6>Comments: {{$comments->count()}}</span><span id="views"> Views: {{$onePost->views}} </h6></span>                                                    
                                                        @foreach($comments as $comm)
                                                        <div class="comment-list">
                                                                <div class="single-comment justify-content-between d-flex">
                                                                        <div class="user justify-content-between d-flex">
                                                                                <div class="thumb">
                                                                                        <img src="{{asset($comm->avatar)}}" width="60px" height="60px">
                                                                                </div>
                                                                                <div class="desc">
                                                                                        <h5><a href="#"></a>{{$comm->username}}</h5>
                                                                                        <p class="date">{{ date("F d, Y H:i", strtotime($comm->posted_at)) }}</p>
                                                                                        <p class="comment">
                                                                                                {{$comm->tekst}}
                                                                                        </p>
                                                                                </div>
                                                                        </div>
                                                                    @if(session()->has('user'))
                                                                        @if(session()->get('user')[0]->username == $comm->username)
                                                                            <div class="reply-btn"> 
                                                                                    <a href="{{url('/onePost/'.$comm->id_uredjaj.'/'.$comm->id_komentar)}}" class="fa fa-edit fa-2x fa-fw" aria-hidden="true"></a>
                                                                                    <a href="{{url('/onePost/'.$comm->id_uredjaj.'/delete/'.$comm->id_komentar)}}" class="fa fa-trash fa-2x fa-fw" aria-hidden="true"></a>
                                                                            </div>
                                                                        @elseif(session()->get('user')[0]->id_uloga == 1)
                                                                            <div class="reply-btn"> 
                                                                                    <a href="{{url('/onePost/'.$comm->id_uredjaj.'/'.$comm->id_komentar)}}" class="fa fa-edit fa-2x fa-fw" aria-hidden="true"></a>
                                                                                    <a href="{{url('/onePost/'.$comm->id_uredjaj.'/delete/'.$comm->id_komentar)}}" class="fa fa-trash fa-2x fa-fw" aria-hidden="true"></a>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                        </div>
                                                        @endforeach
                                                        @if(!session()->has('user'))
                                                        <hr><blockquote>To place a comment please <u><a href="{{url('/register')}}">log in.</a></u></blockquote>                                                    
                                                        @endif
                                                </div>
                                        </div>
                                </div>
                        </div>
                        @if(session()->has('user'))
                        <div class="comment-form">                            
                                <h4>{{isset($selectedComm) ? 'Edit Comment' : 'Post Comment'}}</h4>
                                <form action="{{ isset($selectedComm) ? asset('/onePost/'.$post->id_uredjaj.'/'.$selectedComm->id_komentar) : asset('/onePost/'.$post->id_uredjaj.'/post') }}" method="post">
                                    {{csrf_field()}}
                                        <div class="form-group">
                                                <textarea class="form-control mb-10" rows="5" name="comment" placeholder="Message" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Message'">{{isset($selectedComm) ? $selectedComm->tekst : old('Message')}}</textarea>
                                        </div>
                                    <button type="submit" class="btn btn-danger">{{isset($selectedComm) ? 'Update Comment' : 'Post Comment'}}</button>
                                    @if(isset($selectedComm))
                                        <a href="{{asset('onePost/'.$post->id_uredjaj)}}" class="btn btn-danger">Cancel</a>
                                    @endif
                                </form>
                        </div>
                        @endif
                    </div>
                    <!-- End single-post Area -->
                </div>
                @include('components.sideBar');
            </div>
        </div>
    </section>
@endsection
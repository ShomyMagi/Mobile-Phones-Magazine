@extends('layout.frontLayout')

@section('title')
    User page
@endsection

@section('content')
    <!-- Start latest-post Area -->
<section class="latest-post-area pb-120">
        <div class="container no-padding">          
                <div class="row">
                        <div class="col-lg-8 post-list">
                                <!-- Start latest-post Area -->
                                <div class="latest-post-wrap">
                                    <h4 class="cat-title">Personal Information</h4>
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <td>Avatar:</td>
                                                    <td>Username:</td>
                                                    <td>Email:</td>
                                                    <td>Updated at:</td>                                                    
                                                </tr>
                                            </thead>
                                                <tr>
                                                    <td><img src="{{asset($userPage->avatar)}}" width="60px" height="60px"/></td>
                                                    <td>{{$userPage->username}}</td>
                                                    <td>{{$userPage->email}}</td>
                                                    <td>{{isset($userPage->korisnikUpdate) ? date('F d, Y H:i', strtotime($userPage->korisnikUpdate)) : 'profile not edited'}}</td>
                                                    <td><a href="{{asset('/user/show/'.$userPage->id_korisnik)}}" class="fa fa-edit fa-2x fa-fw" style="color:black" aria-hidden="true"></a></td>                                                
                                                </tr>
                                        </table><hr>
                                </div>
                                <div class="latest-post-wrap">
                                        <h4 class="cat-title">User Activity</h4>
                                        @isset($userComments)
                                        @if(!count($userComments) == 0)
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <td>Image:</td>
                                                    <td>Headline:</td>
                                                    <td>Comment:</td>
                                                    <td>Posted at:</td>                                                    
                                                </tr>
                                            </thead>
                                                @foreach($userComments as $userC)
                                                <tr>
                                                    <td><a href="{{url('/onePost/'.$userC->id_uredjaj)}}"><img src="{{asset($userC->putanja)}}" width="60px" height="60px"/></a></td>
                                                    <td>{{$userC->naziv}}</td>
                                                    <td>{{$userC->tekst}}</td>
                                                    <td>{{date('F d, Y H:i', strtotime($userC->posted_at))}}</td>
                                                    <td><a href="{{url('/onePost/'.$userC->id_uredjaj)}}" class="fa fa-arrow-circle-right fa-2x fa-fw" style="color:black" aria-hidden="true"></a></td>
                                                </tr>
                                                @endforeach
                                        </table><hr>
                                        @else
                                        <hr><div class="alert alert-dark" role="alert">
                                            User hasn't commented anything yet!
                                        </div>
                                        @endif
                                        @endisset
                                </div>
                                <!-- End latest-post Area -->														
                        </div>                        
                        @include('components.sideBar');
                </div>
        </div>
</section>
<!-- End latest-post Area -->
@endsection
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
                                    <h4 class="cat-title">Personal Information</h4><hr>
                                        
                                        <form action="{{asset('/user/update/'.$showUser->id_korisnik)}}" method="post" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="email" name="email" class="form-control" value="{{$showUser->email}}"/>
                                        </div>
                                        <div class="form-group">
                                            <label>New Password:</label>
                                            <input type="password" name="password" class="form-control" value=""/>
                                        </div>
                                        <div class="form-group">
                                            <label>Repeat Password:</label>
                                            <input type="password" name="password_confirmation" class="form-control" value=""/>
                                        </div>
                                        <div class="form-group">
                                            <label>Avatar:</label>
                                            <img src="{{asset($showUser->avatar)}}" width="150px" height="150px"/>
                                            <input type="file" name="avatar"/>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger">Update</button>
                                            <a href="{{asset('/user')}}" class="btn btn-danger">Cancel</a>
                                        </div>
                                        </form>                                     
                                </div>
                                <!-- End latest-post Area -->														
                        </div>                        
                        @include('components.sideBar');
                </div>
        </div>
</section>
<!-- End latest-post Area -->
@endsection
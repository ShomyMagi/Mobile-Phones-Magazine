@isset($postAsc)
@foreach($postAsc as $asc)
<div class="single-latest-post row align-items-center">
        <div class="col-lg-5 post-left">
                <div class="feature-img relative">
                        <div class="overlay overlay-bg"></div>
                        <img class="img-fluid" src="{{asset($asc->putanja)}}" alt="{{$asc->alt}}">
                </div>
                <ul class="tags">
                        <li><a href="{{asset('onePost/'.$asc->id_uredjaj)}}">{{$asc->naziv}}</a></li>
                </ul>
        </div>
        <div class="col-lg-7 post-right">
                <a href="{{asset('onePost/'.$asc->id_uredjaj)}}">
                        <h4>{{$asc->naziv}}</h4>
                </a>
                <ul class="meta">
                        <li><a href="#"><span class="lnr lnr-calendar-full"></span>{{date('d F, Y', strtotime($asc->created_at))}}</a></li>
                </ul>
                <p class="excert">
                        {{$asc->headline}}
                </p>
        </div>
</div>
@endforeach
@endisset

@isset($allPosts)
@foreach($allPosts as $onePost)
<div class="single-latest-post row align-items-center">
        <div class="col-lg-5 post-left">
                <div class="feature-img relative">
                        <div class="overlay overlay-bg"></div>
                        <img class="img-fluid" src="{{asset($onePost->putanja)}}" alt="{{$onePost->alt}}">
                </div>
                <ul class="tags">
                        <li><a href="{{asset('onePost/'.$onePost->id_uredjaj)}}">{{$onePost->naziv}}</a></li>
                </ul>
        </div>
        <div class="col-lg-7 post-right">
                <a href="{{asset('onePost/'.$onePost->id_uredjaj)}}">
                        <h4>{{$onePost->naziv}}</h4>
                </a>
                <ul class="meta">
                        <li><a href="#"><span class="lnr lnr-calendar-full"></span>{{date('d F, Y', strtotime($onePost->created_at))}}</a></li>
                </ul>
                <p class="excert">
                        {{$onePost->headline}}
                </p>
        </div>
</div>
@endforeach
@endisset
<div class="col-lg-4">
        <div class="sidebars-area">
                <div class="single-sidebar-widget editors-pick-widget">
                        <h6 class="title">Latest Comments</h6>
                        <div class="editors-pick-post">
                                <div class="post-lists">
                                    @foreach($getComments as $comment)
                                        <div class="single-post d-flex flex-row">
                                                <div class="thumb">
                                                    <a href="{{asset('/onePost/'.$comment->id_uredjaj)}}"><img src="{{asset($comment->putanja)}}" alt="{{$comment->alt}}" width="90px" height="60px"></a>
                                                </div>
                                                <div class="detail">
                                                        <a href="{{asset('/onePost/'.$comment->id_uredjaj)}}"><h6>{{$comment->tekst}}</h6></a>
                                                        <ul class="meta">
                                                        <li><span class="lnr lnr-calendar-full"></span>{{date("F d, Y H:i", strtotime($comment->posted_at))}}</li><br>
                                                                <li><span class="lnr lnr-user"></span><a>{{$comment->username}}</a></li>
                                                        </ul>
                                                </div>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                </div>							
                <div class="single-sidebar-widget social-network-widget">
                        <h6 class="title">Social Networks</h6>
                        <ul class="social-list">
                                <li class="d-flex justify-content-between align-items-center fb">
                                        <div class="icons d-flex flex-row align-items-center">
                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                                <p>983 Likes</p>
                                        </div>
                                        <a href="#">Like our page</a>
                                </li>
                                <li class="d-flex justify-content-between align-items-center tw">
                                        <div class="icons d-flex flex-row align-items-center">
                                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                                <p>983 Followers</p>
                                        </div>
                                        <a href="#">Follow Us</a>
                                </li>
                                <li class="d-flex justify-content-between align-items-center yt">
                                        <div class="icons d-flex flex-row align-items-center">
                                                <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                                <p>983 Subscriber</p>
                                        </div>
                                        <a href="#">Subscribe</a>
                                </li>
                                <li class="d-flex justify-content-between align-items-center rs">
                                        <div class="icons d-flex flex-row align-items-center">
                                                <i class="fa fa-rss" aria-hidden="true"></i>
                                                <p>983 Subscribe</p>
                                        </div>
                                        <a href="#">Subscribe</a>
                                </li>
                        </ul>
                </div>
        </div>
</div>
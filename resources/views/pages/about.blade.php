@extends('layout.frontLayout')

@section('title')
    About me
@endsection

@section('content')

<!-- Start latest-post Area -->
<section class="latest-post-area pb-120">
        <div class="container no-padding">
                <section class="contact-page-area pt-50 pb-120">
                            <div class="container">
                                    <div class="row contact-wrap">
                                        <div class="container" id="container_about">
                                            <div class="row">
                                              <div class="col-md-6 img">
                                                <img src="{{asset('images/profile_picture.jpg')}}" width="170px" height="250px"  alt="about_me_image">
                                              </div>
                                              <div class="col-md-6 details">
                                                <blockquote>
                                                  <h5>Miloš Simić</h5>
                                                  <small><cite title="Source Title">web developer  <i class="icon-map-marker"></i></cite></small>
                                                </blockquote>
                                                <p>
                                                  Hi my name is Miloš. I'm hardworking, young web developer with great focus.
                                                  I'm also passionate and creative in coding and ready for solo and teamwork.
                                                  I'm fluent in english and serbian.<br>
                                                  My skills invole: HTML (5), CSS (3), Object oriented PHP (Laravel and Cake), JavaScript, jQuery, AJAX, MySQL, Git
                                                </p>
                                              </div>
                                            </div>
                                        </div>
                                            <div class="col-lg-3 d-flex flex-column address-wrap">
                                                    <div class="single-contact-address d-flex flex-row">
                                                            <div class="icon">
                                                                    <span class="lnr lnr-home"></span>
                                                            </div>
                                                            <div class="contact-details">
                                                                    <h5>Belgrade, SERBIA</h5>
                                                                    <p>
                                                                            54 V/10, Šejkina
                                                                    </p>
                                                            </div>
                                                    </div>
                                                    <div class="single-contact-address d-flex flex-row">
                                                            <div class="icon">
                                                                    <span class="lnr lnr-phone-handset"></span>
                                                            </div>
                                                            <div class="contact-details">
                                                                    <h5>+381 644546168</h5>
                                                                    <p>Feel free to contact me anytime</p>
                                                            </div>
                                                    </div>
                                                    <div class="single-contact-address d-flex flex-row">
                                                            <div class="icon">
                                                                    <span class="lnr lnr-envelope"></span>
                                                            </div>
                                                            <div class="contact-details">
                                                                    <h5>milos.simic002@gmail.com</h5>
                                                                    <p>Send me an email</p>
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="col-lg-9">
                                                    <form class="form-area contact-form text-right" id="myForm" action="{{asset('/about/sendMail')}}" method="post">
                                                        {{csrf_field()}}
                                                            <div class="row">
                                                                    <div class="col-lg-6">
                                                                            @if(!session()->has('user'))
                                                                            <input name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" class="common-input mb-20 form-control" required="" type="text">
                                                                            <input name="email" placeholder="Enter email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="text">
                                                                            @endif
                                                                            <input name="subject" placeholder="Enter subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter subject'" class="common-input mb-20 form-control" required="" type="text">
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                            <textarea class="common-textarea form-control" name="message" placeholder="Enter Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Messege'" required=""></textarea>
                                                                    </div>
                                                                    <div class="col-lg-12" style="padding: 15px;">
                                                                            <div class="alert-msg" style="text-align: left;"></div>
                                                                            <button type="submit" class="primary-btn primary" style="float: right;">Send Message</button>
                                                                    </div>
                                                            </div>
                                                    </form>
                                            </div>
                                    </div>
                            </div>
                    </section>
        </div>
</section>
@section('javaScript')
    @parent
    <script src="{{asset('/')}}js/mail-script.js"></script>
    <script src="{{asset('/')}}js/jquery.ajaxchimp.min.js"></script>
@endsection
<!-- End latest-post Area -->
@endsection
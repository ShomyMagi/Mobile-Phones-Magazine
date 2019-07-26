@extends('layout.adminLayout')

@section('title')
    Comments
@endsection

@section('content')
    <div class="col-lg-7">
        <div class="au-card recent-report">
            <div class="au-card-inner">
                <h3 class="title-2">all comments</h3><hr>
                <div class='table-wrapper'>
                @if(count($komentari) > 5)
                <div class='wrapper-paging'>
                  <ul>
                    <li><a class='paging-back'><span class="fa fa-arrow-left"></span></a></li>
                    <li><a class='paging-this'><strong>0</strong> of <span>x</span></a></li>
                    <li><a class='paging-next'><span class="fa fa-arrow-right" aria-hidden="true"></span></a></li>
                  </ul>
                </div>
                @endif
                <table class="table">
                    <thead>
                        <tr>
                            <td>Comment:</td>
                            <td>Post:</td>
                            <td>User posted:</td>
                            <td>Posted at:</td>
                            <td>Updated at:</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($komentari as $komentar)
                        <tr>
                            <td>{{$komentar->tekst}}</td>
                            <td>{{$komentar->naziv}}</td>
                            <td>{{$komentar->username}}</td>
                            <td>{{date("F d, Y H:i", strtotime($komentar->posted_at))}}</td>
                            <td>{{isset($komentar->komentarUpdate) ? date("F d, Y H:i", strtotime($komentar->komentarUpdate)) : 'comment not updated'}}</td>
                            <td><a href="{{asset('/admin/comments/'.$komentar->id_komentar)}}" class="fa fa-edit" style="color:black" aria-hidden="true"></a></td>
                            <td><a href="{{asset('/admin/comment/delete/'.$komentar->id_komentar)}}" class="fa fa-trash" style="color:black" aria-hidden="true"></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                <div class="recent-report__chart">
                    <canvas id="recent-rep-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="au-card recent-report">
            <div class="au-card-inner">
                <h3 class="title-2">{{isset($selectedComment) ? 'update comment' : 'add a new comment'}}</h3><hr>
                <div class="comment-form">                            
                    <form class="register-form" action="{{isset($selectedComment) ? asset('/admin/comment/update/'.$selectedComment->id_komentar) : asset('/admin/comment/insert') }}" method="post">
                    {{csrf_field()}}                    
                    <div class="form-group">
                        <label>{{isset($selectedComment) ? '' : 'On a post:'}}</label> <br>
                        @if(!isset($selectedComment))
                        <select name="ddlUredjaj">
                            <option value="0">Choose post</option>
                            @foreach($uredjaji as $uredjaj)
                            <option value="{{$uredjaj->id_uredjaj}}">{{$uredjaj->naziv}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>                  
                    <div class="form-group">
                        <label>{{isset($selectedComment) ? '' : 'User posting:'}}</label> <br>
                        @if(!isset($selectedComment))
                        <select name="ddlKorisnik">
                            <option value="0">Choose user</option>
                            @foreach($korisnici as $korisnik)
                            <option value="{{$korisnik->id_korisnik}}">{{$korisnik->username}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Comment:</label>
                        <input type="text" name="tbComment" class="form-control" value="{{isset($selectedComment) ? $selectedComment->tekst : ''}}"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" value="{{isset($selectedComment) ? 'Update Comment' : 'Add Comment'}}"/>
                        @if(isset($selectedComment))
                            <a href="{{asset('/admin/comments')}}" class="btn btn-danger">Cancel</a>
                        @endif
                    </div>
                  </form>
                </div>
                <div class="recent-report__chart">
                    <canvas id="recent-rep-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layout.adminLayout')

@section('title')
    Images
@endsection

@section('content')
    <div class="col-lg-7">
        <div class="au-card recent-report">
            <div class="au-card-inner">
                <h3 class="title-2">all images</h3><hr>
                <div class='table-wrapper'>
                @if(count($slike) > 5)
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
                            <td>Route:</td>
                            <td>Alt:</td>
                            <td>Featured:</td>
                            <td>Post:</td>
                            <td>Inserted at:</td>
                            <td>Updated at:</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slike as $slika)
                        <tr>
                            <td><img src="{{asset($slika->putanja)}}" width="90px" height="70px"/></td>
                            <td>{{$slika->alt}}</td>
                            @if($slika->featured == '1')
                                <td>Yes</td>
                            @else
                                <td>No</td>
                            @endif
                            <td>{{$slika->naziv}}</td>
                            <td>{{date("F d, Y H:i", strtotime($slika->inserted_at))}}</td>
                            <td>{{isset($slika->slikaUpdate) ? date("F d, Y H:i", strtotime($slika->slikaUpdate)) : 'image not updated'}}</td>
                            <td><a href="{{asset('/admin/images/'.$slika->id_slika)}}" class="fa fa-edit" style="color:black" aria-hidden="true"></a></td>
                            <td><a href="{{asset('/admin/image/delete/'.$slika->id_slika)}}" class="fa fa-trash" style="color:black" aria-hidden="true"></a></td>
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
                <h3 class="title-2">{{isset($selectedImage) ? 'update image' : 'insert new image'}}</h3><hr>
                <div class="comment-form">                            
                    <form class="register-form" action="{{isset($selectedImage) ? asset('/admin/image/update/'.$selectedImage->id_slika) : asset('/admin/image/insert') }}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Image:</label>
                            @if(isset($selectedImage))
                            <img src="{{asset($selectedImage->putanja)}}" alt="{{$selectedImage->alt}}" width="150px" height="150px">
                            @endif
                        <input type="file" name="fileImage"/>
                    </div>
                    <div class="form-group">
                        <label>Alt:</label>
                        <textarea name="tbAlt" class="form-control">{{isset($selectedImage) ? $selectedImage->alt : ''}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{{isset($selectedImage) ? 'Current feature:'.$selectedImage->featured : 'Featured:'}}</label> <br>
                        @if(isset($selectedImage))
                            <label>New feature:</label>
                        @endif
                        <select name="ddlFeatured">
                            <option value="3">Choose</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{isset($selectedImage) ? '' : 'On a post:'}}</label> <br>
                        @if(!isset($selectedImage))
                        <select name="ddlUredjaj">
                            <option value="0">Choose post</option>
                            @foreach($uredjaji as $uredjaj)
                            <option value="{{$uredjaj->id_uredjaj}}">{{$uredjaj->naziv}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" value="{{isset($selectedImage) ? 'Update Image' : 'Insert Image'}}"/>
                        @if(isset($selectedImage))
                            <a href="{{asset('/admin/images')}}" class="btn btn-danger">Cancel</a>
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
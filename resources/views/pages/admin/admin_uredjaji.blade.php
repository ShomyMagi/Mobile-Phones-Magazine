@extends('layout.adminLayout')

@section('title')
    Posts
@endsection

@section('content')
    <div class="col-lg-7">
        <div class="au-card recent-report">
            <div class="au-card-inner">
                <h3 class="title-2">all posts</h3><hr>
                <div class='table-wrapper'>
                @if(count($uredjaji) > 5)
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
                            <td>Image:</td>
                            <td>Name of the post:</td>
                            <td>Headline:</td>
                            <td>Created at:</td>
                            <td>Updated at:</td>
                        </tr>
                    </thead>
                    <tbody>                        
                            @foreach($uredjaji as $uredjaj)
                            <tr>
                                <td><img src="{{asset($uredjaj->putanja)}}" alt="{{$uredjaj->alt}}" width="50px" height="50px"/></td>
                                <td>{{$uredjaj->naziv}}</td>
                                <td>{{$uredjaj->headline}}</td>
                                <td>{{date("F d, Y H:i", strtotime($uredjaj->created_at))}}</td>
                                <td>{{isset($uredjaj->uredjajUpdate) ? date("F d, Y H:i", strtotime($uredjaj->uredjajUpdate)) : 'post not updated'}}</td>
                                <td><a href="{{asset('/admin/posts/'.$uredjaj->id_uredjaj)}}" class="fa fa-edit" style="color:black" aria-hidden="true"></a></td>
                                <td><a href="{{asset('/admin/post/delete/'.$uredjaj->id_uredjaj)}}" class="fa fa-trash" style="color:black" aria-hidden="true"></a></td>
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
                <h3 class="title-2">{{isset($selectedUredjaj) ? 'update post' : 'insert new post'}}</h3><hr>
                <div class="comment-form">                            
                    <form class="register-form" action="{{isset($selectedUredjaj) ? asset('/admin/post/update/'.$selectedUredjaj->id_uredjaj) : asset('/admin/post/insert') }}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Name of the post:</label>
                        <input type="text" name="tbNaziv" class="form-control" value="{{isset($selectedUredjaj) ? $selectedUredjaj->naziv : ''}}"/>
                    </div>
                    <div class="form-group">
                        <label>Headline:</label>
                        <input type="text" name="tbHeadline" class="form-control" value="{{isset($selectedUredjaj) ? $selectedUredjaj->headline : ''}}"/>
                    </div>
                    <div class="form-group">
                        <label>Text:</label>
                        <textarea name="tbText" class="form-control">{{isset($selectedUredjaj) ? $selectedUredjaj->text : ''}}</textarea>
                    </div>                    
                    <div class="form-group">
                        <label>{{isset($selectedUredjaj) ? '' : 'Alt for image:'}}</label>
                        @if(!isset($selectedUredjaj))
                        <input type="text" name="tbAlt" class="form-control" value="{{isset($selectedUredjaj) ? $selectedUredjaj->alt : ''}}"/>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{isset($selectedUredjaj) ? '' : 'Featured:'}}</label> <br>
                        @if(!isset($selectedUredjaj))
                        <select name="ddlFeatured">
                            <option value="3">Choose</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                        </select>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{isset($selectedUredjaj) ? '' : 'Image:'}}</label>
                        @if(!isset($selectedUredjaj))
                        <input type="file" name="fileImage"/>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" value="{{isset($selectedUredjaj) ? 'Update Post' : 'Insert Post'}}"/>
                        @if(isset($selectedUredjaj))
                            <a href="{{asset('/admin/posts')}}" class="btn btn-danger">Cancel</a>
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
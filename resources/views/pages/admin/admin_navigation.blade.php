@extends('layout.adminLayout')

@section('title')
    Navigation
@endsection

@section('content')
    <div class="col-lg-7">
        <div class="au-card recent-report">
            <div class="au-card-inner">
                <h3 class="title-2">all navigation</h3><hr>
                <div class='table-wrapper'>
                @if(count($navigation) > 5)
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
                            <td>Title:</td>
                            <td>Route:</td>
                            <td>Created at:</td>
                            <td>Updated at:</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($navigation as $nav)
                        <tr>
                            <td>{{$nav->naziv}}</td>
                            <td>{{$nav->putanja}}</td>
                            <td>{{date("F d, Y H:i", strtotime($nav->created_at))}}</td>
                            <td>{{isset($nav->updated_at) ? date("F d, Y H:i", strtotime($nav->updated_at)) : 'navigation not updated'}}</td>
                            <td><a href="{{asset('/admin/navigation/'.$nav->id_navigacija)}}" class="fa fa-edit" style="color:black" aria-hidden="true"></a></td>
                            <td><a href="{{asset('/admin/navigation/delete/'.$nav->id_navigacija)}}" class="fa fa-trash" style="color:black" aria-hidden="true"></a></td>
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
                <h3 class="title-2">insert new navigation</h3><hr>
                <div class="comment-form">                            
                    <form class="register-form" action="{{isset($selectedNavigation) ? asset('/admin/navigation/update/'.$selectedNavigation->id_navigacija) : asset('/admin/navigation/insert') }}" method="post">
                    {{csrf_field()}}                    
                    <div class="form-group">
                        <label>Title:</label>
                        <input type="text" name="tbTitle" class="form-control" value="{{isset($selectedNavigation) ? $selectedNavigation->naziv : ''}}"/>
                    </div>
                    <div class="form-group">
                        <label>Route:</label>
                        <input type="text" name="tbRoute" class="form-control" value="{{isset($selectedNavigation) ? $selectedNavigation->putanja : ''}}"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" value="{{isset($selectedNavigation) ? 'Update Navigation' : 'Add Navigation'}}"/>
                        @if(isset($selectedNavigation))
                            <a href="{{asset('/admin/navigation')}}" class="btn btn-danger">Cancel</a>
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
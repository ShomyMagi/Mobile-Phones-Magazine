@extends('layout.adminLayout')

@section('title')
    Roles
@endsection

@section('content')
    <div class="col-lg-7">
        <div class="au-card recent-report">
            <div class="au-card-inner">
                <h3 class="title-2">all roles</h3><hr>
                <div class='table-wrapper'>
                @if(count($roles) > 5)
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
                            <td>Id role:</td>
                            <td>Role:</td>
                            <td>Created at:</td>
                            <td>Updated at:</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{$role->id_uloga}}</td>
                            <td>{{$role->naziv}}</td>
                            <td>{{date("F d, Y H:i", strtotime($role->created_at))}}</td>
                            <td>{{isset($role->updated_at) ? date("F d, Y H:i", strtotime($role->updated_at)) : 'role not updated'}}</td>
                            <td><a href="{{asset('/admin/roles/'.$role->id_uloga)}}" class="fa fa-edit" style="color:black" aria-hidden="true"></a></td>
                            <td><a href="{{asset('/admin/role/delete/'.$role->id_uloga)}}" class="fa fa-trash" style="color:black" aria-hidden="true"></a></td>
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
                <h3 class="title-2">{{isset($selectedRole) ? 'update role' : 'insert new role'}}</h3><hr>
                <div class="comment-form">                            
                    <form class="register-form" action="{{isset($selectedRole) ? asset('/admin/role/update/'.$selectedRole->id_uloga) : asset('/admin/role/insert') }}" method="post">
                    {{csrf_field()}}                    
                    <div class="form-group">
                        <label>Role:</label>
                        <input type="text" name="tbRole" class="form-control" value="{{isset($selectedRole) ? $selectedRole->naziv : ''}}"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" value="{{isset($selectedRole) ? 'Update Role' : 'Add Role'}}"/>
                        @if(isset($selectedRole))
                            <a href="{{asset('/admin/roles')}}" class="btn btn-danger">Cancel</a>
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
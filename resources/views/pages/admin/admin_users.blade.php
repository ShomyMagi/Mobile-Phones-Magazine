@extends('layout.adminLayout')

@section('title')
    Users
@endsection

@section('content')
    <div class="col-lg-7">
        <div class="au-card recent-report">
            <div class="au-card-inner">
                <h3 class="title-2">all registered users</h3><hr>
                <div class='table-wrapper'>
                @if(count($users) > 5)
                <div class='wrapper-paging'>
                  <ul>
                    <li><a class='paging-back'><span class="fa fa-arrow-left"></span></a></li>
                    <li><a class='paging-this'><strong>0</strong> of <span>x</span></a></li>
                    <li><a class='paging-next'><span class="fa fa-arrow-right"></span></a></li>
                  </ul>
                </div>
                @endif
                <table class="table">
                    <thead>
                        <tr>
                            <td>Avatar:</td>
                            <td>Username:</td>
                            <td>Email:</td>
                            <td>Registered at:</td>
                            <td>Updated at:</td>
                            <td>Role:</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td><img src="{{asset($user->avatar)}}" width="40px" height="40px"/></td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{date("F d, Y H:i", strtotime($user->registered_at))}}</td>
                            <td>{{isset($user->korUpdate) ? date("F d, Y H:i", strtotime($user->korUpdate)) : 'profile not updated'}}</td>
                            <td>{{$user->naziv}}</td>
                            <td><a href="{{asset('/admin/users/'.$user->id_korisnik)}}" class="fa fa-edit" style="color:black" aria-hidden="true"></a></td>
                            <td><a href="{{asset('/admin/user/delete/'.$user->id_korisnik)}}" class="fa fa-trash" style="color:black" aria-hidden="true"></a></td>
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
                <h3 class="title-2">{{isset($selectedUser) ? 'update user' : 'insert new user'}}</h3><hr>
                <div class="comment-form">                            
                    <form class="register-form" action="{{isset($selectedUser) ? asset('/admin/user/update/'.$selectedUser->id_korisnik) : asset('/admin/user/insert') }}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="tbUsername" class="form-control" value="{{isset($selectedUser) ? $selectedUser->username : ''}}"/>
                    </div>
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="tbIme" class="form-control" value="{{isset($selectedUser) ? $selectedUser->ime : ''}}"/>
                    </div>
                    <div class="form-group">
                        <label>Surname:</label>
                        <input type="text" name="tbPrezime" class="form-control" value="{{isset($selectedUser) ? $selectedUser->prezime : ''}}"/>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" name="tbEmail" class="form-control" value="{{isset($selectedUser) ? $selectedUser->email : ''}}"/>
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" name="tbPassword" class="form-control" value="{{isset($selectedUser) ? $selectedUser->password : ''}}"/>
                    </div>
                    <div class="form-group">
                        <label>{{isset($selectedUser) ? 'Current role:'.$selectedUser->naziv : 'Role:'}}</label> <br>
                        @if(isset($selectedUser))
                            <label>New role:</label>
                        @endif
                        <select name="ddlUloga">
                            <option value="0">Choose</option>
                            @foreach($roles as $role)
                                <option value="{{$role->id_uloga}}">{{$role->naziv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Avatar:</label>
                        @if(isset($selectedUser))
                            <img src="{{asset($selectedUser->avatar)}}" width="150px" height="150px">
                        @endif
                        <input type="file" name="fileAvatar" />
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" value="{{isset($selectedUser) ? 'Update User' : 'Insert User'}}"/>
                        @if(isset($selectedUser))
                            <a href="{{asset('/admin/users')}}" class="btn btn-danger">Cancel</a>
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
@extends('layout.default')
@section('title','更新个人资料')
@section('content')
  <div class="offset-md-2 col-md-8">
    <form action="{{route('users.update',$user)}}" method="post">
      {{csrf_field()}}
      {{method_field('PATCH')}}
      <div class="card">
        <div class="card-header">
          更新个人资料
        </div>
        <div class="card-body">
          @include('shared._errors')
          <div class="gravatar_edit">
            <a href="http://gravatar.com/emails" target="_blank">
              <img src="{{$user->gravatar('200')}}" alt="{{$user->name}}" class="gravatar"/>
            </a>
          </div>
          <div class="form-group">
            <label for="name">姓名</label>
            <input type="text" class="form-control" name="name" value="{{$user->name}}">
            <label for="email">邮箱</label>
            <input type="email" class="form-control" name="email" value="{{$user->email}}" disabled>
            <label for="password">密码</label>
            <input type="password" class="form-control" name="password" value="{{old('password')}}">
            <label for="password_conformation">确认密码</label>
            <input type="password" class="form-control" name="password_conformation"
                   value="{{old('password_conformation')}}">
          </div>
        </div>
        <div class="card-footer text-muted">
          <button type="submit" class="btn btn-primary">更新</button>
        </div>
      </div>
    </form>
  </div>
@stop

@extends('layout.default')
@section('title','用户登陆')
@section('content')
  <div class="offset-md-2 col-md-8">
  <div class="card">
    <div class="card-header">
      <h5>登陆</h5>
    </div>

    <div class="card-body">
      @include('shared._errors')
      <form action="{{route('login')}}" method="post">
        {{csrf_field()}}
      <div class="form-group">
        <label for="email">邮箱</label>
        <input type="email"
               class="form-control" name="email" value="{{old('email')}}">
        <small id="helpId" class="form-text text-muted">请输入注册邮箱</small>
        <label for="password">密码</label>
        <input type="password"
               class="form-control" name="password" value="{{old('password')}}">
        <small id="helpId" class="form-text text-muted">请输入密码</small>
      </div>
        <button class="btn btn-primary" type="submit">登陆</button>
      </form>
      <hr>
      <p>还没账号？<a href="{{ route('signup') }}">现在注册！</a></p>
    </div>
  </div>
  </div>
@stop

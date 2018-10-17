<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>后台管理系统</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <script src="{{asset('layui/layui.js')}}"></script>
    <script>
        var GB_HOST = "{{asset('')}}";
    </script>
    <script src="{{asset('js/require/require.min.js')}}"></script>
    <script src="{{asset('js/require/main.js')}}"></script>
    <script>
        require(['jquery'], function () {
            $(function () {
                //layui
                layui.use(['element', 'form'], function () {
                    var element = layui.element;
                    var form = layui.form;
                });
            });
        });
    </script>
</head>
<body class="layui-layout-body">
<div class="container">
    <div class="col-md-8 body-center" style="width: 90%;max-width: 600px;">
        <div class="card">
            <div class="card-header">后台管理系统</div>
            <div class="card-body">
                <form method="post" action="/admin/login">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-sm-right">账号</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" value="{{old('username')}}" placeholder="请输入账号"
                                   class="form-control" autocomplete="off">
                        </div>
                        @if ($errors->has('username'))
                            <div class="col-sm-2"></div>
                            <small class="col-sm-10 form-text text-warning">{{ $errors->first('username')=='These credentials do not match our records.'?'账号或密码错误':$errors->first('username') }}</small>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-sm-right">密码</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" value="{{old('password')}}" placeholder="请输入密码"
                                   class="form-control" autocomplete="off">
                        </div>
                        @if ($errors->has('password'))
                            <div class="col-sm-2"></div>
                            <small class="col-sm-10 form-text text-warning">{{ $errors->first('password') }}</small>
                        @endif
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <div class="custom-control custom-checkbox" style="line-height: 24px;">
                                <input lay-ignore type="checkbox"
                                       class="custom-control-input" {{ old('remember') ? 'checked' : '' }} name="remember" id="remember" change1>
                                <label class="custom-control-label"
                                       for="remember">记住密码</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">登录</button>
                            <a class="btn btn-link" href="#">忘记密码？</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

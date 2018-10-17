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
        var GB_HOST="{{asset('')}}";
    </script>
    <script src="{{asset('js/require/require.min.js')}}"></script>
    <script src="{{asset('js/require/main.js')}}"></script>
    <script>
        require(['jquery','jquery-pjax'],function () {
            if ($.support.pjax) {//浏览器是否支持pjax
                $(document).on('click', '[pjax] a,a[pjax]', function(event) {//点击
                    $.pjax.click(event, {container: '#pjax-container'});//定义加载区域
                });
                $(document).on('submit', 'form[pjax]', function(event) {//提交
                    $.pjax.submit(event, '#pjax-container');//定义加载区域
                });
                //定义pjax有效时间，超过这个时间会整页刷新
                $.pjax.defaults.timeout = 1200;
                //显示加载动画
                $(document).on('pjax:click', function() {
                    $("#loading").show();
                });
                //隐藏加载动画
                $(document).on('pjax:end', function() {
                    $("#loading").hide();
                });
            }
            $(function () {
                //layui
                layui.use(['element','form'], function () {
                    var element = layui.element;
                    var form = layui.form;
                });
            });
        });
    </script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    @include('layouts._header')
    @include('layouts._menu')
    <div class="layui-body" id="pjax-container" style="background-color: #eeeeee;">
        <!--pjax加载动画-->
        <div id="loading">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>
        <!--pjax加载动画结束-->
        <!-- 内容主体区域 -->
        <div class="layui-main" style="margin:15px; padding:15px;background-color: #ffffff;">
            <div class="layui-form">
                @include('layouts._message')
                @include('layouts._validate')
                <div id="app">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('layouts._footer')
</div>
</body>
</html>
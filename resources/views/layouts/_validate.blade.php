@if(count($errors)>0)
    <div id="validate-msg-box" style="display: none;">
        <div class="layui-card">
            <div class="layui-card-body">
                @foreach($errors->all() as $error)
                    <li style="list-style: disc;margin: 0 10px;">{{$error}}</li>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        require(['jquery'],function ($) {
            layui.use('layer', function () {
                var layer = layui.layer;
                layer.open({
                    type: 1,
                    title: '验证信息',
                    skin: 'demo-warning', //样式类名
                    closeBtn: 0, //不显示关闭按钮
                    anim: 2,
                    shadeClose: true, //开启遮罩关闭
                    content: $('#validate-msg-box').html()
                });
            });
        });
    </script>
@endif
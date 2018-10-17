@foreach(['success','warning','danger','default'] as $t)
    @if(session()->has($t))
        <div id="tips-msg-box" style="display: none;">
            <div class="layui-card">
                <div class="layui-card-body">
                    <div style="display: table;width: 100%;">
                        <div style="display: table-cell;vertical-align: middle;height: 100px;text-align: center;">
                            {{session()->get($t)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            require(['jquery'], function ($) {
                layui.use('layer', function () {
                    var layer = layui.layer;
                    layer.open({
                        type: 1,
                        title: '提示信息',
                        skin: 'demo-{{$t}}', //样式类名
                        closeBtn: 0, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        content: $('#tips-msg-box').html(),
                        end:function () {
                            window.location.reload();
                        }
                    });
                });
            });
        </script>
    @endif
@endforeach
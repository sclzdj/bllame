<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree" id="nav-box" lay-filter="test">
            @foreach(\App\Servers\MenuServer::getCurrentMenus() as $v)
                @if($v['type']==0)
                    <li op_en="open{{$v['active']}}" class="layui-nav-item nav-item-1 @if($v['active']=='1') left-menu-active @endif"><a pjax href="{{$v['url']}}">{{$v['title']}}</a></li>
                @else
                    <li class="layui-nav-item nav-item-p-2 @if($v['open']=='1') layui-nav-itemed @endif">
                        <a class="" href="javascript:;">{{$v['title']}}</a>
                        <dl class="layui-nav-child left-menu-item">
                            @foreach($v['list'] as $_v)
                                <dd op_en="open{{$_v['active']}}" class="nav-item-2 @if($_v['active']=='1') left-menu-active @endif"><a pjax href="{{$_v['url']}}">{{$_v['title']}}</a></dd>
                            @endforeach
                        </dl>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
<script>
    require(['jquery'],function () {
        $(function(){
            $('body').on('click','#nav-box .nav-item-1,#nav-box .nav-item-2',function () {
                $('#nav-box .nav-item-1,#nav-box .nav-item-2').removeClass('left-menu-active');
                $('#nav-box .nav-item-1,#nav-box .nav-item-2').attr('op_en','open0');
                $(this).removeClass('left-menu-active').addClass('left-menu-active');
                $(this).removeClass('left-menu-active').attr('op_en','open1');
                $('#nav-box .nav-item-p-2').removeClass('layui-nav-itemed');
                $('#nav-box .nav-item-2').each(function () {
                    if($(this).attr('op_en')=='open1'){
                        $(this).parent('dl').parent('li').addClass('layui-nav-itemed');
                    }
                });
            });
        });
    });
</script>
<div class="layui-header">
    <a href="{{\App\Servers\MenuServer::getHomeUrl()}}">
        <div class="layui-logo">后台管理系统</div>
    </a>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    @php
        $channels=\App\Servers\MenuServer::getChannels();
    @endphp
    <ul class="layui-nav layui-layout-left">
        @foreach($channels as $k=>$v)
            @if($k<4)
                <li class="layui-nav-item @if($v['active']=='1') top-nav-active @endif"><a
                            href="{{$v['url']}}">{{$v['title']}}</a></li>
            @endif
        @endforeach
        @if(count($channels)>4)
            @php
                $top_other_nav=false;
                foreach($channels as $k=>$v){
                    if($k>=4){
                        if($v['active']=='1'){
                            $top_other_nav=true;
                            break;
                        }
                    }
                }
            @endphp
            <li class="layui-nav-item top_other_nav @if($top_other_nav) top-nav-active @endif">
                <a href="javascript:;" style="margin-right: 12px;">其它</a>
                <dl class="layui-nav-child">
                    @foreach($channels as $k=>$v)
                        @if($k>=4)
                            <dd class="@if($v['active']=='1') top-other-nav-active @endif""><a href="{{$v['url']}}">{{$v['title']}}</a></dd>
                        @endif
                    @endforeach
                </dl>
            </li>
        @endif
    </ul>
    <ul class="layui-nav layui-layout-right">
        <li class="layui-nav-item">
            <a href="javascript:;">
                <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                {{auth('admin')->user()->nickname}}
            </a>
            <dl class="layui-nav-child">
                <dd><a href="">基本资料</a></dd>
                <dd><a href="">安全设置</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item"><a href="javascript:;" onclick="logout.submit();">退了</a></li>
        <form action="/admin/logout" method="post" name="logout">
            @csrf
        </form>
    </ul>
</div>
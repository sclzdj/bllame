@extends('layouts.master')
@section('content')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>修改账号</legend>
    </fieldset>
    <form action="/admin/admin/{{$admin['id']}}" method="post" class="layui-form">
        @csrf @method('PUT')
        <div class="layui-form-item container-fluid">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right">用户名</label>
                <div class="col-sm-6">
                    <input type="text" name="username" value="{{old('username')??$admin['username']}}"
                           placeholder="请输入用户名"
                           class="form-control" autocomplete="off">
                </div>
                <label class="col-sm-5 col-form-label text-muted pl-0">
                    长度2-20位，不支持中文和空格
                </label>
                @if ($errors->has('username'))
                    <div class="col-sm-1"></div>
                    <small class="col-sm-11 form-text text-warning">{{ $errors->first('username') }}</small>
                @endif
            </div>
        </div>
        <div class="layui-form-item container-fluid">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right">密码</label>
                <div class="col-sm-6">
                    <input type="password" name="password" value=""
                           placeholder="留空则不修改"
                           class="form-control" autocomplete="off">
                </div>
                <label class="col-sm-5 col-form-label text-muted pl-0">
                    留空则不修改，长度6-18位，只支持这些字符：0-9a-zA-Z_!@#$%^&*
                </label>
                @if ($errors->has('password'))
                    <div class="col-sm-1"></div>
                    <small class="col-sm-11 form-text text-warning">{{ $errors->first('password') }}</small>
                @endif
                @if (!$errors->has('password') && count($errors)>0)
                    <div class="col-sm-1"></div>
                    <small class="col-sm-11 form-text text-warning">需重新输入密码</small>
                @endif
            </div>
        </div>
        <div class="layui-form-item container-fluid">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right">昵称</label>
                <div class="col-sm-6">
                    <input type="text" name="nickname" value="{{old('nickname')??$admin['nickname']}}"
                           placeholder="请输入昵称"
                           class="form-control" autocomplete="off">
                </div>
                <label class="col-sm-5 col-form-label text-muted pl-0">
                    长度2-20位
                </label>
                @if ($errors->has('nickname'))
                    <div class="col-sm-1"></div>
                    <small class="col-sm-11 form-text text-warning">{{ $errors->first('nickname') }}</small>
                @endif
            </div>
        </div>
        @php
            $access_type=old('access_type')!==null?old('access_type'):$admin['access_type'];
        @endphp
        <div class="layui-form-item container-fluid">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right">权限类型</label>
                <div class="col-sm-6" style="line-height: 35px;">
                    <div class="custom-control custom-radio custom-control-inline" style="line-height: 24px;">
                        <input lay-ignore v-model="access_type" type="radio" name="access_type" value="0"
                               @if(!$access_type) checked
                               @endif class="custom-control-input" id="access_type_0">
                        <label class="custom-control-label" for="access_type_0">角色权限</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline" style="line-height: 24px;">
                        <input lay-ignore v-model="access_type" type="radio" name="access_type" value="1"
                               @if($access_type) checked
                               @endif class="custom-control-input" id="access_type_1">
                        <label class="custom-control-label" for="access_type_1">直属权限</label>
                    </div>
                </div>
                <label class="col-sm-5 col-form-label text-muted pl-0"></label>
                @if ($errors->has('access_type'))
                    <div class="col-sm-1"></div>
                    <small class="col-sm-11 form-text text-warning">{{ $errors->first('access_type') }}</small>
                @endif
            </div>
        </div>
        @php
            $bs_role_ids=[];
            foreach ($admin->roles->toArray() as $v){
                $bs_role_ids[]=$v['id'];
            }
            $bs_role_ids=old('bs_role_ids')!==null?old('bs_role_ids'):$bs_role_ids;
        @endphp
        <div class="layui-form-item container-fluid" v-show="access_type=='0'">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right">角色权限</label>
                <div class="col-sm-11">
                    <div class="row">
                        <div class="col-sm-12" style="height: 32px;line-height: 32px;">
                            <div class="custom-control custom-checkbox" style="line-height: 24px;">
                                <input lay-ignore v-model="supperadmin" type="checkbox" name="bs_role_ids[]"
                                       value="{{$roles[0]['id']}}"
                                       @if(in_array($roles[0]['id'],$bs_role_ids)) checked
                                       @endif
                                       class="custom-control-input" id="bs_role_ids{{$roles[0]['id']}}">
                                <label class="custom-control-label"
                                       for="bs_role_ids{{$roles[0]['id']}}">{{$roles[0]['title']}}</label>
                            </div>
                        </div>
                        <label v-if="!supperadmin" class="col-sm-12 col-form-label text-muted">至少选择一位角色</label>
                    </div>
                    <div class="row" v-show="!supperadmin">
                        @foreach($roles as $k=>$v)
                            @if($k>0)
                                <div class="col-sm-3" style="height: 28px;line-height: 28px;">
                                    <div class="custom-control custom-checkbox" style="line-height: 24px;">
                                        <input lay-ignore type="checkbox" name="bs_role_ids[]" value="{{$v['id']}}"
                                               @if(in_array($v['id'],$bs_role_ids)) checked
                                               @endif
                                               class="custom-control-input" id="bs_role_ids{{$v['id']}}">
                                        <label class="custom-control-label"
                                               for="bs_role_ids{{$v['id']}}">{{$v['title']}}</label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if ($errors->has('bs_role_ids'))
                    <div class="col-sm-1"></div>
                    <small class="col-sm-11 form-text text-warning">{{ $errors->first('bs_role_ids') }}</small>
                @endif
            </div>
        </div>
        @php
            $bs_node_ids=(old('bs_node_ids')!==null || count($errors)>0)?(array)old('bs_node_ids'):array_ids($admin->nodes->toArray());
        @endphp
        <div class="layui-form-item container-fluid" v-show="access_type=='1'">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right">直属权限</label>
                <div class="col-sm-11" style="line-height: 35px;">
                    <div class="row">
                        <label class="col-sm-12 col-form-label text-muted">至少选择一个节点</label>
                        @foreach($nodes as $key=>$value)
                            <div class="col-sm-12">
                                <div class="custom-control custom-checkbox" style="line-height: 24px;">
                                    <input lay-ignore type="checkbox"
                                           class="custom-control-input" id="bs_node_ids{{$key}}" change1>
                                    <label class="custom-control-label"
                                           for="bs_node_ids{{$key}}">{{$value['title']}}</label>
                                </div>
                            </div>
                            @foreach($value['channel'] as $k=>$v)
                                @if($v['type']==0)
                                    <div class="col-sm-11" style="margin-left: 2%;">
                                        <div class="custom-control custom-checkbox" style="line-height: 24px;">
                                            <input lay-ignore type="checkbox" name="bs_node_ids[]" value="{{$v['node']['id']}}"
                                                   class="custom-control-input" @if(in_array($v['node']['id'],$bs_node_ids)) checked @endif id="bs_node_ids{{$v['node']['id']}}" change2 relate1="bs_node_ids{{$key}}">
                                            <label class="custom-control-label"
                                                   for="bs_node_ids{{$v['node']['id']}}">{{$v['node']['title']}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-11" style="margin-left: 4%;">
                                        <div class="row">
                                            @foreach($v['nodes'] as $i=>$n)
                                                <div class="float-left ml-sm-3 mr-sm-2">
                                                    <div class="custom-control custom-checkbox" style="line-height: 24px;">
                                                        <input lay-ignore type="checkbox" name="bs_node_ids[]" value="{{$n['id']}}"
                                                               class="custom-control-input" @if(in_array($n['id'],$bs_node_ids)) checked @endif id="bs_node_ids{{$n['id']}}" change3 relate1="bs_node_ids{{$key}}" relate2="bs_node_ids{{$v['node']['id']}}">
                                                        <label class="custom-control-label"
                                                               for="bs_node_ids{{$n['id']}}">{{$n['title']}}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    @foreach($v['list'] as $_k=>$_v)
                                        <div class="col-sm-11" style="margin-left: 2%;">
                                            <div class="custom-control custom-checkbox" style="line-height: 24px;">
                                                <input lay-ignore type="checkbox" name="bs_node_ids[]" value="{{$_v['node']['id']}}"
                                                       class="custom-control-input" @if(in_array($_v['node']['id'],$bs_node_ids)) checked @endif id="bs_node_ids{{$_v['node']['id']}}" change2 relate1="bs_node_ids{{$key}}">
                                                <label class="custom-control-label"
                                                       for="bs_node_ids{{$_v['node']['id']}}">{{$_v['title']}}-{{$_v['node']['title']}}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-11" style="margin-left: 4%;">
                                            <div class="row">
                                                @foreach($_v['nodes'] as $i=>$n)
                                                    <div class="float-left ml-sm-3 mr-sm-2">
                                                        <div class="custom-control custom-checkbox" style="line-height: 24px;">
                                                            <input lay-ignore type="checkbox" name="bs_node_ids[]" value="{{$n['id']}}"
                                                                   class="custom-control-input" @if(in_array($n['id'],$bs_node_ids)) checked @endif id="bs_node_ids{{$n['id']}}" change3 relate1="bs_node_ids{{$key}}" relate2="bs_node_ids{{$_v['node']['id']}}">
                                                            <label class="custom-control-label"
                                                                   for="bs_node_ids{{$n['id']}}">{{$n['title']}}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
                @if ($errors->has('bs_node_ids'))
                    <div class="col-sm-1"></div>
                    <small class="col-sm-11 form-text text-warning">{{ $errors->first('bs_node_ids') }}</small>
                @endif
            </div>
        </div>
        @php
            $status=old('status')!==null?old('status'):$admin['status'];
        @endphp
        <div class="layui-form-item container-fluid">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right">状态</label>
                <div class="col-sm-6" style="line-height: 35px;">
                    <div class="custom-control custom-radio custom-control-inline" style="line-height: 24px;">
                        <input lay-ignore type="radio" name="status" value="0" @if(!$status) checked
                               @endif class="custom-control-input" id="status_0">
                        <label class="custom-control-label" for="status_0">禁用</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline" style="line-height: 24px;">
                        <input lay-ignore type="radio" name="status" value="1" @if($status) checked
                               @endif class="custom-control-input" id="status_1">
                        <label class="custom-control-label" for="status_1">启用</label>
                    </div>
                </div>
                <label class="col-sm-5 col-form-label text-muted pl-0"></label>
                @if ($errors->has('status'))
                    <div class="col-sm-1"></div>
                    <small class="col-sm-11 form-text text-warning">{{ $errors->first('status') }}</small>
                @endif
            </div>
        </div>
        <div class="layui-form-item container-fluid">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-right"></label>
                <div class="col-sm-11">
                    <button type="submit" class="layui-btn">立即提交</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        require(['vue','jquery'], function (Vue,$) {
            new Vue({
                el: "#app",
                data: {
                    access_type: @if($access_type=='1') 1
                    @else 0 @endif,
                    supperadmin: @if(in_array($roles[0]['id'],$bs_role_ids)) true
                    @else false @endif
                }
            });
            $('body input[type="checkbox"][change1]').each(function () {
                var relate1=$(this).prop('id');
                var pix=false;
                $('body input[type="checkbox"][relate1="'+relate1+'"]').each(function () {
                    if($(this).prop('checked')){
                        pix=true;
                        return false;
                    }
                });
                if(pix){
                    $(this).prop('checked',true);
                }
            });
            $('body').on('change','input[type="checkbox"][change1]',function () {
                var relate1=$(this).prop('id');
                if($(this).prop('checked')){
                    $('body input[type="checkbox"][relate1="'+relate1+'"]').prop('checked',true);
                }else{
                    $('body input[type="checkbox"][relate1="'+relate1+'"]').prop('checked',false);
                }
            });
            $('body').on('change','input[type="checkbox"][change2]',function () {
                var relate2=$(this).prop('id');
                var relate1=$(this).attr('relate1');
                if($(this).prop('checked')){
                    $('body input[type="checkbox"][relate2="'+relate2+'"]').prop('checked',true);
                    $('#'+relate1).prop('checked',true);
                }else{
                    $('body input[type="checkbox"][relate2="'+relate2+'"]').prop('checked',false);
                    var pix=true;
                    $('body input[type="checkbox"][relate1="'+relate1+'"]').each(function () {
                        if($(this).prop('checked')){
                            pix=false;
                            return false;
                        }
                    });
                    if(pix){
                        $('#'+relate1).prop('checked',false);
                    }
                }
            });
            $('body').on('change','input[type="checkbox"][change3]',function () {
                var relate1=$(this).attr('relate1');
                var relate2=$(this).attr('relate2');
                if($(this).prop('checked')){
                    $('#'+relate1).prop('checked',true);
                    $('#'+relate2).prop('checked',true);
                }else{
                    var pix=true;
                    $('body input[type="checkbox"][relate1="'+relate1+'"]').each(function () {
                        if($(this).prop('checked')){
                            pix=false;
                            return false;
                        }
                    });
                    if(pix){
                        $('#'+relate1).prop('checked',false);
                    }
                }
            });
        });
    </script>
@endsection
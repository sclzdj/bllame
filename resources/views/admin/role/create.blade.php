@extends('layouts.master')
@section('content')
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>新增角色</legend>
    </fieldset>
    <form action="/admin/role/" method="post" class="layui-form">
        @csrf
        <div class="layui-form-item container-fluid">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right">名称</label>
                <div class="col-sm-6">
                    <input type="text" name="title" value="{{old('title')}}" placeholder="请输入名称"
                           class="form-control" autocomplete="off">
                </div>
                <label class="col-sm-5 col-form-label text-muted pl-0">
                    长度2-20位
                </label>
                @if ($errors->has('title'))
                    <div class="col-sm-1"></div>
                    <small class="col-sm-11 form-text text-warning">{{ $errors->first('title') }}</small>
                @endif
            </div>
        </div>
        <div class="layui-form-item container-fluid">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right">标识</label>
                <div class="col-sm-6">
                    <input type="text" name="name" value="{{old('name')}}" placeholder="请输入标识"
                           class="form-control" autocomplete="off">
                </div>
                <label class="col-sm-5 col-form-label text-muted pl-0">
                    长度2-20位，不支持中文和空格
                </label>
                @if ($errors->has('name'))
                    <div class="col-sm-1"></div>
                    <small class="col-sm-11 form-text text-warning">{{ $errors->first('name') }}</small>
                @endif
            </div>
        </div>
        @php
            $bs_node_ids=(array)old('bs_node_ids');
        @endphp
        <div class="layui-form-item container-fluid">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-sm-right">权限</label>
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
        <div class="layui-form-item container-fluid">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label text-right">状态</label>
                <div class="col-sm-6" style="line-height: 35px;">
                    <div class="custom-control custom-radio custom-control-inline" style="line-height: 24px;">
                        <input lay-ignore type="radio" name="status" value="0" @if(old('status')==='0') checked
                               @endif class="custom-control-input" id="status_0">
                        <label class="custom-control-label" for="status_0">禁用</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline" style="line-height: 24px;">
                        <input lay-ignore type="radio" name="status" value="1" @if(old('status')===null || old('status')) checked
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
        require(['jquery'],function ($) {
            @if(old('bs_node_ids')!==null)
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
            @endif
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
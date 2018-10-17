@extends('layouts.master')
@section('content')
    <form pjax class="layui-form layui-form-pane" action="/admin/admin">
        <div class="layui-btn-group">
            @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\AdminController@create'))
                <a href="/admin/admin/create" class="layui-btn" style="margin-bottom: 5px;margin-right: 5px;">新增账号</a>
            @endif
        </div>
        <div class="layui-form-item" style="float: right;">
            <div class="form-row">
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend from-search-size">
                            <div class="input-group-text"><span class="from-search-font-size">用户名</span></div>
                        </div>
                        <input type="text" name="username" value="{{$search['username']}}"
                               class="form-control from-search-size" placeholder="请输入关键词" autocomplete="off">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend from-search-size">
                            <div class="input-group-text"><span class="from-search-font-size">昵称</span></div>
                        </div>
                        <input type="text" name="nickname" value="{{$search['nickname']}}"
                               class="form-control from-search-size" placeholder="请输入关键词" autocomplete="off">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend from-search-size">
                            <div class="input-group-text"><span class="from-search-font-size">状态</span></div>
                        </div>
                        <select lay-ignore name="status" class="form-control from-search-size">
                            <option value="">全部</option>
                            <option value="1" @if($search['status']==='1') selected @endif>正常</option>
                            <option value="0" @if($search['status']==='0') selected @endif>关闭</option>
                        </select>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend from-search-size">
                            <div class="input-group-text"><span><span class="from-search-font-size">创建时间</span></span>
                            </div>
                        </div>
                        <input readonly type="text" name="created_at_start" value="{{$search['created_at_start']}}"
                               id="created_at_start" class="form-control from-search-size austom-readonly"
                               placeholder="开始日期" autocomplete="off" style="width: 100px;">
                        <div class="input-group-prepend from-search-size">
                            <div class="input-group-text" style="border-left: none;"><span
                                        class="from-search-font-size">-</span></div>
                        </div>
                        <input readonly type="text" name="created_at_end" value="{{$search['created_at_end']}}"
                               id="created_at_end" class="form-control from-search-size austom-readonly"
                               placeholder="结束日期" autocomplete="off" style="width: 100px;">
                    </div>
                    <script>
                        require(['function'], function () {
                            laydate_range();
                        });
                    </script>
                </div>
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <button class="layui-btn" type="submit">搜&nbsp;索</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <table class="layui-table">
        <colgroup>
            <col>
            <col>
            <col>
            <col>
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>
                <div class="custom-control custom-checkbox" style="line-height: 24px;">
                    <input lay-ignore v-model="table_all" v-on:change="totalChecked($event)" type="checkbox"
                           class="custom-control-input" id="all_ids">
                    <label class="custom-control-label" for="all_ids">ID</label>
                </div>
            </th>
            <th>用户名</th>
            <th>权限</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <script>
            var DATA_IDS = [];
        </script>
        @foreach($admins as $v)
            <script>
                DATA_IDS.push("{{$v['id']}}");
            </script>
            <tr>
                <td>
                    <div class="custom-control custom-checkbox" style="line-height: 24px;">
                        <input lay-ignore v-model="table_ids" v-on:change="childChecked($event)" name="ids[]"
                               value="{{$v['id']}}" type="checkbox" class="custom-control-input" id="id{{$v['id']}}">
                        <label class="custom-control-label" for="id{{$v['id']}}">{{$v['id']}}</label>
                    </div>
                </td>
                <td>{{$v['username']}}</td>
                <td>
                    @if($v['access_type']=='1')
                        <span style="">直属权限</span>
                    @else
                        @if(in_array('1',array_ids($v->roles->toArray())))
                            <span style="color: #0c5460;font-weight: bold;">超级管理员</span>
                        @else
                            <span style="color: #0c5460;">角色权限</span>
                        @endif
                    @endif
                </td>
                <td>
                    @if($v['status']=='1')
                        <span class="text-success">正常</span>
                    @else
                        <span class="text-warning">关闭</span>
                    @endif
                </td>
                <td>{{$v['created_at']}}</td>
                <td>
                    <div class="layui-btn-group">
                        @if($v['id']>1)
                            @if($v['status']=='1')
                                @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\AdminController@disable'))
                                    <a href="javascript:void(0);" onclick="disable_form{{$v['id']}}.submit();"
                                       class="layui-btn layui-btn-sm layui-btn-warm">禁用</a>
                                    <form action="/admin/admin/disable/{{$v['id']}}" method="post"
                                          name="disable_form{{$v['id']}}" style="display: none;">
                                        @csrf @method('PATCH')
                                    </form>
                                @endif
                            @else
                                @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\AdminController@enable'))
                                    <a href="javascript:void(0);" onclick="enable_form{{$v['id']}}.submit();"
                                       class="layui-btn layui-btn-sm  layui-btn-success">启用</a>
                                    <form action="/admin/admin/enable/{{$v['id']}}" method="post"
                                          name="enable_form{{$v['id']}}" style="display: none;">
                                        @csrf @method('PATCH')
                                    </form>
                                @endif
                            @endif
                            @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\AdminController@show'))
                                <a href="/admin/admin/{{$v['id']}}" class="layui-btn layui-btn-sm layui-btn-normal">详情</a>
                            @endif
                            @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\AdminController@edit'))
                                <a href="/admin/admin/{{$v['id']}}/edit" class="layui-btn layui-btn-sm">修改</a>
                            @endif
                            @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\AdminController@destroy'))
                                <a href="javascript:void(0);" onclick="delete_form{{$v['id']}}.submit();"
                                   class="layui-btn layui-btn-sm layui-btn-danger">删除</a>
                                <form action="/admin/admin/{{$v['id']}}" method="post"
                                      name="delete_form{{$v['id']}}"
                                      style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            @endif
                        @else
                            <button type="button" class="layui-btn layui-btn-sm layui-btn-disabled">不可操作</button>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="layui-btn-group">
        @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\AdminController@enable'))
            <a href="javascript:void(0);" onclick="enable_form0.submit();"
               class="layui-btn layui-btn-sm layui-btn-success">批量启用</a>
            <form action="/admin/admin/enable/0" method="post" name="enable_form0" style="display: none;">
                <input type="text" name="ids" v-model="table_ids">
                @csrf @method('PATCH')
            </form>
        @endif
        @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\AdminController@disable'))
            <a href="javascript:void(0);" onclick="disable_form0.submit();"
               class="layui-btn layui-btn-sm layui-btn-warm">批量禁用</a>
            <form action="/admin/admin/disable/0" method="post" name="disable_form0" style="display: none;">
                <input type="text" name="ids" v-model="table_ids">
                @csrf @method('PATCH')
            </form>
        @endif
        @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\AdminController@destroy'))
            <a href="javascript:void(0);" onclick="delete_form0.submit();"
               class="layui-btn layui-btn-sm layui-btn-danger">批量删除</a>
            <form action="/admin/admin/0" method="post" name="delete_form0" style="display: none;">
                <input type="text" name="ids" v-model="table_ids">
                @csrf @method('DELETE')
            </form>
        @endif
    </div>
    <div class="layui-btn-group" style="float: right;">
        {{$admins->links()}}
    </div>
    <script>
        require(['vue', 'jquery'], function (Vue, $) {
            new Vue({
                el: '#app',
                data: {
                    table_all: false,
                    table_ids: []
                },
                methods: {
                    totalChecked: function (event) {
                        if (event.target.checked) {
                            this.table_ids = DATA_IDS;
                        } else {
                            this.table_ids = [];
                        }
                    },
                    childChecked: function (event) {
                        if (event.target.checked) {
                            if (this.table_ids.length == DATA_IDS.length) {
                                this.table_all = true;
                            }
                        } else {
                            this.table_all = false;
                        }
                    }
                }
            });
        });
    </script>
@endsection
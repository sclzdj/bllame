@extends('layouts.master')
@section('content')
    <form pjax class="layui-form layui-form-pane" action="/admin/role">
        <div class="layui-btn-group">
            @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\RoleController@create'))
                <a href="/admin/role/create" class="layui-btn" style="margin-bottom: 5px;margin-right: 5px;">新增角色</a>
            @endif
        </div>
        <div class="layui-form-item" style="float: right;">
            <div class="form-row">
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend from-search-size">
                            <div class="input-group-text"><span class="from-search-font-size">名称</span></div>
                        </div>
                        <input type="text" name="title" value="{{$search['title']}}"
                               class="form-control from-search-size" placeholder="请输入关键词" autocomplete="off">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend from-search-size">
                            <div class="input-group-text"><span class="from-search-font-size">标识</span></div>
                        </div>
                        <input type="text" name="name" value="{{$search['name']}}"
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
            <th>名称</th>
            <th>标识</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <script>
            var DATA_IDS = [];
        </script>
        @foreach($roles as $v)
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
                <td>{{$v['title']}}</td>
                <td>{{$v['name']}}</td>
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
                                @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\RoleController@disable'))
                                    <a href="javascript:void(0);" onclick="disable_form{{$v['id']}}.submit();"
                                       class="layui-btn layui-btn-sm layui-btn-warm">禁用</a>
                                    <form action="/admin/role/disable/{{$v['id']}}" method="post"
                                          name="disable_form{{$v['id']}}" style="display: none;">
                                        @csrf @method('PATCH')
                                    </form>
                                @endif
                            @else
                                @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\RoleController@enable'))
                                    <a href="javascript:void(0);" onclick="enable_form{{$v['id']}}.submit();"
                                       class="layui-btn layui-btn-sm  layui-btn-success">启用</a>
                                    <form action="/admin/role/enable/{{$v['id']}}" method="post"
                                          name="enable_form{{$v['id']}}" style="display: none;">
                                        @csrf @method('PATCH')
                                    </form>
                                @endif
                            @endif
                            @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\RoleController@show'))
                                <a href="/admin/role/{{$v['id']}}"
                                   class="layui-btn layui-btn-sm layui-btn-normal">详情</a>
                            @endif
                            @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\RoleController@edit'))
                                <a href="/admin/role/{{$v['id']}}/edit" class="layui-btn layui-btn-sm">修改</a>
                            @endif
                            @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\RoleController@destroy'))
                                <a href="javascript:void(0);" onclick="delete_form{{$v['id']}}.submit();"
                                   class="layui-btn layui-btn-sm layui-btn-danger">删除</a>
                                <form action="/admin/role/{{$v['id']}}" method="post"
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
        @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\RoleController@enable'))
                <a href="javascript:void(0);" onclick="enable_form0.submit();"
                   class="layui-btn layui-btn-sm layui-btn-success">批量启用</a>
                <form action="/admin/role/enable/0" method="post" name="enable_form0" style="display: none;">
                    <input type="text" name="ids" v-model="table_ids">
                    @csrf @method('PATCH')
                </form>
            @endif
            @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\RoleController@disable'))
                <a href="javascript:void(0);" onclick="disable_form0.submit();"
                   class="layui-btn layui-btn-sm layui-btn-warm">批量禁用</a>
                <form action="/admin/role/disable/0" method="post" name="disable_form0" style="display: none;">
                    <input type="text" name="ids" v-model="table_ids">
                    @csrf @method('PATCH')
                </form>
            @endif
            @if(\App\Servers\PermissionServer::isAccessAction('App\\Http\\Controllers\\Admin\\RoleController@destroy'))
                <a href="javascript:void(0);" onclick="delete_form0.submit();"
                   class="layui-btn layui-btn-sm layui-btn-danger">批量删除</a>
                <form action="/admin/role/0" method="post" name="delete_form0" style="display: none;">
                    <input type="text" name="ids" v-model="table_ids">
                    @csrf @method('DELETE')
                </form>
            @endif
    </div>
    <div class="layui-btn-group" style="float: right;">
        {{$roles->links()}}
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
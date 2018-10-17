@extends('layouts.master')
@section('content')
    <script>
        require(['jquery-ui']);
    </script>
    <div class="row">
        @foreach($nodes as $key=>$value)
            <div class="col-sm-12 node-item-1">
                <div class="card" style="">
                    <div class="card-header card-header-1" style="cursor: move;">
                        <div class="btn-group float-left" role="group">
                            <span class="form-control-plaintext">{{$value['title']}}</span>
                        </div>
                        <div class="btn-group float-right" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">增加子节点</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">修改</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">删除</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row node-item-2">
                            @foreach($value['channel'] as $k=>$v)
                                @if($v['type']==0)
                                    <div class="col-lg-4">
                                        <div class="card mb-2">
                                            <div class="card-header card-header-2" style="cursor: move;">
                                                <div class="btn-group float-left" role="group">
                                                    <span class="form-control-plaintext">{{$v['node']['title']}}</span>
                                                </div>
                                                <div class="btn-group float-right" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">增加子节点
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">修改
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">删除
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group node-item-3">
                                                    @foreach($v['nodes'] as $i=>$n)
                                                        <li class="list-group-item" style="cursor: move;">
                                                            <div class="btn-group float-left" role="group">
                                                                <span class="form-control-plaintext">{{$n['title']}}</span>
                                                            </div>
                                                            <div class="btn-group float-right" role="group">
                                                                <button type="button"
                                                                        class="btn btn-sm btn-outline-secondary">修改
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-sm btn-outline-secondary">删除
                                                                </button>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @foreach($v['list'] as $_k=>$_v)
                                        <div class="col-lg-4">
                                            <div class="card mb-2">
                                                <div class="card-header card-header-2" style="cursor: move;">
                                                    <div class="btn-group float-left" role="group">
                                                        <span class="form-control-plaintext">{{$_v['title']}}
                                                            -{{$_v['node']['title']}}</span>
                                                    </div>
                                                    <div class="btn-group float-right" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary">
                                                            增加子节点
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary">
                                                            修改
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary">
                                                            删除
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group node-item-3">
                                                        @foreach($_v['nodes'] as $i=>$n)
                                                            <li class="list-group-item" style="cursor: move;">
                                                                <div class="btn-group float-left" role="group">
                                                                    <span class="form-control-plaintext">{{$n['title']}}</span>
                                                                </div>
                                                                <div class="btn-group float-right" role="group">
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-outline-secondary">修改
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-outline-secondary">删除
                                                                    </button>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script>
        require(['jquery-ui'], function () {
            $(function () {
                $(".node-item-3").sortable();
                $(".node-item-3").disableSelection();
                $(".node-item-2").sortable({handle: ".card-header-2"});
                $(".node-item-2").disableSelection();
                $(".node-item-1").sortable({handle: ".card-header-1"});
                $(".node-item-1").disableSelection();
            });
        });
    </script>
@endsection
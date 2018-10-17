<?php

$helpers = [
    'functions.php'
];

// 载入
foreach ($helpers as $v) {
    include __DIR__ . '/' .$v;
}

function mca(){
    if(!defined('ROUTE_ACTION')){
        if(isset(request()->route()->getAction()['uses'])){
            define('ROUTE_ACTION',request()->route()->getAction()['uses']);
        }else{
            define('ROUTE_ACTION',false);
        }
    }
    return ROUTE_ACTION;
}
function mca_parent(){
    $mca=mca();
    $mc=explode('@',$mca)[0];
    $channel=config('channel');
    $mca_parent='';
    foreach ($channel as $key=>$value){
        foreach ($value['channel'] as $k=>$v){
            if($v['type']==0){
                if($mc==$v['controller']){
                    $mca_parent=$v['uses'];
                    break 2;
                }
            }else{
                foreach ($v['list'] as $_k=>$_v){
                    if($mc==$_v['controller']){
                        $mca_parent=$_v['uses'];
                        break 3;
                    }
                }
            }
        }
    }
    if(!defined('ROUTE_PARENT_ACTION')){
        define('ROUTE_PARENT_ACTION',$mca_parent);
    }
    return ROUTE_PARENT_ACTION;
}

function mca_detail(){
    if(!defined('ROUTE_ACTION')){
        if(isset(request()->route()->getAction()['uses'])){
            define('ROUTE_ACTION',request()->route()->getAction()['uses']);
        }else{
            define('ROUTE_ACTION',false);
        }
    }
    $mca=explode('@',ROUTE_ACTION);
    $a=$mca[1];
    $mc=substr($mca[0],21);
    $mc=explode("\\",$mc);
    $m=strtolower($mc[0]);
    unset($mc[0]);
    $c=implode('\\',$mc);
    $c=substr($c,0,-10);
    $c=strtolower($c);
    $detail=compact('m','c','a');
    return $detail;
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/13
 * Time: 22:39
 */

namespace App\Servers;


class MenuServer //还需做权限验证和高亮处理
{
    public static function getHomeUrl()
    {
        $channels=self::getChannels();
        if(isset($channels[0])){
            return $channels[0]['url'];
        }
        return '/admin/index/index';
    }
    
    public static function getChannels()
    {
        $menus = config('menu');
        $channels=[];
        $mca_detail=mca_detail();
        foreach ($menus as $key=>$value){
            if($mca_detail['m']===strtolower($key)){
                $active='1';
            }else{
                $active='0';
            }
            $child=self::getMenusBy($key);
            if($child['channel']){
                $channels[]=[
                    'name'=>$key,
                    'title'=>$value['title'],
                    'url'=>$child['url'],
                    'active'=>$active,
                ];
            }
        }
        
        return $channels;
    }
    
    public static function getCurrentMenus()
    {
        $menus = config('menu');
        $channels=ucfirst(strtolower(mca_detail()['m']));
        if(isset($menus[$channels]['channel'])){
            $channel = $menus[$channels]['channel'];
            $mca=mca();
            $mca_parent=mca_parent();
            foreach ($channel as $k=>$v){
                if($v['type']==0){
                    if(PermissionServer::isAccessAction($v['uses'])){
                        if($v['uses']==$mca || $v['uses']==$mca_parent){
                            $channel[$k]['active']='1';
                        }else{
                            $channel[$k]['active']='0';
                        }
                    }else{
                        unset($channel[$k]);
                    }
                }else{
                    $channel[$k]['open']='0';
                    foreach ($v['list'] as $_k=>$_v){
                        if(PermissionServer::isAccessAction($_v['uses'])){
                            if($_v['uses']==$mca || $_v['uses']==$mca_parent){
                                $channel[$k]['list'][$_k]['active']='1';
                                $channel[$k]['open']='1';
                            }else{
                                $channel[$k]['list'][$_k]['active']='0';
                            }
                        }else{
                            unset($channel[$k]['list'][$_k]);
                        }
                    }
                    if(!$channel[$k]['list']){
                        unset($channel[$k]);
                    }
                }
            }
        }else{
            $channel=[];
        }
        return $channel;
    }
    
    public static function getMenusBy($m='')
    {
        $menus = config('menu');
        if($m==''){
            $m=ucfirst(strtolower(mca_detail()['m']));//需处理
        }
        $url='/admin/index/index';
        $url_status=true;
        if(isset($menus[$m]['channel'])){
            $channel = $menus[$m]['channel'];
            $mca=mca();
            $mca_parent=mca_parent();
            foreach ($channel as $k=>$v){
                if($v['type']==0){
                    if(PermissionServer::isAccessAction($v['uses'])){
                        if($url_status){
                            $url=$v['url'];
                            $url_status=false;
                        }
                        if($v['uses']==$mca || $v['uses']==$mca_parent){
                            $channel[$k]['active']='1';
                        }else{
                            $channel[$k]['active']='0';
                        }
                    }else{
                        unset($channel[$k]);
                    }
                }else{
                    foreach ($v['list'] as $_k=>$_v){
                        if(PermissionServer::isAccessAction($_v['uses'])){
                            if($url_status){
                                $url=$_v['url'];
                                $url_status=false;
                            }
                            if($_v['uses']==$mca || $_v['uses']==$mca_parent){
                                $channel[$k]['list'][$_k]['active']='1';
                            }else{
                                $channel[$k]['list'][$_k]['active']='0';
                            }
                        }else{
                            unset($channel[$k]['list'][$_k]);
                        }
                    }
                    if(!$channel[$k]['list']){
                        unset($channel[$k]);
                    }
                }
            }
        }else{
            $channel=[];
        }
        return [
            'channel'=>$channel,
            'url'=>$url,
        ];
    }
    
    public static function getMenus($channels = '')
    {
        $menus = config('menu');
        if ($channels) {
            if(isset($menus[$channels]['channel'])){
                $menus = $menus[$channels]['channel'];
            }else{
                $menus=[];
            }
        }
        
        return $menus;
    }
}
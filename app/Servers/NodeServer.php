<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/14
 * Time: 14:37
 */

namespace App\Servers;


use App\Model\Admin\Node;

class NodeServer
{
    public static function channel($module)
    {
        $channel=config('channel');
        return $channel[$module];
    }
    public static function tree()
    {
        $channel=config('channel');
        $node_ids=PermissionServer::getAccessNode();
        $node_ids=json_decode($node_ids,true);
        foreach ($channel as $key=>$value){
            $pix=false;
            foreach ($value['channel'] as $k=>$v){
                $p=false;
                if($v['type']==0){
                    if(SUPPERADMIN){
                        $node=Node::where('uses',$v['uses'])->first();
                    }else{
                        $node=Node::whereIn('id',$node_ids)->where('uses',$v['uses'])->first();
                    }
                    if($node){
                        $pix=true;
                        $p=true;
                        $channel[$key]['channel'][$k]['node']=$node;
                        if(SUPPERADMIN){
                            $nodes=Node::where('uses','<>',$v['uses'])->where('controller',$v['controller'])->orderBy('sort','asc')->get()->toArray();
                        }else{
                            $nodes=Node::whereIn('id',$node_ids)->where('uses','<>',$v['uses'])->where('controller',$v['controller'])->orderBy('sort','asc')->get()->toArray();
                        }
                        if($nodes){
                            $channel[$key]['channel'][$k]['nodes']=$nodes;
                        }else{
                            $channel[$key]['channel'][$k]['nodes']=[];
                        }
                    }
                }else{
                    foreach ($v['list'] as $_k=>$_v){
                        $_p=false;
                        if(SUPPERADMIN){
                            $node=Node::where('uses',$_v['uses'])->first();
                        }else{
                            $node=Node::whereIn('id',$node_ids)->where('uses',$_v['uses'])->first();
                        }
                        if($node){
                            $pix=true;
                            $p=true;
                            $_p=true;
                            $channel[$key]['channel'][$k]['list'][$_k]['node']=$node;
                            if(SUPPERADMIN){
                                $nodes=Node::where('uses','<>',$_v['uses'])->where('controller',$_v['controller'])->orderBy('sort','asc')->get()->toArray();
                            }else{
                                $nodes=Node::whereIn('id',$node_ids)->where('uses','<>',$_v['uses'])->where('controller',$_v['controller'])->orderBy('sort','asc')->get()->toArray();
                            }
                            if($nodes){
                                $channel[$key]['channel'][$k]['list'][$_k]['nodes']=$nodes;
                            }else{
                                $channel[$key]['channel'][$k]['list'][$_k]['nodes']=[];
                            }
                        }
                        if(!$_p){
                            unset($channel[$key]['channel'][$k]['list'][$_k]);
                        }
                    }
                }
                if(!$p){
                    unset($channel[$key]['channel'][$k]);
                }
            }
            if(!$pix){
                unset($channel[$key]);
            }
        }
        return $channel;
    }
}
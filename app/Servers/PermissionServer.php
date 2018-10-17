<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/14
 * Time: 22:52
 */

namespace App\Servers;


use App\Model\Admin\Admin;
use App\Model\Admin\Node;

class PermissionServer
{
    public static function base()
    {
        if(!defined('ADMIN_ID')){
            define('ADMIN_ID',auth('admin')->id());
        }
        if(!defined('SUPPERADMIN')) {
            if (ADMIN_ID == '1') {
                define('SUPPERADMIN', true);
            } else {
                $admin = Admin::where('id', ADMIN_ID)->first();
                if ($admin) {
                    if ($admin['access_type'] == '1') {
                        define('SUPPERADMIN', false);
                    } else {
                        $roles    = $admin->roles->toArray();
                        $role_ids = array_ids($roles);
                        if (in_array('1', $role_ids)) {
                            define('SUPPERADMIN', true);
                        }else{
                            define('SUPPERADMIN', false);
                        }
                    }
                } else {
                    define('SUPPERADMIN', false);
                }
            }
        }
    }
    //查看当前用户所有权限节点（返回json）
    public static function getAccessNode(){
        self::base();
        if(defined('ACCESS_NODE')){
            return ACCESS_NODE;
        }
        if(SUPPERADMIN){
            define('ACCESS_NODE',false);
            return false;
        }
        $admin_id=ADMIN_ID;
        $admin=Admin::where('id',$admin_id)->first();
        if(!$admin){
            define('ACCESS_NODE',false);
            return false;
        }
        if($admin['access_type']=='1'){
            $nodes=$admin->nodes->toArray();
            $node_ids=array_ids($nodes);
        }else{
            $roles=$admin->roles->where('status','1')->toArray();
            $role_ids=array_ids($roles);
            if(in_array('1',$role_ids)){
                define('ACCESS_NODE',false);
                return false;
            }
            $access=\DB::table('bs_access')->select('bs_node_id')->distinct()->whereIn('bs_role_id',$role_ids)->get()->toJson();
            $access=json_decode($access,true);
            $node_ids=array_ids($access,'bs_node_id');
        }
        $node_ids=json_encode($node_ids);
        define('ACCESS_NODE',$node_ids);
        return ACCESS_NODE;
    }
    //查看用户所有权限节点（返回json）
    public static function getAccessNodeBy($admin_id=''){
        self::base();
        if($admin_id==''){
            return self::getAccessNode();
        }
        if($admin_id==1){
            return false;
        }
        $admin=Admin::where('id',$admin_id)->first();
        if(!$admin){
            return false;
        }
        if($admin['access_type']=='1'){
            $nodes=$admin->nodes->toArray();
            $node_ids=array_ids($nodes);
        }else{
            $roles=$admin->roles->where('status','1')->toArray();
            $role_ids=array_ids($roles);
            if(in_array('1',$role_ids)){
                return false;
            }
            $access=\DB::table('bs_access')->select('bs_node_id')->distinct()->whereIn('bs_role_id',$role_ids)->get()->toJson();
            $access=json_decode($access,true);
            $node_ids=array_ids($access,'bs_node_id');
        }
        $node_ids=json_encode($node_ids);
        return $node_ids;
    }
    //查看当前用户所有权限方法（返回json）
    public static function getAccess(){
        self::base();
        if(defined('ACCESS_ACTION')){
            return ACCESS_ACTION;
        }
        $node_ids=self::getAccessNode();
        if($node_ids===false){
            define('ACCESS_ACTION',false);
            return false;
        }
        $node_ids=json_decode($node_ids,true);
        $nodes=Node::whereIn('id',$node_ids)->get();
        $actions=[];
        foreach ($nodes as $v){
            $actions[]=$v['uses'];
            if($v['relates']){
                $actions=array_merge($actions,explode(PHP_EOL,$v['relates']));
            }
        }
        $actions=json_encode($actions);
        define('ACCESS_ACTION',$actions);
        return $actions;
    }
    //查看用户所有权限方法（返回json）
    public static function getAccessBy($admin_id=''){
        self::base();
        if($admin_id==''){
            $node_ids=self::getAccessNode();
        }else{
            $node_ids=self::getAccessNodeBy($admin_id);
        }
        if($node_ids===false){
            return false;
        }
        $node_ids=json_decode($node_ids,true);
        $nodes=Node::whereIn('id',$node_ids)->get();
        $actions=[];
        foreach ($nodes as $v){
            $actions[]=$v['uses'];
            if($v['relates']){
                $actions=array_merge($actions,explode(PHP_EOL,$v['relates']));
            }
        }
        $actions=json_encode($actions);
        return $actions;
    }
    //当前用户能否访问当前方法（返回boolean）
    public static function isAccess(){
        self::base();
        if(SUPPERADMIN){
            return true;
        }else{
            $actions=self::getAccess();
            $actions=json_decode($actions,true);
            $mca=mca();
            if(in_array($mca,$actions)){
                return true;
            }else{
                return false;
            }
        }
    }
    //当前用户能否访问某个方法（返回boolean）
    public static function isAccessAction($action=''){
        self::base();
        if(SUPPERADMIN){
            return true;
        }
        if($action==''){
            return self::isAccess();
        }else{
            $actions=self::getAccess();
            $actions=json_decode($actions,true);
            if(in_array($action,$actions)){
                return true;
            }else{
                return false;
            }
        }
    }
    //某个用户能否访问当前方法（返回boolean）
    public static function isAccessAdmin($admin_id=''){
        self::base();
        if(SUPPERADMIN){
            return true;
        }
        if($admin_id==''){
            return self::isAccess();
        }else{
            $actions=self::getAccessBy($admin_id);
            $actions=json_decode($actions,true);
            $mca=mca();
            if(in_array($mca,$actions)){
                return true;
            }else{
                return false;
            }
        }
    }
    //某个用户能否访问某个方法（返回boolean）
    public static function isAccessBy($admin_id='',$action=''){
        self::base();
        if(SUPPERADMIN){
            return true;
        }
        if($admin_id=='' && $action==''){
            return self::isAccess();
        }elseif($admin_id=='' || $action!=''){
            $actions=self::getAccess();
            $actions=json_decode($actions,true);
            if(in_array($action,$actions)){
                return true;
            }else{
                return false;
            }
        }elseif($admin_id!='' || $action==''){
            $actions=self::getAccessBy($admin_id);
            $actions=json_decode($actions,true);
            if(in_array($action,$actions)){
                return true;
            }else{
                return false;
            }
        }
    }
}
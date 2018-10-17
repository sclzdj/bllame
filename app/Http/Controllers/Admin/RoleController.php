<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RoleRequest;
use App\Model\Admin\Node;
use App\Model\Admin\Role;
use App\Servers\NodeServer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Role $role)
    {
        $search = [
            'title'         => (string)$request['title'],
            'name'         => (string)$request['name'],
            'status'           => (string)$request['status'],
            'created_at_start' => (string)$request['created_at_start'],
            'created_at_end'   => (string)$request['created_at_end'],
        ];
        $where  = [];
        if ($search['title'] !== '') {
            $where[] = ['title', 'like', '%' . $search['title'] . '%'];
        }
        if ($search['name'] !== '') {
            $where[] = ['name', 'like', '%' . $search['name'] . '%'];
        }
        if ($search['status'] !== '') {
            $where[] = ['status', '=', $search['status']];
        }
        if ($search['created_at_start'] !== ''
            && $search['created_at_end'] !== ''
        ) {
            $where[] = ['created_at', '>=',
                        $search['created_at_start'] . " 00:00:00"];
            $where[] = ['created_at', '<=',
                        $search['created_at_end'] . " 23:59:59"];
        } elseif ($search['created_at_start'] === ''
            && $search['created_at_end'] !== ''
        ) {
            $where[] = ['created_at', '<=',
                        $search['created_at_end'] . " 23:59:59"];
        } elseif ($search['created_at_start'] !== ''
            && $search['created_at_end'] === ''
        ) {
            $where[] = ['created_at', '>=',
                        $search['created_at_start'] . " 00:00:00"];
        }
        $roles = $role->where($where)->paginate(config('custom.pageSize'));
    
        return view('admin/role/index', compact('roles', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nodes=NodeServer::tree();
        return view('admin/role/create', compact('nodes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request,Role $role)
    {
        $role->fill($request->all());
        $role->save();
        $id = \DB::getPdo()->lastInsertId();
        $date = date('Y-m-d H:i:s');
        foreach ($request->bs_node_ids as $v){
            \DB::table('bs_access')->insert([
                'bs_role_id'=>$id,
                'bs_node_id'=>$v,
                'created_at'=>$date,
                'updated_at'=>$date,
            ]);
        }
    
        return redirect('admin/role')->with('success', '新增成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if($role->id==1){
            return redirect('admin/role')->with('danger', '非法操作');
        }
        $nodes=NodeServer::tree();
    
        return view('admin/role/edit', compact('role', 'nodes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        if($role->id==1){
            return redirect('admin/role')->with('danger', '非法操作');
        }
        $role->fill($request->all());
        $role->save();
        $date = date('Y-m-d H:i:s');
        if(SUPPERADMIN){
            \DB::table('bs_access')->where('bs_role_id', $role->id)->delete();
        }else{
            \DB::table('bs_access')->whereIn('bs_node_id',$request->bs_node_ids)->where('bs_role_id', $role->id)->delete();
        }
        foreach ($request->bs_node_ids as $v){
            \DB::table('bs_access')->insert([
                'bs_role_id'=>$role->id,
                'bs_node_id'=>$v,
                'created_at'=>$date,
                'updated_at'=>$date,
            ]);
        }
        return redirect('admin/role')->with('success', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if ($id > 0) {
            if ($id > 1) {
                Role::where('id',$id)->delete();
                \DB::table('bs_access')->where('bs_role_id', $id)->delete();
                \DB::table('bs_personates')->where('bs_role_id', $id)->delete();
                return redirect('admin/role')->with('success', '删除成功');
            } else {
                return redirect('admin/role')->with('danger', '非法操作');
            }
        } else {
            $ids=is_array($request->ids)?$request->ids:explode(',',$request->ids);
            Role::where('id','<>','1')->whereIn('id',$ids)->delete();
            \DB::table('bs_access')->where('bs_role_id','<>','1')->whereIn('bs_role_id',$ids)->delete();
            \DB::table('bs_personates')->where('bs_role_id','<>','1')->whereIn('bs_role_id',$ids)->delete();
            return redirect('admin/role')->with('success', '批量删除成功');
        }
    }
    
    public function enable($id, Request $request)
    {
        if ($id>0) {
            if ($id > 1) {
                Role::where('id',$id)->update(['status'=>'1']);
                return redirect('admin/role')->with('success', '启用成功');
            } else {
                return redirect('admin/role')->with('danger', '非法操作');
            }
        } else {
            $ids=is_array($request->ids)?$request->ids:explode(',',$request->ids);
            Role::where('id','<>','1')->whereIn('id',$ids)->update(['status'=>'1']);
            return redirect('admin/role')->with('success', '批量启用成功');
        }
    }
    
    public function disable($id, Request $request)
    {
        if ($id>0) {
            if ($id > 1) {
                Role::where('id',$id)->update(['status'=>'0']);
                return redirect('admin/role')->with('success', '禁用成功');
            } else {
                return redirect('admin/role')->with('danger', '非法操作');
            }
        } else {
            $ids=is_array($request->ids)?$request->ids:explode(',',$request->ids);
            Role::where('id','<>','1')->whereIn('id',$ids)->update(['status'=>'0']);
            return redirect('admin/role')->with('success', '批量禁用成功');
        }
    }
}

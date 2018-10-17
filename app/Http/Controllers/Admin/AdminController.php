<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminRequest;
use App\Model\Admin\Admin;
use App\Model\Admin\Node;
use App\Model\Admin\Role;
use App\Servers\NodeServer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Admin $admin)
    {
        $search = [
            'username'         => (string)$request['username'],
            'nickname'         => (string)$request['nickname'],
            'status'           => (string)$request['status'],
            'created_at_start' => (string)$request['created_at_start'],
            'created_at_end'   => (string)$request['created_at_end'],
        ];
        $where  = [];
        if ($search['username'] !== '') {
            $where[] = ['username', 'like', '%' . $search['username'] . '%'];
        }
        if ($search['nickname'] !== '') {
            $where[] = ['nickname', 'like', '%' . $search['nickname'] . '%'];
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
        $admins = $admin->where($where)->paginate(config('custom.pageSize'));
        
        return view('admin/admin/index', compact('admins', 'search'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role)
    {
        $roles = $role->get();
        $nodes=NodeServer::tree();
        
        return view('admin/admin/create', compact('roles','nodes'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request, Admin $admin)
    {
        $request->password = bcrypt($request->password);
        $admin->fill($request->all());
        $admin->save();
        $id = \DB::getPdo()->lastInsertId();
        //权限处理
        $date = date('Y-m-d H:i:s');
        if ($request->access_type == '1') {
            foreach ($request->bs_node_ids as $v){
                \DB::table('bs_belongs')->insert([
                    'bs_admin_id'=>$id,
                    'bs_node_id'=>$v,
                    'created_at'=>$date,
                    'updated_at'=>$date,
                ]);
            }
        } else {
            if ( ! in_array('1', $request->bs_role_ids)) {
                foreach ($request->bs_role_ids as $v) {
                    \DB::table('bs_personates')->insert(
                        [
                            'bs_admin_id' => $id,
                            'bs_role_id'  => $v,
                            'created_at'  => $date,
                            'updated_at'  => $date,
                        ]
                    );
                }
            } else {
                \DB::table('bs_personates')->insert(
                    [
                        'bs_admin_id' => $id,
                        'bs_role_id'  => '1',
                        'created_at'  => $date,
                        'updated_at'  => $date,
                    ]
                );
            }
        }
        
        return redirect('admin/admin')->with('success', '新增成功');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin, Role $role)
    {
        if($admin->id==1){
            return redirect('admin/admin')->with('danger', '非法操作');
        }
        $roles = $role->get();
        $nodes=NodeServer::tree();
        
        return view('admin/admin/edit', compact('admin', 'roles','nodes'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        if($admin->id==1){
            return redirect('admin/admin')->with('danger', '非法操作');
        }
        if ($request->password) {
            $request->password = bcrypt($request->password);
            $admin->fill($request->all());
        } else {
            $admin->username    = $request->username;
            $admin->nickname    = $request->nickname;
            $admin->access_type = $request->access_type;
            $admin->status      = $request->status;
        }
        $admin->save();
        //权限处理
        $date = date('Y-m-d H:i:s');
        \DB::table('bs_personates')->where('bs_admin_id', $admin->id)->delete();
        if(SUPPERADMIN){
            \DB::table('bs_belongs')->where('bs_admin_id', $admin->id)->delete();
        }else{
            \DB::table('bs_belongs')->whereIn('bs_node_id',$request->bs_node_ids)->where('bs_admin_id', $admin->id)->delete();
        }
        if ($request->access_type == '1') {
            foreach ($request->bs_node_ids as $v){
                \DB::table('bs_belongs')->insert([
                    'bs_admin_id'=>$admin->id,
                    'bs_node_id'=>$v,
                    'created_at'=>$date,
                    'updated_at'=>$date,
                ]);
            }
        } else {
            if ( ! in_array('1', $request->bs_role_ids)) {
                foreach ($request->bs_role_ids as $v) {
                    \DB::table('bs_personates')->insert(
                        [
                            'bs_admin_id' => $admin->id,
                            'bs_role_id'  => $v,
                            'created_at'  => $date,
                            'updated_at'  => $date,
                        ]
                    );
                }
            } else {
                \DB::table('bs_personates')->insert(
                    [
                        'bs_admin_id' => $admin->id,
                        'bs_role_id'  => '1',
                        'created_at'  => $date,
                        'updated_at'  => $date,
                    ]
                );
            }
        }
        
        return redirect('admin/admin')->with('success', '修改成功');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if ($id > 0) {
            if ($id > 1) {
                Admin::where('id', $id)->delete();
                \DB::table('bs_personates')->where('bs_admin_id', $id)->delete(
                );
                \DB::table('bs_belongs')->where('bs_admin_id', $id)->delete();
                
                return redirect('admin/admin')->with('success', '删除成功');
            } else {
                return redirect('admin/admin')->with('danger', '非法操作');
            }
        } else {
            $ids = is_array($request->ids)
                ? $request->ids
                : explode(
                    ',', $request->ids
                );
            Admin::where('id', '<>', '1')->whereIn('id', $ids)->delete();
            \DB::table('bs_personates')->where('bs_admin_id', '<>', '1')
                ->whereIn('bs_admin_id', $ids)->delete();
            \DB::table('bs_belongs')->where('bs_admin_id', '<>', '1')->whereIn(
                'bs_admin_id', $ids
            )->delete();
            
            return redirect('admin/admin')->with('success', '批量删除成功');
        }
    }
    
    public function enable($id, Request $request)
    {
        if ($id > 0) {
            if ($id > 1) {
                Admin::where('id', $id)->update(['status' => '1']);
                
                return redirect('admin/admin')->with('success', '启用成功');
            } else {
                return redirect('admin/admin')->with('danger', '非法操作');
            }
        } else {
            $ids = is_array($request->ids)
                ? $request->ids
                : explode(
                    ',', $request->ids
                );
            Admin::where('id', '<>', '1')->whereIn('id', $ids)->update(
                ['status' => '1']
            );
            
            return redirect('admin/admin')->with('success', '批量启用成功');
        }
    }
    
    public function disable($id, Request $request)
    {
        if ($id > 0) {
            if ($id > 1) {
                Admin::where('id', $id)->update(['status' => '0']);
                
                return redirect('admin/admin')->with('success', '禁用成功');
            } else {
                return redirect('admin/admin')->with('danger', '非法操作');
            }
        } else {
            $ids = is_array($request->ids)
                ? $request->ids
                : explode(
                    ',', $request->ids
                );
            Admin::where('id', '<>', '1')->whereIn('id', $ids)->update(
                ['status' => '0']
            );
            
            return redirect('admin/admin')->with('success', '批量禁用成功');
        }
    }
}

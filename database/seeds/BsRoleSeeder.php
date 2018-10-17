<?php

use Illuminate\Database\Seeder;

class BsRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=factory(\App\Model\Admin\Role::class,20)->create();
        $date=date('Y-h-d H:i:s');
        foreach ($roles as $k=>$v){
            if($k>0){
                $num=mt_rand(1,17);
                for ($i=0;$i<$num;$i++){
                    \Illuminate\Support\Facades\DB::table('bs_access')->insert([
                        'bs_role_id'=>$v->id,
                        'bs_node_id'=>$i+1,
                        'created_at'=>$date,
                        'updated_at'=>$date,
                    ]);
                }
            }
        }
        $role=$roles[0];
        $role->name='supperadmin';
        $role->title='超级管理员';
        $role->status=1;
        $role->save();
        $role=$roles[1];
        $role->name='admin';
        $role->title='管理员';
        $role->status=1;
        $role->save();
        $role=$roles[2];
        $role->name='editor';
        $role->title='编辑';
        $role->status=0;
        $role->save();
        $role=$roles[3];
        $role->name='runner';
        $role->title='运营';
        $role->status=1;
        $role->save();
    }
}

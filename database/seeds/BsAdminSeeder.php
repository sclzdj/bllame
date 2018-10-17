<?php

use Illuminate\Database\Seeder;

class BsAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins=factory(\App\Model\Admin\Admin::class,30)->create();
        $date=date('Y-h-d H:i:s');
        foreach ($admins as $k=>$v){
            if($k==0){
                \Illuminate\Support\Facades\DB::table('bs_personates')->insert([
                    'bs_admin_id'=>$v->id,
                    'bs_role_id'=>'1',
                    'created_at'=>$date,
                    'updated_at'=>$date,
                ]);
            }else{
                if($v->access_type=='1'){
                    $num=mt_rand(1,17);
                    for ($i=0;$i<$num;$i++){
                        \Illuminate\Support\Facades\DB::table('bs_belongs')->insert([
                            'bs_admin_id'=>$v->id,
                            'bs_node_id'=>$i+1,
                            'created_at'=>$date,
                            'updated_at'=>$date,
                        ]);
                    }
                }else{
                    $role_ids=[];
                    for ($i=0;$i<20;$i++){
                        $role_ids[]=$i+1;
                    }
                    $rand_ids=array_rand($role_ids,mt_rand(1,19));
                    if(!is_array($rand_ids)){
                        $rand_ids=(array)$role_ids[$rand_ids];
                    }
                    if(in_array(1,$rand_ids)){
                        \Illuminate\Support\Facades\DB::table('bs_personates')->insert([
                            'bs_admin_id'=>$v->id,
                            'bs_role_id'=>'1',
                            'created_at'=>$date,
                            'updated_at'=>$date,
                        ]);
                    }else{
                        foreach ($rand_ids as $rand_id){
                            if($rand_id<=0) continue;
                            \Illuminate\Support\Facades\DB::table('bs_personates')->insert([
                                'bs_admin_id'=>$v->id,
                                'bs_role_id'=>$rand_id,
                                'created_at'=>$date,
                                'updated_at'=>$date,
                            ]);
                        }
                    }
                }
            }
        }
        $admin=$admins[0];
        $admin->username='admin';
        $admin->nickname='站长';
        $admin->access_type=0;
        $admin->status=1;
        $admin->save();
        $admin=$admins[1];
        $admin->username='dujun';
        $admin->nickname='军哥';
        $admin->status=1;
        $admin->save();
        $admin=$admins[2];
        $admin->username='sclzdj';
        $admin->nickname='小阆';
        $admin->status=1;
        $admin->save();
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBsAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_admins', function (Blueprint $table) {
            $table->engine = config('database.table_engine');
            $table->increments('id');
            $table->string('username')->unique()->default('')->comment('用户名');
            $table->string('password')->default('')->comment('密码');
            $table->string('nickname')->default('')->comment('昵称');
            $table->unsignedTinyInteger('access_type')->default(0)->comment('权限类型0:通过角色权限 1:直接赋予权限');
            $table->unsignedTinyInteger('status')->default(1)->comment('账号状态0:禁用 1:开启');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `bs_admins` COMMENT '后台:用户表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}

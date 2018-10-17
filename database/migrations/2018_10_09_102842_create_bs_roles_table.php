<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBsRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_roles', function (Blueprint $table) {
            $table->engine = config('database.table_engine');
            $table->increments('id');
            $table->string('name')->unique()->default('')->comment('角色标识');
            $table->string('title')->default('')->comment('角色名称');
            $table->unsignedTinyInteger('status')->default(1)->comment('账号状态0:禁用 1:开启');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `bs_roles` COMMENT '后台:角色表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBsBelongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_belongs', function (Blueprint $table) {
            $table->engine = config('database.table_engine');
            $table->increments('id');
            $table->unsignedInteger('bs_admin_id')->default(0)->comment('角色');
            $table->unsignedInteger('bs_node_id')->default(0)->comment('节点');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `bs_belongs` COMMENT '后台:用户节点权限直属表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bs_belongs');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBsNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_nodes', function (Blueprint $table) {
            $table->engine = config('database.table_engine');
            $table->increments('id');
            $table->string('title')->default('')->comment('节点标题');
            $table->string('uses')->unique()->default('')->comment('控制器方法');
            $table->string('controller')->index()->default('')->comment('控制器');
            $table->text('relates')->comment('其它控制器方法，多个换行隔开');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `bs_nodes` COMMENT '后台:节点表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nodes');
    }
}

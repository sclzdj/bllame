 <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBsPersonatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_personates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bs_admin_id')->default(0)->comment('用户');
            $table->unsignedInteger('bs_role_id')->default(0)->comment('角色');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `bs_personates` COMMENT '后台:用户角色从属表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personates');
    }
}

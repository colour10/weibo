<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicroblogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microblogs', function (Blueprint $table) {
            $table->id()->comment('主键ID');
            $table->unsignedBigInteger('user_id')->index()->comment('发布者ID');
            $table->text('content')->comment('内容');
            $table->index(['created_at']);
            $table->timestamps();
            // 添加外键
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('microblogs');
    }
}

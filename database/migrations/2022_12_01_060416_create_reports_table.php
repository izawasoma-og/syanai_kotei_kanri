<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments("id");
            $table->integer('project_id')->length(4);
            $table->integer('user_id')->length(4);
            $table->integer('operation_id')->length(2);
            $table->date('date');
            $table->time('working_time');
            $table->string("url")->nullable();
            $table->boolean("deleted")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};

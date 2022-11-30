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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descriptions');
            $table->string('task_group_id');
            $table->tinyInteger('type');
            $table->timestamps('completed_at')->nullable();
            $table->timestamps('start_date')->nullable();
            $table->timestamps('end_date')->nullable();
            $table->boolean('is_important')->default(false);
            $table->boolean('is_quickly')->default(false);
            $table->boolean('status_completed')->default(false);
            $table->number('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};

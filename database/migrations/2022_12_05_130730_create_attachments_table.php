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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('attachable_type')->nullable();
            $table->string('file_path')->default(false);
            $table->string('file_name')->default(false);
            $table->string('extension')->default(false);
            $table->string('mime_type')->default(false);
            $table->Integer('size')->default('0');
            $table->string('title')->nullable();
            $table->string('deleted_by');
            $table->timestamp('deleted_at');
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
        Schema::dropIfExists('attachments');
    }
};

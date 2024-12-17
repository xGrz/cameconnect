<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('connected_thru')->nullable();
            $table->string('icon_name')->nullable();
            $table->integer('remotes_max')->default(0);
            $table->unsignedBigInteger('model_id');
            $table->string('model_name')->nullable();
            $table->text('model_description')->nullable();
            $table->string('keycode')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('engagements')->default(0);
            $table->boolean('manage_device')->default(false);
            $table->unsignedBigInteger('mapped_id')->default(0);
            $table->integer('local_inputs')->nullable();
            $table->integer('local_outputs')->nullable();
            $table->timestamps();
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};

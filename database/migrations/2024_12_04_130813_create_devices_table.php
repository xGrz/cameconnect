<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->unique();
            $table->unsignedBigInteger('site_id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('model_id')->nullable();
            $table->string('model_name')->nullable();
            $table->string('model_description')->nullable();
            $table->string('key_code')->nullable();
            $table->string('icon')->nullable();
            $table->tinyInteger('inputs')->nullable();
            $table->tinyInteger('outputs')->nullable();
            $table->integer('max_remotes')->nullable();
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('parent_id')->references('id')->on('devices')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};

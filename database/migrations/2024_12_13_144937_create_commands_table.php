<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commands', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->integer('device_id');
            $table->string('command_id');
            $table->boolean('is_automation');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commands');
    }
};

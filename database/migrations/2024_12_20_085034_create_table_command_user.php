<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('command_user', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Command::class)->constrained();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->integer('position')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('command_user');
    }
};

<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('timezone')->nullable();
            $table->unsignedInteger('technical_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};

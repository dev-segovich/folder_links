<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('env')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('actualizado');
            $table->string('prod_url')->nullable();
            $table->string('local_url')->nullable();
            $table->boolean('hidden_from_boss')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

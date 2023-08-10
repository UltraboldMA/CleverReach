<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clever_reach_newsletters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clever_reach_client_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('key');
            $table->integer('form_id')->nullable();
            $table->integer('group_id');
            $table->string('language')->default('de');
            $table->boolean('double_opt_in')->default(true);
            $table->json('cl_attributes')->nullable();
            $table->json('cl_global_attributes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clever_reach_newsletters');
    }
};

<?php

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        Schema::create('clever_reach_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id');
            $table->foreignId('clever_reach_client_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->boolean('locked');
            $table->boolean('backup');
            $table->string('receiver_info');
            $table->timestamp('stamp');
            $table->timestamp('last_mailing')->nullable();
            $table->timestamp('last_changed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clever_reach_groups');
    }
};

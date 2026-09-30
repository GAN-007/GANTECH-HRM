<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_system_one_decisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_ticket_id');
            $table->string('provider', 32)->default('laya');
            $table->string('mode', 32)->default('shadow');
            $table->boolean('advisory_only')->default(true);
            $table->json('answers');
            $table->json('routing')->nullable();
            $table->json('usage')->nullable();
            $table->unsignedInteger('latency_ms')->nullable();
            $table->timestamps();

            $table->foreign('support_ticket_id')
                ->references('id')
                ->on('support_tickets')
                ->cascadeOnDelete();
            $table->index(['support_ticket_id', 'created_at'], 'hr_s1_ticket_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_system_one_decisions');
    }
};

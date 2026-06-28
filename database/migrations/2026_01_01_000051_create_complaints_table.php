<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('complainant_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('complaint_type');
            $table->text('description');
            $table->string('evidence_url')->nullable();
            $table->string('status')->default('open')->index();
            $table->text('resolution_note')->nullable();
            $table->timestamps();

            // ponytail: keep — respondent_id and resolution tracking are needed for dispute flow
            $table->foreignId('respondent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('complaint_number', 30)->nullable()->unique();
            $table->string('subject')->nullable();
            $table->timestamp('resolved_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};

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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->string('external_id')->unique();
            $table->dateTime('created_at');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 32);
            $table->string('email');
            $table->string('city');
            $table->string('source');
            $table->string('utm_campaign')->nullable();
            $table->string('product');
            $table->unsignedInteger('budget_uah')->nullable();
            $table->string('status');
            $table->string('manager')->nullable();
            $table->text('comment')->nullable();
            $table->dateTime('next_contact_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

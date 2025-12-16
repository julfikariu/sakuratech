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
        Schema::create('projects', function (Blueprint $table) {        
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('client_id');
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->date('estimate_delivery_date')->nullable();
            $table->enum('status', ['Running', 'Completed', 'Pending'])->default('Pending');
            $table->unsignedTinyInteger('progress')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(1);
            $table->string('name', 200);
            $table->string('path', 255)->nullable();
            $table->integer('size')->default(0);
            $table->string('type', 120)->nullable();
            $table->dateTime('uploaded_at');
            $table->unsignedBigInteger('attachable_id')->comment('Relation table record ID');
            $table->string('attachable_type')->comment('Relation table name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};

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
        Schema::create('movimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('conta_id')->constrained();
            $table->foreignId('categoria_id')->constrained();
            $table->foreignId('tipo_documento_id')->constrained();
            $table->string('descricao');
            $table->string('tipo_movimento');
            $table->date('dt_vencto');
            $table->decimal('vl_vencto',10,2);
            $table->date('dt_pagto')->nullable();
            $table->decimal('vl_pagto',10,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentos');
    }
};

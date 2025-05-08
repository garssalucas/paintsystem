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
        Schema::create('oryons', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',25)->unique();
            $table->string('descricao',128);
            $table->decimal('preco', 10, 2)->nullable();
            $table->string('categoria',64);
            $table->string('fornecedor',64);
            $table->decimal('peso', 8, 2)->nullable();
            $table->string('codigo_fornecedor',64)->nullable();
            $table->decimal('preco_compra', 10, 2)->nullable();
            $table->decimal('estoque', 10, 2)->nullable();
            //$table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oryons');
    }
};

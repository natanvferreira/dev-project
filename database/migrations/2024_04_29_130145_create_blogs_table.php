<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('titulo');
            $table->string('imagem')->nullable();
            $table->text('conteudo');
            $table->dateTime('data_publicacao');
            $table->enum('status', ['pendente', 'aprovado'])->default('pendente');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('blog_categoria', function (Blueprint $table) {
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->primary(['blog_id', 'categoria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_categoria');
        Schema::dropIfExists('blogs');
    }
};

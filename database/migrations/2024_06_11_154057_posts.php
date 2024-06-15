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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', length: 191);
            $table->string('seotitle', length: 191);
            $table->string('user_id', length: 191);
            $table->text('content');
            $table->string('image', length: 191)->nullable()->default('noimage.jpg');
            $table->integer('hits')->default(0);
            $table->string('active', length: 191)->default('Yes');
            $table->string('status', length: 191)->default('publish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

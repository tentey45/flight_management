<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_metas', function (Blueprint $table) {
            $table->id();
            // One-to-One: cascadeOnDelete ensures if a post is deleted, its meta is too
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            
            $table->string('seo_title')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_metas');
    }
};
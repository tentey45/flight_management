<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            
            // Optional: If comments are made by registered users
            // nullOnDelete means if the user deletes their account, the comment stays but the author is "null"
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); 
            
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
};

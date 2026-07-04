<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_post_category', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_category_id')->constrained()->cascadeOnDelete();
            
            // Setting a composite primary key prevents duplicate links
            $table->primary(['post_id', 'post_category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_post_category');
    }
};

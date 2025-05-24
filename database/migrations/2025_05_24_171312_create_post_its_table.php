<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('post_its', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('color', ['yellow','blue','green','pink','white'])->default('yellow');
            $table->string('font_family')->default('Arial');
            $table->string('font_size')->default('medium');
            $table->enum('size', ['S','M','L'])->default('M');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_its');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('status', array('Published', 'Draft'))->default('Draft');
            $table->enum('visibility', array('Public', 'Hidden'))->default('Public');
            $table->foreignId('category_id')->constrained();
            $table->text('additional_info')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'visibility']);
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

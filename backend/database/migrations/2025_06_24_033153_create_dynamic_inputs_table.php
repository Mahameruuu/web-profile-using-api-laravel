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
        Schema::create('dynamic_inputs', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('name');
            $table->string('type'); // text, select, checkbox, dll
            $table->boolean('active')->default(true);
            $table->json('options')->nullable(); // untuk select/radio
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_inputs');
    }
};

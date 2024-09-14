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
        //
        Schema::create("producs" , function(Blueprint $table): void{
            $table->id("Id");
            $table->string("title")->unique() ;
            $table->dateTime("Date");
            $table->string("description");
            $table->string("imageUrl");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists("producs");
    }
};

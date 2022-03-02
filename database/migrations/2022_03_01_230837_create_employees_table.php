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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string("api_id")->nullable();
            $table->string("upi")->nullable();
            $table->integer("mis_id")->nullable();
            $table->string("initials")->nullable();
            $table->string("title")->nullable();
            $table->string("surname")->nullable();
            $table->string("forename")->nullable();
            $table->string("middle_names")->nullable();
            $table->string("legal_surname")->nullable();
            $table->string("legal_forename")->nullable();
            $table->string("gender")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};

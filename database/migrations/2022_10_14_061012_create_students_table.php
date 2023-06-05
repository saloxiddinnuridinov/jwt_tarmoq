<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("surname");
            $table->string("email")->unique();
            $table->bigInteger("email_verified_at")->nullable();
            $table->enum("status", ["active", "inactive"])->default("inactive");
            $table->text('block_reason')->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->string('password');
            $table->bigInteger('balance')->default(0);
            $table->date("birthday")->nullable();
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
        Schema::dropIfExists('students');
    }
}

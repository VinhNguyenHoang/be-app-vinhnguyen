<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("event_id");
            $table->unsignedInteger("user_id");
            $table->string("first_name");
            $table->string("last_name");
            $table->string("hobbies");
            $table->foreign("event_id")->references("id")->on("events")->onUpdate("RESTRICT")->onDelete("CASCADE");
            $table->foreign("user_id")->references("id")->on("users")->onUpdate("RESTRICT")->onDelete("CASCADE");
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
        Schema::dropIfExists('register_forms');
    }
}

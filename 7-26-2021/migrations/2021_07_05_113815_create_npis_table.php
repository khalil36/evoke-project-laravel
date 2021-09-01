<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('npis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->default(0);
            $table->string('npi', 100)->nullable();
            $table->string('first_name',250)->nullable();
            $table->string('last_name',250)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('decile', 250)->nullable();
            $table->unsignedBigInteger('created_by_user_id')->default(0);
            $table->timestamps();
            $table->index(['npi', 'first_name', 'last_name', 'team_id', 'created_by_user_id']);
            $table->foreign('created_by_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('npis');
    }
}

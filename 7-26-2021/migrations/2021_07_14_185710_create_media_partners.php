<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaPartners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->default(0);
            $table->string('media_partner_name',250)->nullable();
            $table->unsignedBigInteger('created_by_user_id')->default(0);
            $table->timestamps();
            $table->index(['team_id', 'created_by_user_id']);
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
        Schema::dropIfExists('media_partners');
    }
}

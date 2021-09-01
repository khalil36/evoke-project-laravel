<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaPartnerUld extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_partner_uld', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_partner_id')->default(0);
            $table->string('npi',250)->nullable();
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            $table->index(['media_partner_id']);
            $table->foreign('media_partner_id')->references('id')->on('media_partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_partner_uld');
    }
}

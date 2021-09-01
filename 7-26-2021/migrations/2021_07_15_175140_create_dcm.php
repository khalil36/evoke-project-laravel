<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dcm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->default(0);
            $table->string('advertiser',250)->nullable();
            $table->string('country',250)->nullable();
            $table->date('date');
            $table->string('campaign',250)->nullable();
            $table->string('site_dcm',250)->nullable();
            $table->string('placement',250)->nullable();
            $table->decimal('impression_reach', 10, 2)->nullable();
            $table->decimal('click_reach', 10, 2)->nullable();
            $table->decimal('total_reach', 10, 2)->nullable();
            $table->decimal('average_impression_frequency', 10, 2)->nullable();
            $table->timestamps();
            $table->index(['team_id']);
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
        Schema::dropIfExists('dcm');
    }
}

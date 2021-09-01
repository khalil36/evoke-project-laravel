<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsvFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_file', function (Blueprint $table) {
            $table->id();
            $table->string('csv_filename')->nullable();
            $table->boolean('csv_header')->default(0);
            $table->longText('csv_data')->nullable();
            $table->string('data_import_type', 100)->nullable();
            $table->integer('media_partner_id')->default(0);
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
        Schema::dropIfExists('csv_file');
    }
}

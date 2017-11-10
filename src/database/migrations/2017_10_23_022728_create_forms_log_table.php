<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id')->nullable()->index();
            $table->char('title', 191)->nullable()->index();
            $table->text('form_data');
            $table->char('form_status', 191)->default('Новая')->index();
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
        Schema::dropIfExists('forms_log');
    }
}
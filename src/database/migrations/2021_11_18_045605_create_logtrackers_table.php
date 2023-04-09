<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogtrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logtrackers', function (Blueprint $table) {
            $table->id();
            $table->text('users');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('office_layer_id')->nullable();
            $table->integer('office_id')->nullable();
            $table->integer('ministry_id')->nullable();
            $table->integer('region_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('municipality_id')->nullable();
            $table->integer('barangay_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->dateTime('log_date');
            $table->string('table_name',50)->nullable();
            $table->string('log_type',50);
            $table->longText('new_data')->nullable();
            $table->longText('data');
            $table->boolean('synchronous')->default(false);
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
        Schema::dropIfExists('logtrackers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->index();
            $table->timestamps();

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::create('check_attributes',function(Blueprint $table){
            $table->id();
            $table->string('name')->index();
            $table->string('type')->index();
            $table->longText('options')->nullable();
            $table->integer('order')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('check_data',function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('check_id');
            $table->string('name')->index();
            $table->longText('value')->nullable();
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
        Schema::dropIfExists('check_data');
        Schema::dropIfExists('checks');
        Schema::dropIfExists('check_attribute');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsChecksPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_rating', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('check_id')->index();
            $table->unsignedBigInteger('rating_id')->index();

            $table->foreign('rating_id')
                ->references('id')
                ->on('ratings')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('check_id')
                ->references('id')
                ->on('checks')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_rating');
    }
}

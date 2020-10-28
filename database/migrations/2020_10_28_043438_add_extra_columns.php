<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checks', function (Blueprint $table) {
            $table->longText('criteria')->after('name')->nullable();
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->renameColumn('total', 'out_of');
            $table->renameColumn('result', 'scored');
        });

        Schema::table('check_attributes', function (Blueprint $table) {
            $table->string('validation_rule')->after('type');
            $table->string('label')->after('type');
            $table->dropColumn('options');
            $table->boolean('use_in_rating')->default(0)->after('options');
        });

        Schema::create('check_attribute_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('check_attribute_id');
            $table->string('name');
            $table->string('label');
            $table->longText('value');

            $table->foreign('check_attribute_id')
                ->references('id')
                ->on('check_attributes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checks', function (Blueprint $table) {
            $table->dropColumn('criteria');
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->renameColumn('out_of', 'total');
            $table->renameColumn('scored', 'result');
        });

        Schema::table('check_attributes', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->dropColumn(['use_in_rating', 'validation_rule']);
        });

        Schema::dropIfExists('check_attributes_options');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckSumColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checks', function (Blueprint $table) {
            $table->string('sum')->after('name')->nullable()->index();
            $table->unsignedBigInteger('reviewer_id')->after('user_id')->nullable();

            $table->foreign('reviewer_id')
                ->on('users')
                ->references('id')
                ->onDelete('set null')
                ->onUpdate('set null');
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
            $table->dropColumn('sum');
            $table->dropForeign('reviewer_id');
            $table->dropColumn('reviewer_id');
        });
    }
}
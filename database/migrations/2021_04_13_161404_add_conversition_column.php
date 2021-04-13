<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConversitionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checks', function (Blueprint $table) {
            $table->decimal('conversion')->after('name')->default(0);
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->decimal('conversion')->after('out_of')->default(0);
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
            $table->dropColumn('conversion');
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn('conversion');
        });
    }
}

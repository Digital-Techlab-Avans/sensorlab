<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add notes string to products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('notes')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop notes string from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
};

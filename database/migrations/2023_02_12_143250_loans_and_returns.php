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

        // Each time products are lent, we create a new 'lending' entry with 'lending_products' entries for each product
        Schema::create('loans', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('loaned_at')->useCurrent();
            $table->timestamp('due_at')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedInteger('amount')->default(0);
        });

        Schema::create('returns', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->timestamp('returned_at')->useCurrent();
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        Schema::create('loans_and_returns', function (Blueprint $table) {
            $table->unsignedBigInteger('loan_id');
            $table->foreign('loan_id')->references('id')->on('loans');
            $table->unsignedBigInteger('return_id');
            $table->foreign('return_id')->references('id')->on('returns');
            $table->unsignedInteger('amount')->default(0);
            $table->primary(['loan_id', 'return_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Order is important, because of foreign keys
        Schema::dropIfExists('return_status');
        Schema::dropIfExists('loans_and_returns');
        Schema::dropIfExists('returns');
        Schema::dropIfExists('loans');
    }
};

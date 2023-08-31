<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        // Lookup table with lenders, uses email as primary key
//        Schema::create('users', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', true);
//            $table->string('email');
//            $table->string('name');
//            $table->string('password')->default(null)->nullable();
//            $table->boolean('is_admin')->default(false);
//        });
//
//        // These entries aren't for individual products, we don't track them
//        Schema::create('products', function (Blueprint $table) {
//            // Uses a surrogate key for more flexibility, this allows renaming the product
//            $table->unsignedBigInteger('id', true);
//            $table->string('name');
//            $table->unsignedBigInteger('ean_code')->unique()->nullable();
//            $table->text('description')->nullable();
//            // Archived, keep in product management overview, don't show in lender overview
//            $table->timestamp('archived')->nullable();
//            // Deleted, don't show in product management overview, don't show in lender overview
//            // We could completely remove entries, but this allows us to keep the history and doesn't cause issues with foreign keys
////            $table->timestamp('deleted')->nullable();
//            $table->unsignedInteger('stock')->nullable();
//
//            $table->timestamps();
//        });
//
//
//        Schema::create('product_images', function(Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('product_id');
//            $table->string('image_name');
//            $table->unsignedBigInteger('priority')->default(1);
//            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
//        });
//
//        Schema::create('product_videos', function(Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('product_id');
//            $table->string('link');
//            $table->unsignedBigInteger('priority')->default(1);
//            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
//        });
//
//        Schema::create('categories', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', true);
//            $table->string('name');
//            $table->string('img_name')->nullable();
//            $table->longText('description')->nullable();
//            $table->timestamps();
//        });
//
//        Schema::create('product_category', function (Blueprint $table) {
//            $table->unsignedBigInteger('product_id');
//            $table->foreign('product_id')->references('id')->on('products');
//            $table->unsignedBigInteger('category_id');
//            $table->foreign('category_id')->references('id')->on('categories');
//            $table->primary(['product_id', 'category_id']);
//            $table->timestamps();
//        });
//
//        // Each time products are lent, we create a new 'lending' entry with 'lending_products' entries for each product
//        Schema::create('loans', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', true);
//            $table->unsignedBigInteger('user_id');
//            $table->foreign('user_id')->references('id')->on('users');
//            $table->timestamp('loaned_at')->useCurrent();
//            $table->timestamp('due_at')->nullable();
//            $table->unsignedBigInteger('product_id');
//            $table->foreign('product_id')->references('id')->on('products');
//            $table->unsignedInteger('amount')->default(0);
//        });
//
//        Schema::create('returns', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', true);
//            $table->timestamp('returned_at')->useCurrent();
//            $table->text('comment')->nullable();
//            $table->timestamps();
//        });
//
//        Schema::create('loans_and_returns', function (Blueprint $table) {
//            $table->unsignedBigInteger('loan_id');
//            $table->foreign('loan_id')->references('id')->on('loans');
//            $table->unsignedBigInteger('return_id');
//            $table->foreign('return_id')->references('id')->on('returns');
//            $table->unsignedInteger('amount')->default(0);
//            $table->primary(['loan_id', 'return_id']);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//
//        // Order is important, because of foreign keys
//        Schema::dropIfExists('loans_and_returns');
//        Schema::dropIfExists('returns');
//        Schema::dropIfExists('loans');
//        Schema::dropIfExists('product_categories');
//        Schema::dropIfExists('users');
//        Schema::dropIfExists('products');
//        Schema::dropIfExists('categories');
//        Schema::dropIfExists('product_images');
//        Schema::dropIfExists('product_videos');

    }
};

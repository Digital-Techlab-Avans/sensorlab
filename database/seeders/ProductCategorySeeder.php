<?php

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class ProductCategorySeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $product_idColumn = 'product_id';
            $category_idColumn = 'category_id';

            $product_category_information = [
                [$product_idColumn => 1, $category_idColumn => 1],
                [$product_idColumn => 2, $category_idColumn => 2],
                [$product_idColumn => 1, $category_idColumn => 2],
                [$product_idColumn => 2, $category_idColumn => 3],
            ];

            DB::table('product_category')->insert($product_category_information);

        }
    }

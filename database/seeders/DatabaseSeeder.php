<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\Return_;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            LoanSeeder::class,
            ReturnStatusSeeder::class,
            ReturnSeeder::class,
            LoanReturnSeeder::class,
            CategorySeeder::class,
            ProductCategorySeeder::class,
            ProductImageSeeder::class,
            ProductVideoSeeder::class,
            EmailPreferenceSeeder::class,
        ]);
    }
}

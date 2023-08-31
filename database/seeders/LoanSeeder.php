<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idColumn = 'id';
        $user_idColumn = 'user_id';
        $due_atColumn = 'due_at';
        $product_idColumn = 'product_id';
        $amountColumn = 'amount';

        $returnDate = date('Y-m-d H:i:s', strtotime('+2 months'));

        $loans_information = [
            [$idColumn => 1, $user_idColumn => 1, $due_atColumn => '2023-04-01', $product_idColumn => 1, $amountColumn => 3],
            [$idColumn => 2, $user_idColumn => 1, $due_atColumn => $returnDate, $product_idColumn => 2, $amountColumn => 4],
            [$idColumn => 3, $user_idColumn => 1, $due_atColumn => $returnDate, $product_idColumn => 4, $amountColumn => 1],
            [$idColumn => 4, $user_idColumn => 2, $due_atColumn => $returnDate, $product_idColumn => 4, $amountColumn => 2],
            [$idColumn => 5, $user_idColumn => 2, $due_atColumn => '2023-03-01', $product_idColumn => 20, $amountColumn => 5],
            [$idColumn => 6, $user_idColumn => 2, $due_atColumn => $returnDate, $product_idColumn => 16, $amountColumn => 1],
            [$idColumn => 7, $user_idColumn => 3, $due_atColumn => '2023-03-10', $product_idColumn => 18, $amountColumn => 1],
            [$idColumn => 8, $user_idColumn => 3, $due_atColumn => $returnDate, $product_idColumn => 5, $amountColumn => 42],
            [$idColumn => 9, $user_idColumn => 3, $due_atColumn => $returnDate, $product_idColumn => 5, $amountColumn => 4],
            [$idColumn => 10, $user_idColumn => 4, $due_atColumn => $returnDate, $product_idColumn => 9, $amountColumn => 3],
            [$idColumn => 11, $user_idColumn => 4, $due_atColumn => '2023-06-17', $product_idColumn => 4, $amountColumn => 1],
            [$idColumn => 12, $user_idColumn => 4, $due_atColumn => '2023-06-14', $product_idColumn => 3, $amountColumn => 2],
            [$idColumn => 13, $user_idColumn => 5, $due_atColumn => $returnDate, $product_idColumn => 20, $amountColumn => 1],
            [$idColumn => 14, $user_idColumn => 5, $due_atColumn => $returnDate, $product_idColumn => 12, $amountColumn => 7],
            [$idColumn => 15, $user_idColumn => 6, $due_atColumn => $returnDate, $product_idColumn => 2, $amountColumn => 6],
            [$idColumn => 16, $user_idColumn => 6, $due_atColumn => $returnDate, $product_idColumn => 8, $amountColumn => 3],
            [$idColumn => 17, $user_idColumn => 7, $due_atColumn => $returnDate, $product_idColumn => 4, $amountColumn => 7],
            [$idColumn => 18, $user_idColumn => 1, $due_atColumn => $returnDate, $product_idColumn => 1, $amountColumn => 3],
            [$idColumn => 19, $user_idColumn => 1, $due_atColumn => $returnDate, $product_idColumn => 2, $amountColumn => 4],
            [$idColumn => 20, $user_idColumn => 1, $due_atColumn => $returnDate, $product_idColumn => 4, $amountColumn => 1],
            [$idColumn => 21, $user_idColumn => 1, $due_atColumn => '2023-06-01', $product_idColumn => 1, $amountColumn => 3],
            [$idColumn => 22, $user_idColumn => 1, $due_atColumn => $returnDate, $product_idColumn => 2, $amountColumn => 4],
            [$idColumn => 23, $user_idColumn => 1, $due_atColumn => $returnDate, $product_idColumn => 4, $amountColumn => 1],
        ];

        DB::table('loans')->insert($loans_information);
    }
}

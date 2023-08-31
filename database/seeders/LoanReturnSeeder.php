<?php

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class LoanReturnSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $loan_idColumn = 'loan_id';
            $return_idColumn = 'return_id';
            $amountColumn = 'amount';

            $loans_and_returns = [
                [$loan_idColumn => 1, $return_idColumn => 1, $amountColumn => 3],
                [$loan_idColumn => 5, $return_idColumn => 2, $amountColumn => 2],
                [$loan_idColumn => 5, $return_idColumn => 3, $amountColumn => 3],
                [$loan_idColumn => 6, $return_idColumn => 4, $amountColumn => 1],
                [$loan_idColumn => 7, $return_idColumn => 5, $amountColumn => 2],
                [$loan_idColumn => 8, $return_idColumn => 6, $amountColumn => 3],
                [$loan_idColumn => 17, $return_idColumn => 7, $amountColumn => 7],
                [$loan_idColumn => 19, $return_idColumn => 8, $amountColumn => 2],

            ];

            DB::table('loans_and_returns')->insert($loans_and_returns);

        }
    }

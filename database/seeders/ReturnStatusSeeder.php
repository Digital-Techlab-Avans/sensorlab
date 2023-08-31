<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReturnStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idColumn = 'id';
        $statusColumn = 'status_name';

        $statuses = [
            [$idColumn => 1, $statusColumn => "pending"],
            [$idColumn => 2, $statusColumn => "approved"],
            [$idColumn => 3, $statusColumn => "rejected"],
        ];
        DB::table('return_status')->insert($statuses);
    }
}

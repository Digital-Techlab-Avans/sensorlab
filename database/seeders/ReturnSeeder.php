<?php

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class ReturnSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $idColumn = 'id';
            $commentColumn = 'comment';
            $statusColumn = 'status_id';

            $returns_information = [
                [$idColumn => 1, $commentColumn => "Was kapot", $statusColumn => 1],
                [$idColumn => 2, $commentColumn => "werkte", $statusColumn => 2],
                [$idColumn => 3, $commentColumn => "Hier kan dus best veel tekst staan", $statusColumn => 3],
                [$idColumn => 4, $commentColumn => "Was kapot", $statusColumn => 1],
                [$idColumn => 5, $commentColumn => null, $statusColumn => 2],
                [$idColumn => 6, $commentColumn => null, $statusColumn => 1],
                [$idColumn => 7, $commentColumn => null, $statusColumn => 1],
                [$idColumn => 8, $commentColumn => null, $statusColumn => 2],
            ];

            DB::table('returns')->insert($returns_information);

        }
    }

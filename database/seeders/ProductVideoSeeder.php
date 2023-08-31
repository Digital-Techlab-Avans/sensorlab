<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $product_idColumn = 'product_id';
        $link_nameColumn = 'link';
        $priorityColumn = 'priority';

        $product_videos_information = [
            [$product_idColumn => 1, $link_nameColumn => 'https://www.youtube.com/watch?v=p9nyq4sm2dE', $priorityColumn => 3],
            [$product_idColumn => 2, $link_nameColumn => 'https://www.youtube.com/watch?v=z1IGAbIFGnk', $priorityColumn => 3],
            [$product_idColumn => 3, $link_nameColumn => 'https://www.youtube.com/watch?v=6XGeM2__Zx4', $priorityColumn => 2],
            [$product_idColumn => 5, $link_nameColumn => 'https://www.youtube.com/watch?v=2Y9zFh_CpAU', $priorityColumn => 2],
            [$product_idColumn => 8, $link_nameColumn => 'https://www.youtube.com/watch?v=Bf7Qff2p7-E', $priorityColumn => 2],
            [$product_idColumn => 10, $link_nameColumn => 'https://www.youtube.com/watch?v=erwD3ck6w2A', $priorityColumn => 2],
        ];

        DB::table('product_videos')->insert($product_videos_information);
    }

}

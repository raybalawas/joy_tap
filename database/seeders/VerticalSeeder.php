<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vertical;

class VerticalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas =  [
            ['vertical_name' => 'Health/Wellness'],
            ['vertical_name' => 'Travel'],
            ['vertical_name' => 'Entertainment'],
            ['vertical_name' => 'Cooking'],
            ['vertical_name' => 'Pets'],
            ['vertical_name' => 'Fashion'],
            ['vertical_name' => 'Lifestyle'],
            ['vertical_name' => 'Food']
          ];
          foreach($datas as $data)
          {
              Vertical::updateOrCreate($data);
          }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = [
            [
                'name' => 'Section A',
                'class_id' => '1',
            ],
            [
                'name' => 'Section B',
                'class_id' => '1',
            ],

            [
                'name' => 'Section A',
                'class_id' => '2',
            ],
            [
                'name' => 'Section B',
                'class_id' => '2',
            ],

            [
                'name' => 'Section A',
                'class_id' => '3',
            ],
            [
                'name' => 'Section B',
                'class_id' => '3',
            ],

            [
                'name' => 'Section A',
                'class_id' => '4',
            ],
            [
                'name' => 'Section B',
                'class_id' => '4',
            ],

            [
                'name' => 'Section A',
                'class_id' => '5',
            ],
            [
                'name' => 'Section B',
                'class_id' => '5',
            ],
        ];

        Section::insert($sections);
    }
}

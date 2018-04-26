<?php

use Illuminate\Database\Seeder;

class PictureBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('picture_boxes')->insert([
            'id' => 1,
            'pic' => '',
            'updated_by' => null,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);

        DB::table('picture_boxes')->insert([
            'id' => 2,
            'pic' => '',
            'updated_by' => null,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);

        DB::table('picture_boxes')->insert([
            'id' => 3,
            'pic' => '',
            'updated_by' => null,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);

    }
}

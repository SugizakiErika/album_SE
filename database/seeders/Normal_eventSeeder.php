<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Normal_eventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                DB::table('normal_events')->insert([
                'title' => 'ひな祭り',
                'start' => '03-21',
                'color' => '#CCCCFF',
                'comment' => 'ひな祭りは、上巳の節句である3月3日におこなうのが一般的です。家の中にひな人形と桃の花を飾って、女の子らしい彩りのある空間を演出するのが通例。さらに女の子の無病息災と幸せな成長を願い、ひな祭りにちなんだごちそうを囲み、家族や親戚でお祝いします。'
              
         ]);
    }
}

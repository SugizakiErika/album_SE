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
        $params = 
        [
            [
                'id' => 1,
                'title' => 'ひな祭り',
                'start' => '03-03',
                'color' => '#CCCCFF',
                'url' =>'/nromalevent/show/{1}',
                
                'comment' => 'ひな祭りは、上巳の節句である3月3日におこなうのが一般的です。
                              家の中にひな人形と桃の花を飾って、女の子らしい彩りのある空間を演出するのが通例。
                              さらに女の子の無病息災と幸せな成長を願い、ひな祭りにちなんだごちそうを囲み、家族や親戚でお祝いします。'
            ],
            [
                'id' => 2,
                'title' => 'ホワイトデー',
                'start' => '03-14',
                'color' => '#CCCCFF',
                'url' =>'/nromalevent/show/{2}',
                
                'comment' => 'ホワイトデーとは、一般的にバレンタインデーにチョコレートなどをもらった男性がそのお返しとしてキャンディ、
                              他にもマシュマロ、ホワイトチョコレートなどのプレゼントを女性へ贈る日とされる。'
            ],
            [
                'id' => 3,
                'title' => 'イースター',
                'start' => '03-31',
                'color' => '#CCCCFF',
                'url' =>'/nromalevent/show/{3}',
                
                'comment' => '復活祭は、磔刑にされて死んだイエス・キリストが三日目に復活したことを記念・記憶する、キリスト教においては最も重要とされる祭。'
            ]
        ];
        foreach ($params as $param) {
        DB::table('normal_events')->insert($param);
        }
    }
}

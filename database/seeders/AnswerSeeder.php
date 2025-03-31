<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $answers=[
            ['answer'=>'نعم','value'=>3],
            ['answer'=>'احيانا','value'=>2],
            ['answer'=>'نادرا','value'=>1],
            ['answer'=>'لا','value'=>0],
        ];
        foreach($answers as $answer)
        {
            Answer::create($answer);
        }
    }
}

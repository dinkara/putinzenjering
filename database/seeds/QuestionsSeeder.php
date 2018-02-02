<?php

use Illuminate\Database\Seeder;
use App\Repositories\Question\IQuestionRepo;
use App\Support\Enum\Questions;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(IQuestionRepo $questionRepo)
    {
        $questions = Questions::all();
        
        foreach ($questions as $question) {
            $questionRepo->create(["text" => $question]);
        }
    }
}

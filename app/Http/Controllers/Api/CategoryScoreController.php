<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryScore;
use App\Models\Category;
use App\Models\Category_Score;
use App\Models\Child;
use Illuminate\Http\Request;

class CategoryScoreController extends Controller
{
    public function categoryScore(Request $request)
    {
        $request->validate([
            'child_id' => 'required|exists:children,id',
            'category_id' => 'required|exists:categories,id',
            'answers' => 'required|array',
            'answers.*.value' => 'required|numeric|min:0'
        ]);

        $categoryScore = collect($request->answers)->sum('value');
        Category_Score::updateOrCreate(
            [
                'child_id' => $request->child_id,
                'category_id' => $request->category_id,
                'category_score' => $categoryScore
            ]
        );

        $answerdCategoryCount = Category_Score::where('child_id', $request->child_id)->count();
        $totalCateoriesCount = Category::count();

        $finalScore = null;
        if ($answerdCategoryCount == $totalCateoriesCount) {
            $finalScore = Category_Score::where('child_id', $request->child_id)->sum('category_score');

            $child = Child::find($request->child_id);
            $child->total_questions_score = $finalScore;
            $child->save();

            $image_accuracy = 94;
            $question_accuracy = 80;
            $total_score = $child->total_questions_score;
            $image_score = $child->ml_result / 100;
            $threshold = 0.5;

            $min_score = 0;
            $max_score = 96;
            
            $normalized_question_score = ($total_score - $min_score) / ($max_score - $min_score);
            $total_accuracy = $image_accuracy + $question_accuracy;
            $image_weight = $image_accuracy / $total_accuracy;
            $question_weight = $question_accuracy / $total_accuracy;

            $final_score = ($image_score * $image_weight) + ($normalized_question_score * $question_weight);

            if ($final_score > $threshold) {
                $child->final_diagnosis = 'مصاب';
                $child->final_diagnosis_score = $final_score;
                $child->save();
            } else {
                $child->final_diagnosis = 'غير مصاب';
                $child->final_diagnosis_score = $final_score;
                $child->save();
            }
            $result = Category_Score::where('child_id', $request->child_id)->get();
            return SendResponse(200, 'تمت الحفظ بنجاح ', CategoryScore::collection($result));
        }
    }


    public function MyCategoryScore(Request $request, $child_id)
    {
        $child = Child::findOrFail($child_id);

        if ($child) {
            $result = Category_Score::where('child_id', $child->id)->get();

            return SendResponse(200, ' هذه كل البيانات بالطفل ', CategoryScore::collection($result));
        }
        return SendResponse(404, ' قم بادخال بيانات صحيحه ', []);
    }
}

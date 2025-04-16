<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Category_Score;
use App\Models\Child;
use Illuminate\Http\Request;

class CategoryScoreController extends Controller
{
    public function categoryScore(Request $request, $child_id, $category_id)
    {
        $child = Child::find($child_id);
        $category = Category::find($category_id);

        if ($child->user_id != auth()->id() && isset($category)) {
            return SendResponse(422, ' لا تستطيع حفظ الاجابات ', []);
        } else {
            Category_Score::create([
                'category_score' => $request->input('category_score'),
                'child_id' => $child->id,
                'category_id' => $category->id,
            ]);
            return SendResponse(200, ' تم تسجيل نتيجه الفئه بنجاح ', []);
        }
    }
}

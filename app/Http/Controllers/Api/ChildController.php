<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    public function test()
    {
        // $categories = Category::with('questions')->get();
        // foreach ($categories as $category) {
        //     echo "category:" . $category->name . "<br>";
        //     foreach($category->questions as $questions)
        //     {
        //         echo "-".$questions->question."<br>";
        //     }
        // }
        // view('test');
    }
}

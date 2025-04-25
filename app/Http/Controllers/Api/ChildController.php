<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChildRequest;
use App\Http\Resources\ChildResource;
use App\Http\Resources\MyChildrenResource;
use App\Models\Category;
use App\Models\Child;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function PHPUnit\Framework\returnSelf;

class ChildController extends Controller
{

    public function create(ChildRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        // $birthdate = Carbon::parse($data['birth_date']);
        // $age = $birthdate->age;
        // $data['birth_date'] = $age;

        if ($request->hasFile('image')) {
            $image = $request->image;
            $newImage = Str::uuid() . "-" . $image->getClientOriginalName();
            $image->storeAS('public/Children', $newImage);
            $data['image'] = $newImage;
        }

        $record = Child::create($data);
        if ($record) return  SendResponse(201, ' تم اضافه الطفل بنجاح ', new ChildResource($record));
    }


    public function update(ChildRequest $request, $id)
    {
        $data = $request->validated();
        $child = Child::find($id);

        if ($child->user_id != $request->user()->id) {

            return SendResponse(403, ' غير مسموح بهذا الاجراء ', []);
        } else {

            if ($request->hasFile('image')) {
                if ($child->image && Storage::exists('public/Children/' . $child->image)) {
                    Storage::delete('public/Children/' . $child->image);
                }

                $image = $request->image;
                $newImage = Str::uuid() . "-" . $image->getClientOriginalName();
                $image->storeAs('public/Children/', $newImage);
                $data['image'] = $newImage;
            }

            $child->update($data);
            return SendResponse(201, ' تم تعديل البيانات بنجاح ', new ChildResource($child));
        }
    }


    public function delete(Request $request, $id)
    {
        $child = Child::findOrFail($id);

        if ($child->user_id != $request->user()->id) {
            return SendResponse(403, ' غير مسموح بهذا الاجراء ', []);
        }

        Storage::delete('public/Children/' . $child->image);
        $deleteRecord = $child->delete();
        if ($deleteRecord) return SendResponse(200, ' تم حذف البيانات بنجاح ', []);
    }


    public function mychildern(Request $request)
    {
        $child = Child::where('user_id', $request->user()->id)->get();

        if (count($child) > 0) {
            return SendResponse(200, ' هؤلاء كل الاطفال التي قمت بتسجيلهم ', MyChildrenResource::collection($child));
        }
        return SendResponse(200, ' لا يوجد لديك اطفال مسجله ', []);
    }



    public function addReport(Request $request, $id)
    {
        //ازاي اكريت الريبورت واحفظه واشرحله انا هعمل ايه لغايه زرار الحفظ
        $child = Child::findOrfail($id);
        if ($child->user_id != $request->user()->id) {
            return SendResponse(403, ' غير مسموح بهذا الاجراء ', []);
        }
        if($request->hasFile('report'))
        {
            $report=$request->report;
            $newReport=Str::uuid()."-".$report->getClientOriginalName();
            $report->storeAs('public/Reports/'.$newReport);
            $child->report = $newReport;
            $child->save();
            return SendResponse(200, ' تم حفظ التقرير بنجاح ', []);
        }

    }

    public function deleteReport($id)
    {
        $child = Child::findOrfail($id);
        if ($child->user_id != auth()->id()) {
            return SendResponse(403, ' غير مسموح بهذا الاجراء ', []);
        }
        Storage::delete('public/Reports/',$child->report);
        $child->report = null;
        $child->save();
        return SendResponse(200, ' تم حذف التقرير بنجاح ', []);
    }

    public function addTotalScore(Request $request, $id)
    {
        $child = Child::findOrfail($id);
        if ($child->user_id != $request->user()->id) {
            return SendResponse(403, ' غير مسموح بهذا الاجراء ', []);
        }
        $score = $request->input('total_questions_score');
        $child->total_questions_score = $score;
        $child->save();
        return SendResponse(200, ' تم حفظ الاجابات بنجاح ', []);
    }
}

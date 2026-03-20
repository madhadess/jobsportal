<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ServiceCategory;
use App\ServiceQuestion;
use App\ServiceQuestionOption;

class ServiceQuestionController extends Controller
{
    public function index($categoryId)
    {
        $category = ServiceCategory::findOrFail($categoryId);
        $questions = ServiceQuestion::where('category_id', $categoryId)->orderBy('sort_order')->with('options')->get();
        return view('admin.service_questions.index', compact('category', 'questions'));
    }

    public function store(Request $request, $categoryId)
    {
        $this->validate($request, [
            'question' => 'required',
            'type' => 'required',
        ]);

        $question = new ServiceQuestion();
        $question->category_id = $categoryId;
        $question->question = $request->question;
        $question->type = $request->type;
        $question->is_required = $request->has('is_required');
        $question->sort_order = $request->sort_order ?? 0;
        $question->save();

        if ($request->has('options')) {
            $options = explode(',', $request->options);
            foreach ($options as $index => $optText) {
                if (trim($optText) != '') {
                    ServiceQuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => trim($optText),
                        'sort_order' => $index
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Soru başarıyla eklendi.');
    }

    public function destroy($id)
    {
        ServiceQuestion::destroy($id);
        return redirect()->back()->with('success', 'Soru silindi.');
    }
}

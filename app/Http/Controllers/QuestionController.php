<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Question::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(QuestionRequest $request)
    {
        $validated = $request->validated();
        
        Question::create(['question' => $validated['question'], 'answer' => $validated['answer']]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, string $id)
    {
        $validated = $request->validated();

        Question::find($id)->update(['question' => $request->question, 'answer' => $request->answer]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Question::find($id)->delete();
    }
}

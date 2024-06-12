<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Student;


class SubjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'     => [
                'string',
                'required',
            ],
            'min_mark' => [
                'required',
                'numeric',
            ],
        ]);

        Subject::create([
            'name'     => $request->get('name'),
            'min_mark' => $request->get('min_mark'),
        ]);

        return redirect()->back();
    }

    public function assign(Request $request)
    {
        $request->validate([
            'student_id' => [
                'required',
                'int',
                'exists:App\Models\Student,id',
            ],
            'subject_id' => [
                'required',
                'int',
                'exists:App\Models\Subject,id',
            ],
        ]);

        $subject = Subject::find($request->get('subject_id')); //first()
        $subject->student()->attach($request->get('student_id'));

        return redirect()->back()->with('status', 'success');
    }

    public function mark(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'student_id' => [
                'required',
                'int',
                'exists:App\Models\Student,id',
            ],
            'subject_id' => [
                'required',
                'int',
                'exists:App\Models\Subject,id',
            ],
            'mark'       => [
                'required',
                'numeric',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $subject = Subject::find($request->get('subject_id'))->first();

        $validator->addRules([
            'student_id' => [
                Rule::exists('student_subject')->where(function ($query) use (
                    $request
                ) {
                    $query->where('subject_id', $request->get('subject_id'));
                    $query->where('student_id', $request->get('student_id'));
                }),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subject->student()->updateExistingPivot(
            $request->get('student_id'),
            [
                'mark' => $request->get('mark'),
            ]
        );

        return redirect()->back()->with('status', 'success');
    }
}

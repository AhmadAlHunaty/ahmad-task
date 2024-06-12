<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function studentsInSubject(Subject $subject)
    {


        $subject->load('student');

        $students = $subject->student;


        return view('chat.index', compact('students', 'subject'));
    }
}

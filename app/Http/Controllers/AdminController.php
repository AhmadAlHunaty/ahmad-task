<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/index', [
            'users'    => User::whereIsAdmin(false)->get(),
            'subjects' => Subject::all()->load('student'),
            'students' => Student::whereRelation('user', 'is_active', '=', true)
                ->get(),
        ]);
    }
}

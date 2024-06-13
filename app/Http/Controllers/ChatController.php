<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Termwind\Components\Dd;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'student' => [
                'required',
                'exists:App\Models\Student,id',
            ],
            'subject' => [
                'required',
                'exists:App\Models\Subject,id',
            ],
        ]);

        $subject = Subject::find($request->get('subject'));
        $student = Student::find($request->get('student'));
        $messages = Message::where('subject_id', $subject)->with('student')
            ->latest()->get();

        return view(
            'chat.message',
            ['subject' => $subject, 'messages' => $messages, 'student' => $student]
        );
    }
    public function messages(Subject $subject)
    {
        // $messages = Message::where('subject_id', $subject->id)->with('student')->latest()->get();
        $messages = [];
        return view('chat.message', compact('subject', 'messages'));
    }

    public function store(Request $request, Message $message)
    {



        try {

            $request->validate([
                'message' => 'required',
                'subject_id' => 'required', // removed 'accepted' typo
                'student_id' => 'required', // removed 'accepted' typo
            ]);
            $student_id = auth()->user()->id;

            $newMessage = Message::create([
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'message' => $request->message,
            ]);

            broadcast(new MessageSent($newMessage))->toOthers();

            return response()->json(['status' => 'Message Sent!', 'message' => $newMessage]);
        } catch (\Exception $e) {
            \Log::error('Error storing message: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

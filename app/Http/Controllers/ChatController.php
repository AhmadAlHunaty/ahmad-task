<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Events\MessageSent;



class ChatController extends Controller
{
    public function index(Subject $subject)
    {
        $messages = Message::where('subject_id', $subject->id)->with('student')->latest()->get();
        return view('chat.message', compact('subject', 'messages'));
    }
    public function messages(Subject $subject)
    {
        // $messages = Message::where('subject_id', $subject->id)->with('student')->latest()->get();
        $messages = [];
        return view('chat.message', compact('subject', 'messages'));
    }

    public function store(Request $request, Subject $subject)
    {

        try {
            $request->validate(['message' => 'required']);

            $message = new Message([
                'student_id' => auth()->user()->id, // Assuming student is logged in
                'subject_id' => $subject->id,
                'message' => $request->input('message'),
            ]);

            $message->save();
            broadcast(new MessageSent($message))->toOthers();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error storing message: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    public function index()
    {
        $feedbacks = Feedback::with('user')->latest()->get();
        return view('feedback.index', compact('feedbacks'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:20',
            'detail' => 'required|max:500',
            'file' => 'nullable|file|max:2048'
        ]);

        $feedback = new Feedback();
        $feedback->title = $validated['title'];
        $feedback->detail = $validated['detail'];
        $feedback->user_id = Auth::user()->id;

        if ($request->hasFile('file')) {
            $feedback->file_path = $request->file('file')->store('feedback-files', 'public');
        }

        $feedback->save();

        return redirect()->back()->with('feedback_success', 'Masukan telah dikirim!');

    }

    public function toggleDone(Feedback $feedback)
    {
        $feedback->update(['has_done' => !$feedback->has_done]);
        return response()->json(['success' => true]);
    }

}

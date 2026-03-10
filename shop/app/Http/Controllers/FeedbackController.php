<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackMessageRequest;
use App\Models\FeedbackMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function create(): View
    {
        return view('feedback.create');
    }

    public function store(StoreFeedbackMessageRequest $request): RedirectResponse
    {
        FeedbackMessage::query()->create([
            'user_id' => $request->user()?->id,
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'subject' => $request->validated('subject'),
            'message' => $request->validated('message'),
        ]);

        return redirect()->route('feedback.create')->with('status', 'Сообщение отправлено.');
    }
}
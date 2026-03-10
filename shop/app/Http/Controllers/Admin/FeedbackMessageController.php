<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeedbackMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FeedbackMessageController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $messages = FeedbackMessage::query()
            ->with('user')
            ->when(
                filled($status),
                fn ($query) => $query->where('status', $status)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.feedback-messages.index', [
            'messages' => $messages,
            'statuses' => [
                FeedbackMessage::STATUS_NEW,
                FeedbackMessage::STATUS_IN_PROGRESS,
                FeedbackMessage::STATUS_ANSWERED,
            ],
            'selectedStatus' => $status,
        ]);
    }

    public function show(FeedbackMessage $feedbackMessage): View
    {
        $feedbackMessage->load('user');

        return view('admin.feedback-messages.show', [
            'message' => $feedbackMessage,
            'statuses' => [
                FeedbackMessage::STATUS_NEW,
                FeedbackMessage::STATUS_IN_PROGRESS,
                FeedbackMessage::STATUS_ANSWERED,
            ],
        ]);
    }

    public function update(Request $request, FeedbackMessage $feedbackMessage): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([
                FeedbackMessage::STATUS_NEW,
                FeedbackMessage::STATUS_IN_PROGRESS,
                FeedbackMessage::STATUS_ANSWERED,
            ])],
            'admin_reply' => ['nullable', 'string', 'max:5000'],
        ]);

        $feedbackMessage->update($validated);

        return redirect()->route('admin.feedback-messages.show', $feedbackMessage)->with('status', 'Обращение обновлено.');
    }
}
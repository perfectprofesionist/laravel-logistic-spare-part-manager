<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages with inline edit forms.
     */
    public function index()
    {
        $messages = Message::all();
        return view('messages', compact('messages'));
    }

    /**
     * Update the specified message.
     */
    public function update(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'text' => 'required|string',
        ]);

        // Find the message and update it
        $message = Message::findOrFail($id);
        $message->update([
            'text' => $request->text,
        ]);

        // Redirect back to the list with a success message
        return redirect()->route('messages.index')->with('success', 'Message updated successfully!');
    }
}

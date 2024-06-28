<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    // Display all notes
    public function index(Request $request)
    {
        $query = Note::where('user_id', auth()->id());

        if ($search = $request->input('search')) {
            $query->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
        }

        $notes = $query->paginate(5);
        $categories = Category::where('user_id', auth()->id())->get();

        return view('notes.index', compact('notes', 'categories'));
    }

    // Create a new note
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'category_id' => $request->category,
        ]);

        return redirect()->route('notes.index');
    }

    // Show the form for editing the note.
    public function edit(Note $note)
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('notes.edit', compact('note', 'categories'));
    }

    // Update a note
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category,
        ]);

        return redirect()->route('notes.index');
    }

    // Delete a note
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index');
    }
}

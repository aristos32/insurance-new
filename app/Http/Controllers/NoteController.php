<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Services\HistoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function __construct(private HistoryService $history) {}

    public function index(Request $request): View
    {
        $notes = Note::query()
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('description', 'like', $term)
                        ->orWhere('parameterValue', 'like', $term);
                });
            })
            ->orderByDesc('entryDate')
            ->paginate(25)
            ->withQueryString();

        return view('notes.index', compact('notes'));
    }

    public function create(Request $request): View
    {
        return view('notes.form', [
            'note' => new Note([
                'type' => $request->query('type', 'CLIENT'),
                'parameterName' => $request->query('parameterName'),
                'parameterValue' => $request->query('parameterValue'),
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['CONTRACT', 'CLIENT'])],
            'description' => ['required', 'string', 'max:50'],
            'parameterName' => ['nullable', 'string', 'max:20'],
            'parameterValue' => ['nullable', 'string', 'max:20'],
            'entryDate' => ['nullable', 'date'],
        ]);

        $data['entryDate'] = $data['entryDate'] ?? now();
        Note::create($data);
        $this->history->log($data['type'], 'NOTE', $data['parameterName'] ?? null, $data['parameterValue'] ?? null, $data['description']);

        return redirect()->route('notes.index')->with('success', 'Note created.');
    }

    public function destroy(Note $note): RedirectResponse
    {
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(Request $request): View
    {
        $history = History::query()
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('username', 'like', $term)
                        ->orWhere('note', 'like', $term)
                        ->orWhere('parameterValue', 'like', $term)
                        ->orWhere('subType', 'like', $term);
                });
            })
            ->orderByDesc('transDate')
            ->paginate(40)
            ->withQueryString();

        return view('history.index', compact('history'));
    }
}

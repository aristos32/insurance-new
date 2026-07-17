<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Owner;
use App\Services\HistoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClaimController extends Controller
{
    public function __construct(private HistoryService $history) {}

    public function index(Request $request): View
    {
        $claims = Claim::query()
            ->with('owner')
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('stateId', 'like', $term)
                        ->orWhere('description', 'like', $term);
                });
            })
            ->orderByDesc('claimDate')
            ->paginate(25)
            ->withQueryString();

        return view('claims.index', compact('claims'));
    }

    public function create(Request $request): View
    {
        return view('claims.form', [
            'claim' => new Claim(['stateId' => $request->query('stateId')]),
            'owners' => Owner::query()->orderBy('lastName')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'stateId' => ['required', 'exists:owner,stateId'],
            'amount' => ['required', 'integer', 'min:0'],
            'claimDate' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:50'],
            'quoteId' => ['nullable', 'integer'],
        ]);

        $claim = Claim::create($data);
        $this->history->log('CLIENT', 'CLAIM', 'stateId', $claim->stateId, 'Claim '.$claim->claimId);

        return redirect()->route('claims.index')->with('success', 'Claim created.');
    }

    public function destroy(Claim $claim): RedirectResponse
    {
        $stateId = $claim->stateId;
        $claim->delete();
        $this->history->log('CLIENT', 'CLAIM_DELETE', 'stateId', $stateId, 'Deleted claim');

        return redirect()->route('claims.index')->with('success', 'Claim deleted.');
    }
}

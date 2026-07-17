<?php

namespace App\Http\Controllers;

use App\Enums\OwnerType;
use App\Models\Owner;
use App\Models\OwnerAddress;
use App\Services\HistoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OwnerController extends Controller
{
    public function __construct(private HistoryService $history) {}

    public function index(Request $request): View
    {
        $owners = Owner::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('stateId', 'like', $term)
                        ->orWhere('firstName', 'like', $term)
                        ->orWhere('lastName', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('telephone', 'like', $term);
                });
            })
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->orderBy('lastName')
            ->orderBy('firstName')
            ->paginate(25)
            ->withQueryString();

        return view('owners.index', compact('owners'));
    }

    public function create(): View
    {
        return view('owners.form', ['owner' => new Owner(['type' => OwnerType::Account->value, 'proposerType' => 'PERSON'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $owner = Owner::create($data);

        if ($request->filled('street')) {
            OwnerAddress::create([
                'stateId' => $owner->stateId,
                'addressType' => $request->input('addressType', 'CORRESPONDENCEADDRESS'),
                'street' => $request->input('street'),
                'areaCode' => $request->input('areaCode'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'country' => $request->input('country', 'Cyprus'),
            ]);
        }

        $this->history->log('CLIENT', 'CREATE', 'stateId', $owner->stateId, 'Created owner');

        return redirect()->route('owners.show', $owner)->with('success', 'Owner created.');
    }

    public function show(Owner $owner): View
    {
        $owner->load(['addresses', 'sales', 'claims']);

        return view('owners.show', compact('owner'));
    }

    public function edit(Owner $owner): View
    {
        $owner->load('addresses');

        return view('owners.form', compact('owner'));
    }

    public function update(Request $request, Owner $owner): RedirectResponse
    {
        $owner->update($this->validated($request, $owner));
        $this->history->log('CLIENT', 'UPDATE', 'stateId', $owner->stateId, 'Updated owner');

        return redirect()->route('owners.show', $owner)->with('success', 'Owner updated.');
    }

    public function destroy(Owner $owner): RedirectResponse
    {
        $stateId = $owner->stateId;
        $owner->delete();
        $this->history->log('CLIENT', 'DELETE', 'stateId', $stateId, 'Deleted owner');

        return redirect()->route('owners.index')->with('success', 'Owner deleted.');
    }

    private function validated(Request $request, ?Owner $owner = null): array
    {
        return $request->validate([
            'stateId' => [
                $owner ? 'sometimes' : 'required',
                'string',
                'max:20',
                Rule::unique('owner', 'stateId')->ignore($owner?->stateId, 'stateId'),
            ],
            'firstName' => ['nullable', 'string', 'max:70'],
            'lastName' => ['nullable', 'string', 'max:70'],
            'type' => ['required', Rule::in(['account', 'lead'])],
            'proposerType' => ['nullable', Rule::in(['PERSON', 'COMPANY'])],
            'gender' => ['nullable', 'string', 'max:10'],
            'countryOfBirth' => ['nullable', 'string', 'max:30'],
            'countryOfResidence' => ['nullable', 'string', 'max:30'],
            'birthDate' => ['nullable', 'date'],
            'profession' => ['nullable', 'string', 'max:30'],
            'company' => ['nullable', 'string', 'max:50'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'cellphone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:50'],
            'unwantedCustomer' => ['nullable', Rule::in(['YES', 'NO'])],
            'reasonForUnwanted' => ['nullable', 'string', 'max:50'],
        ]);
    }
}

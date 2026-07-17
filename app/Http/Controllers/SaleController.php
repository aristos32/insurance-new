<?php

namespace App\Http\Controllers;

use App\Enums\InsuranceType;
use App\Enums\SaleStatus;
use App\Models\Owner;
use App\Models\Sale;
use App\Models\Vehicle;
use App\Services\HistoryService;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function __construct(
        private HistoryService $history,
        private TransactionService $transactions,
    ) {}

    public function index(Request $request): View
    {
        $sales = Sale::query()
            ->with('owner')
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('saleId', 'like', $term)
                        ->orWhere('company', 'like', $term)
                        ->orWhere('producer', 'like', $term)
                        ->orWhere('stateId', 'like', $term);
                });
            })
            ->when($request->filled('insuranceType'), fn ($q) => $q->where('insuranceType', $request->string('insuranceType')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderByDesc('startDate')
            ->paginate(25)
            ->withQueryString();

        return view('sales.index', [
            'sales' => $sales,
            'insuranceTypes' => InsuranceType::cases(),
            'statuses' => SaleStatus::cases(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('sales.form', [
            'sale' => new Sale([
                'status' => SaleStatus::Active->value,
                'insuranceType' => InsuranceType::Motor->value,
                'stateId' => $request->query('stateId'),
            ]),
            'owners' => Owner::query()->orderBy('lastName')->get(),
            'insuranceTypes' => InsuranceType::cases(),
            'statuses' => SaleStatus::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $sale = Sale::create($data);

        if ($sale->insuranceType === InsuranceType::Motor->value && $request->filled('regNumber')) {
            Vehicle::create([
                'saleId' => $sale->saleId,
                'regNumber' => $request->input('regNumber'),
                'vehicleType' => $request->input('vehicleType', 'PRIVATE'),
                'make' => $request->input('make'),
                'model' => $request->input('model'),
                'cubicCapacity' => (int) $request->input('cubicCapacity', 0),
                'manufacturedYear' => (int) $request->input('manufacturedYear', (int) date('Y')),
                'vehicleDesign' => $request->input('vehicleDesign', 'SEDAN'),
            ]);
        }

        if ($request->filled('initialDebit')) {
            $this->transactions->record(
                $sale,
                'NEW',
                (float) $request->input('initialDebit'),
                0,
                $sale->producer,
            );
        }

        $this->history->log('CONTRACT', 'CREATE', 'saleId', $sale->saleId, 'Created contract');

        return redirect()->route('sales.show', $sale)->with('success', 'Contract created.');
    }

    public function show(Sale $sale): View
    {
        $sale->load([
            'owner',
            'transactions',
            'vehicles',
            'drivers',
            'coverages',
            'endorsements',
            'medical',
            'lifeIns',
            'propertyFire',
            'employersLiability',
            'medicalInsuredPersons',
        ]);

        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale): View
    {
        return view('sales.form', [
            'sale' => $sale,
            'owners' => Owner::query()->orderBy('lastName')->get(),
            'insuranceTypes' => InsuranceType::cases(),
            'statuses' => SaleStatus::cases(),
        ]);
    }

    public function update(Request $request, Sale $sale): RedirectResponse
    {
        $sale->update($this->validated($request, $sale));
        $this->history->log('CONTRACT', 'UPDATE', 'saleId', $sale->saleId, 'Updated contract');

        return redirect()->route('sales.show', $sale)->with('success', 'Contract updated.');
    }

    public function destroy(Sale $sale): RedirectResponse
    {
        $saleId = $sale->saleId;
        $sale->delete();
        $this->history->log('CONTRACT', 'DELETE', 'saleId', $saleId, 'Deleted contract');

        return redirect()->route('sales.index')->with('success', 'Contract deleted.');
    }

    private function validated(Request $request, ?Sale $sale = null): array
    {
        return $request->validate([
            'saleId' => [
                $sale ? 'sometimes' : 'required',
                'string',
                'max:20',
                Rule::unique('sale', 'saleId')->ignore($sale?->saleId, 'saleId'),
            ],
            'stateId' => ['required', 'string', 'exists:owner,stateId'],
            'company' => ['nullable', 'string', 'max:50'],
            'insuranceType' => ['required', Rule::enum(InsuranceType::class)],
            'coverageType' => ['nullable', 'string', 'max:50'],
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date', 'after_or_equal:startDate'],
            'associate' => ['nullable', 'string', 'max:50'],
            'producer' => ['nullable', 'string', 'max:70'],
            'status' => ['required', Rule::enum(SaleStatus::class)],
        ]);
    }
}

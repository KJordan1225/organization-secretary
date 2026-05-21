<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FinancialTransactionController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        $transactions = FinancialTransaction::query()
            ->when($type, fn ($query) =>
                $query->where('transaction_type', $type)
            )
            ->latest('transaction_date')
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'income_total' => FinancialTransaction::where('transaction_type', 'income')->sum('amount'),

            'expense_total' => FinancialTransaction::where('transaction_type', 'expense')->sum('amount'),
        ];

        $summary['balance'] =
            $summary['income_total'] - $summary['expense_total'];

        return Inertia::render('Finances/Index', [
            'transactions' => $transactions,
            'filters' => [
                'type' => $type,
            ],
            'summary' => $summary,
        ]);
    }

    public function create()
    {
        return Inertia::render('Finances/Create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateTransaction($request);

        FinancialTransaction::create($validated);

        return redirect()
            ->route('finances.index')
            ->with('success', 'Financial transaction created successfully.');
    }

    public function show(FinancialTransaction $finance)
    {
        return Inertia::render('Finances/Show', [
            'finance' => $finance,
        ]);
    }

    public function edit(FinancialTransaction $finance)
    {
        return Inertia::render('Finances/Edit', [
            'finance' => $finance,
        ]);
    }

    public function update(Request $request, FinancialTransaction $finance)
    {
        $validated = $this->validateTransaction($request);

        $finance->update($validated);

        return redirect()
            ->route('finances.index')
            ->with('success', 'Financial transaction updated successfully.');
    }

    public function destroy(FinancialTransaction $finance)
    {
        $finance->delete();

        return redirect()
            ->route('finances.index')
            ->with('success', 'Financial transaction deleted successfully.');
    }

    private function validateTransaction(Request $request): array
    {
        return $request->validate([
            'transaction_type' => ['required', 'string'],
            'category' => ['required', 'string', 'max:150'],
            'amount' => ['required', 'numeric', 'min:0'],
            'transaction_date' => ['required', 'date'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'payee' => ['nullable', 'string', 'max:150'],
            'payer' => ['nullable', 'string', 'max:150'],
            'status' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}

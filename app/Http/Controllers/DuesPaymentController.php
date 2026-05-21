<?php

namespace App\Http\Controllers;

use App\Models\DuesPayment;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DuesPaymentController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $status = $request->input('status');

        $duesPayments = DuesPayment::with('member')
            ->when($year, fn ($query) => $query->where('dues_year', $year))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest('paid_at')
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'total_due' => DuesPayment::where('dues_year', $year)->sum('amount_due'),
            'total_paid' => DuesPayment::where('dues_year', $year)->sum('amount_paid'),
            'unpaid_count' => DuesPayment::where('dues_year', $year)->where('status', 'unpaid')->count(),
            'partial_count' => DuesPayment::where('dues_year', $year)->where('status', 'partial')->count(),
            'paid_count' => DuesPayment::where('dues_year', $year)->where('status', 'paid')->count(),
        ];

        return Inertia::render('Dues/Index', [
            'duesPayments' => $duesPayments,
            'filters' => [
                'year' => $year,
                'status' => $status,
            ],
            'summary' => $summary,
        ]);
    }

    public function create()
    {
        return Inertia::render('Dues/Create', [
            'members' => Member::orderBy('last_name')->orderBy('first_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateDues($request);

        $validated['status'] = $this->calculateStatus(
            $validated['amount_due'],
            $validated['amount_paid']
        );

        DuesPayment::create($validated);

        return redirect()
            ->route('dues.index')
            ->with('success', 'Dues payment record created successfully.');
    }

    public function show(DuesPayment $due)
    {
        $due->load('member');

        return Inertia::render('Dues/Show', [
            'due' => $due,
            'balance' => $due->balance,
        ]);
    }

    public function edit(DuesPayment $due)
    {
        return Inertia::render('Dues/Edit', [
            'due' => $due,
            'members' => Member::orderBy('last_name')->orderBy('first_name')->get(),
        ]);
    }

    public function update(Request $request, DuesPayment $due)
    {
        $validated = $this->validateDues($request, $due);

        $validated['status'] = $this->calculateStatus(
            $validated['amount_due'],
            $validated['amount_paid']
        );

        $due->update($validated);

        return redirect()
            ->route('dues.index')
            ->with('success', 'Dues payment record updated successfully.');
    }

    public function destroy(DuesPayment $due)
    {
        $due->delete();

        return redirect()
            ->route('dues.index')
            ->with('success', 'Dues payment record deleted successfully.');
    }

    private function validateDues(Request $request, ?DuesPayment $due = null): array
    {
        return $request->validate([
            'member_id' => [
                'required',
                'exists:members,id',
                Rule::unique('dues_payments')
                    ->where('dues_year', $request->dues_year)
                    ->ignore($due?->id),
            ],
            'dues_year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'amount_due' => ['required', 'numeric', 'min:0'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'paid_at' => ['nullable', 'date'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'receipt_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function calculateStatus(float $amountDue, float $amountPaid): string
    {
        if ($amountPaid <= 0) {
            return 'unpaid';
        }

        if ($amountPaid < $amountDue) {
            return 'partial';
        }

        return 'paid';
    }
}

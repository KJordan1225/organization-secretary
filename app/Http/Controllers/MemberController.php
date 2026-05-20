<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $members = Member::query()
            ->when($search, function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('member_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Members/Index', [
            'members' => $members,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Members/Create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateMember($request);

        Member::create($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member created successfully.');
    }

    public function show(Member $member)
    {
        return Inertia::render('Members/Show', [
            'member' => $member,
        ]);
    }

    public function edit(Member $member)
    {
        return Inertia::render('Members/Edit', [
            'member' => $member,
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $validated = $this->validateMember($request, $member);

        $member->update($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }

    private function validateMember(Request $request, ?Member $member = null): array
    {
        return $request->validate([
            'member_number' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('members', 'member_number')->ignore($member?->id),
            ],
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'suffix' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'alternate_phone' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'joined_at' => ['nullable', 'date'],
            'membership_status' => ['required', 'string', 'max:50'],
            'membership_type' => ['nullable', 'string', 'max:100'],
            'address_line_1' => ['nullable', 'string', 'max:150'],
            'address_line_2' => ['nullable', 'string', 'max:150'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:50'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}

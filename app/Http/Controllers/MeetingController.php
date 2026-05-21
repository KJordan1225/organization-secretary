<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Member;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::withCount('attendances')
            ->latest('meeting_date')
            ->paginate(10);

        return Inertia::render('Meetings/Index', [
            'meetings' => $meetings,
        ]);
    }

    public function create()
    {
        return Inertia::render('Meetings/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'meeting_date' => ['required', 'date'],
            'start_time' => ['nullable'],
            'location' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
        ]);

        $meeting = Meeting::create($validated);

        return redirect()
            ->route('meetings.attendance.edit', $meeting)
            ->with('success', 'Meeting created. Now mark attendance.');
    }

    public function show(Meeting $meeting)
    {
        $meeting->load(['attendances.member']);

        return Inertia::render('Meetings/Show', [
            'meeting' => $meeting,
        ]);
    }

    public function edit(Meeting $meeting)
    {
        return Inertia::render('Meetings/Edit', [
            'meeting' => $meeting,
        ]);
    }

    public function update(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'meeting_date' => ['required', 'date'],
            'start_time' => ['nullable'],
            'location' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
        ]);

        $meeting->update($validated);

        return redirect()
            ->route('meetings.index')
            ->with('success', 'Meeting updated successfully.');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return redirect()
            ->route('meetings.index')
            ->with('success', 'Meeting deleted successfully.');
    }

    public function editAttendance(Meeting $meeting)
    {
        $members = Member::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $existingAttendance = $meeting->attendances()
            ->get()
            ->keyBy('member_id');

        return Inertia::render('Meetings/Attendance', [
            'meeting' => $meeting,
            'members' => $members,
            'existingAttendance' => $existingAttendance,
        ]);
    }

    public function updateAttendance(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'attendance' => ['required', 'array'],
            'attendance.*.member_id' => ['required', 'exists:members,id'],
            'attendance.*.status' => ['required', 'string'],
            'attendance.*.notes' => ['nullable', 'string'],
        ]);

        foreach ($validated['attendance'] as $row) {
            $meeting->attendances()->updateOrCreate(
                [
                    'member_id' => $row['member_id'],
                ],
                [
                    'status' => $row['status'],
                    'notes' => $row['notes'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('meetings.show', $meeting)
            ->with('success', 'Attendance saved successfully.');
    }
}

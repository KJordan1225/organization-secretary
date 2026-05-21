<script setup>
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
    meeting: Object,
})

function deleteMeeting() {
    if (confirm(`Delete meeting: ${props.meeting.title}?`)) {
        router.delete(`/meetings/${props.meeting.id}`)
    }
}
</script>

<template>
    <div class="container py-4">
        <div class="org-page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1">{{ meeting.title }}</h1>
                <p class="mb-0">{{ meeting.meeting_date }}</p>
            </div>

            <div class="d-flex gap-2">
                <Link :href="`/meetings/${meeting.id}/attendance`" class="btn btn-org-gold">
                    Attendance
                </Link>

                <Link :href="`/meetings/${meeting.id}/edit`" class="btn btn-light">
                    Edit
                </Link>

                <button class="btn btn-outline-light" @click="deleteMeeting">
                    Delete
                </button>
            </div>
        </div>

        <div class="card org-card mb-4">
            <div class="card-body">
                <h5 class="text-uppercase text-muted">Meeting Details</h5>

                <p><strong>Date:</strong> {{ meeting.meeting_date }}</p>
                <p><strong>Start Time:</strong> {{ meeting.start_time || '—' }}</p>
                <p><strong>Location:</strong> {{ meeting.location || '—' }}</p>
                <p><strong>Description:</strong> {{ meeting.description || '—' }}</p>
            </div>
        </div>

        <div class="card org-card">
            <div class="card-body table-responsive">
                <h5 class="text-uppercase text-muted mb-3">Attendance List</h5>

                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="record in meeting.attendances" :key="record.id">
                            <td>
                                {{ record.member.first_name }}
                                {{ record.member.last_name }}
                            </td>
                            <td>
                                <span class="badge badge-org">
                                    {{ record.status }}
                                </span>
                            </td>
                            <td>{{ record.notes || '—' }}</td>
                        </tr>

                        <tr v-if="meeting.attendances.length === 0">
                            <td colspan="3" class="text-center text-muted py-4">
                                Attendance has not been recorded for this meeting.
                            </td>
                        </tr>
                    </tbody>
                </table>

                <Link href="/meetings" class="btn btn-outline-secondary mt-3">
                    Back to Meetings
                </Link>
            </div>
        </div>
    </div>
</template>

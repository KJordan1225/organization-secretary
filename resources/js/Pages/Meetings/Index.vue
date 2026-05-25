<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import OrganizationSecretaryLayout from '@/Layouts/OrganizationSecretaryLayout.vue';


defineProps({
    meetings: Object,
})

const page = usePage()

function deleteMeeting(meeting) {
    if (confirm(`Delete meeting: ${meeting.title}?`)) {
        router.delete(`/meetings/${meeting.id}`)
    }
}
</script>

<template>
    <OrganizationSecretaryLayout title="Meetings">
        <div class="container py-4">
            <div class="org-page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1">Meeting Attendance</h1>
                <p class="mb-0">Track meeting dates, locations, and member attendance.</p>
            </div>

            <Link href="/meetings/create" class="btn btn-org-gold">
                Add Meeting
            </Link>
        </div>

        <div v-if="page.props.flash?.success" class="alert alert-success">
            {{ page.props.flash.success }}
        </div>

        <div class="card org-card">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Meeting</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Attendance Count</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="meeting in meetings.data" :key="meeting.id">
                            <td>{{ meeting.title }}</td>
                            <td>{{ meeting.meeting_date }}</td>
                            <td>{{ meeting.start_time || '—' }}</td>
                            <td>{{ meeting.location || '—' }}</td>
                            <td>
                                <span class="badge badge-org">
                                    {{ meeting.attendances_count }}
                                </span>
                            </td>
                            <td class="text-end">
                                <Link :href="`/meetings/${meeting.id}`" class="btn btn-sm btn-outline-secondary me-1">
                                    View
                                </Link>

                                <Link :href="`/meetings/${meeting.id}/attendance`" class="btn btn-sm btn-org-gold me-1">
                                    Attendance
                                </Link>

                                <Link :href="`/meetings/${meeting.id}/edit`" class="btn btn-sm btn-org-primary me-1">
                                    Edit
                                </Link>

                                <button class="btn btn-sm btn-outline-danger" @click="deleteMeeting(meeting)">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <tr v-if="meetings.data.length === 0">
                            <td colspan="6" class="text-center text-muted py-4">
                                No meetings found.
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex gap-2 mt-3">
                    <Link
                        v-for="link in meetings.links"
                        :key="link.label"
                        :href="link.url || '#'"
                        class="btn btn-sm"
                        :class="link.active ? 'btn-org-primary' : 'btn-outline-secondary'"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
    </div>
    </OrganizationSecretaryLayout>
</template>

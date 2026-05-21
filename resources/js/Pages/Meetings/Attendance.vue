<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    meeting: Object,
    members: Array,
    existingAttendance: Object,
})

const form = useForm({
    attendance: props.members.map(member => {
        const record = props.existingAttendance[member.id]

        return {
            member_id: member.id,
            name: `${member.first_name} ${member.last_name}`,
            member_number: member.member_number,
            status: record?.status || 'absent',
            notes: record?.notes || '',
        }
    }),
})

function submit() {
    form.put(`/meetings/${props.meeting.id}/attendance`)
}
</script>

<template>
    <div class="container py-4">
        <div class="org-page-header mb-4">
            <h1 class="mb-1">Mark Attendance</h1>
            <p class="mb-0">
                {{ meeting.title }} — {{ meeting.meeting_date }}
            </p>
        </div>

        <div class="card org-card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Member #</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(row, index) in form.attendance" :key="row.member_id">
                                    <td>{{ row.member_number || '—' }}</td>
                                    <td>{{ row.name }}</td>
                                    <td style="width: 220px;">
                                        <select v-model="row.status" class="form-select">
                                            <option value="present">Present</option>
                                            <option value="absent">Absent</option>
                                            <option value="excused">Excused</option>
                                            <option value="late">Late</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input v-model="row.notes" class="form-control" placeholder="Optional notes" />
                                    </td>
                                </tr>

                                <tr v-if="form.attendance.length === 0">
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No members found. Add members first.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-org-primary" :disabled="form.processing">
                            Save Attendance
                        </button>

                        <Link href="/meetings" class="btn btn-outline-secondary">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

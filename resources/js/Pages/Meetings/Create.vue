<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import OrganizationSecretaryLayout from '@/Layouts/OrganizationSecretaryLayout.vue';


const form = useForm({
    title: '',
    meeting_date: '',
    start_time: '',
    location: '',
    description: '',
})

function submit() {
    form.post('/meetings')
}
</script>

<template>
    <OrganizationSecretaryLayout title="Add Meeting">
    <div class="container py-4">
        <div class="org-page-header mb-4">
            <h1 class="mb-1">Add Meeting</h1>
            <p class="mb-0">Create a meeting before marking attendance.</p>
        </div>

        <div class="card org-card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Meeting Title *</label>
                            <input v-model="form.title" class="form-control" />
                            <div class="text-danger small">{{ form.errors.title }}</div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Meeting Date *</label>
                            <input v-model="form.meeting_date" type="date" class="form-control" />
                            <div class="text-danger small">{{ form.errors.meeting_date }}</div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Start Time</label>
                            <input v-model="form.start_time" type="time" class="form-control" />
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Location</label>
                            <input v-model="form.location" class="form-control" />
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea v-model="form.description" class="form-control" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-org-primary" :disabled="form.processing">
                            Save Meeting
                        </button>

                        <Link href="/meetings" class="btn btn-outline-secondary">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </OrganizationSecretaryLayout>
</template>

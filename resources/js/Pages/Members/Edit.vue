<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    member: Object,
})

const form = useForm({
    member_number: props.member.member_number || '',
    first_name: props.member.first_name || '',
    middle_name: props.member.middle_name || '',
    last_name: props.member.last_name || '',
    suffix: props.member.suffix || '',
    email: props.member.email || '',
    phone: props.member.phone || '',
    alternate_phone: props.member.alternate_phone || '',
    date_of_birth: props.member.date_of_birth || '',
    joined_at: props.member.joined_at || '',
    membership_status: props.member.membership_status || 'active',
    membership_type: props.member.membership_type || '',
    address_line_1: props.member.address_line_1 || '',
    address_line_2: props.member.address_line_2 || '',
    city: props.member.city || '',
    state: props.member.state || '',
    postal_code: props.member.postal_code || '',
    notes: props.member.notes || '',
})

function submit() {
    form.put(`/members/${props.member.id}`)
}
</script>

<template>
    <div class="container py-4">
        <div class="org-page-header mb-4">
            <h1 class="mb-1">Edit Member</h1>
            <p class="mb-0">Update membership record.</p>
        </div>

        <div class="card org-card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Member Number</label>
                            <input v-model="form.member_number" class="form-control" />
                            <div class="text-danger small">{{ form.errors.member_number }}</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">First Name *</label>
                            <input v-model="form.first_name" class="form-control" />
                            <div class="text-danger small">{{ form.errors.first_name }}</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Middle Name</label>
                            <input v-model="form.middle_name" class="form-control" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Last Name *</label>
                            <input v-model="form.last_name" class="form-control" />
                            <div class="text-danger small">{{ form.errors.last_name }}</div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Suffix</label>
                            <input v-model="form.suffix" class="form-control" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input v-model="form.email" type="email" class="form-control" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Phone</label>
                            <input v-model="form.phone" class="form-control" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Alternate Phone</label>
                            <input v-model="form.alternate_phone" class="form-control" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Date of Birth</label>
                            <input v-model="form.date_of_birth" type="date" class="form-control" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Joined Date</label>
                            <input v-model="form.joined_at" type="date" class="form-control" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status *</label>
                            <select v-model="form.membership_status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                                <option value="deceased">Deceased</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Membership Type</label>
                            <input v-model="form.membership_type" class="form-control" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Address Line 1</label>
                            <input v-model="form.address_line_1" class="form-control" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Address Line 2</label>
                            <input v-model="form.address_line_2" class="form-control" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input v-model="form.city" class="form-control" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input v-model="form.state" class="form-control" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Postal Code</label>
                            <input v-model="form.postal_code" class="form-control" />
                        </div>

                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea v-model="form.notes" class="form-control" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-org-primary" :disabled="form.processing">
                            Update Member
                        </button>

                        <Link href="/members" class="btn btn-outline-secondary">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

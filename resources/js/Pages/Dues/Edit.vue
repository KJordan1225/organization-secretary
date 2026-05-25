<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import OrganizationSecretaryLayout from '@/Layouts/OrganizationSecretaryLayout.vue';


const props = defineProps({
    due: Object,
    members: Array,
})

const form = useForm({
    member_id: props.due.member_id,
    dues_year: props.due.dues_year,
    amount_due: props.due.amount_due,
    amount_paid: props.due.amount_paid,
    paid_at: props.due.paid_at || '',
    payment_method: props.due.payment_method || '',
    receipt_number: props.due.receipt_number || '',
    notes: props.due.notes || '',
})

function submit() {
    form.put(`/dues/${props.due.id}`)
}
</script>

<template>
    <OrganizationSecretaryLayout title="Edit Dues Record">
        <div class="container py-4">
            <div class="org-page-header mb-4">
                <h1 class="mb-1">Edit Dues Record</h1>
                <p class="mb-0">Update annual dues payment information.</p>
            </div>

        <div class="card org-card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Member *</label>
                            <select v-model="form.member_id" class="form-select">
                                <option v-for="member in members" :key="member.id" :value="member.id">
                                    {{ member.last_name }}, {{ member.first_name }}
                                </option>
                            </select>
                            <div class="text-danger small">{{ form.errors.member_id }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Dues Year *</label>
                            <input v-model="form.dues_year" type="number" class="form-control" />
                            <div class="text-danger small">{{ form.errors.dues_year }}</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Amount Due *</label>
                            <input v-model="form.amount_due" type="number" step="0.01" class="form-control" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Amount Paid *</label>
                            <input v-model="form.amount_paid" type="number" step="0.01" class="form-control" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Paid Date</label>
                            <input v-model="form.paid_at" type="date" class="form-control" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Payment Method</label>
                            <select v-model="form.payment_method" class="form-select">
                                <option value="">Select Method</option>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                                <option value="card">Card</option>
                                <option value="zelle">Zelle</option>
                                <option value="cashapp">Cash App</option>
                                <option value="paypal">PayPal</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Receipt Number</label>
                            <input v-model="form.receipt_number" class="form-control" />
                        </div>

                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea v-model="form.notes" class="form-control" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-org-primary" :disabled="form.processing">
                            Update Dues Record
                        </button>

                        <Link href="/dues" class="btn btn-outline-secondary">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </OrganizationSecretaryLayout>
</template>

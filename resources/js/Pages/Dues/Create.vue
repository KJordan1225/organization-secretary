<script setup>
import { Link, useForm } from '@inertiajs/vue3'

defineProps({
    members: Array,
})

const form = useForm({
    member_id: '',
    dues_year: new Date().getFullYear(),
    amount_due: '0.00',
    amount_paid: '0.00',
    paid_at: '',
    payment_method: '',
    receipt_number: '',
    notes: '',
})

function submit() {
    form.post('/dues')
}
</script>

<template>
    <div class="container py-4">
        <div class="org-page-header mb-4">
            <h1 class="mb-1">Add Dues Record</h1>
            <p class="mb-0">Record annual member dues.</p>
        </div>

        <div class="card org-card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Member *</label>
                            <select v-model="form.member_id" class="form-select">
                                <option value="">Select Member</option>
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
                            Save Dues Record
                        </button>

                        <Link href="/dues" class="btn btn-outline-secondary">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

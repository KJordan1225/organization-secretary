<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import OrganizationSecretaryLayout from '@/Layouts/OrganizationSecretaryLayout.vue';


const form = useForm({
    transaction_type: 'income',
    category: '',
    amount: '',
    transaction_date: '',
    payment_method: '',
    reference_number: '',
    payee: '',
    payer: '',
    status: 'completed',
    description: '',
    notes: '',
})

function submit() {
    form.post('/finances')
}
</script>

<template>
    <OrganizationSecretaryLayout title="Add Transaction">
    <div class="container py-4">

    <div class="org-page-header mb-4">
        <h1 class="mb-1">Add Transaction</h1>
        <p class="mb-0">Record organization financial activity.</p>
    </div>

    <div class="card org-card">
        <div class="card-body">

            <form @submit.prevent="submit">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Transaction Type *</label>

                        <select v-model="form.transaction_type" class="form-select">
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Category *</label>

                        <input
                            v-model="form.category"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Amount *</label>

                        <input
                            v-model="form.amount"
                            type="number"
                            step="0.01"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Transaction Date *</label>

                        <input
                            v-model="form.transaction_date"
                            type="date"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Payment Method</label>

                        <select
                            v-model="form.payment_method"
                            class="form-select"
                        >
                            <option value="">Select Method</option>
                            <option value="cash">Cash</option>
                            <option value="check">Check</option>
                            <option value="card">Card</option>
                            <option value="paypal">PayPal</option>
                            <option value="cashapp">Cash App</option>
                            <option value="zelle">Zelle</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Reference Number</label>

                        <input
                            v-model="form.reference_number"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Payer</label>

                        <input
                            v-model="form.payer"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Payee</label>

                        <input
                            v-model="form.payee"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>

                        <select v-model="form.status" class="form-select">
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="void">Void</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>

                        <textarea
                            v-model="form.description"
                            class="form-control"
                            rows="4"
                        ></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Notes</label>

                        <textarea
                            v-model="form.notes"
                            class="form-control"
                            rows="4"
                        ></textarea>
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">

                    <button
                        class="btn btn-org-primary"
                        :disabled="form.processing"
                    >
                        Save Transaction
                    </button>

                    <Link href="/finances" class="btn btn-outline-secondary">
                        Cancel
                    </Link>

                </div>

            </form>

        </div>
    </div>

</div>
    </OrganizationSecretaryLayout>
</template>

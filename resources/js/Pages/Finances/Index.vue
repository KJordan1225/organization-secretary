<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import OrganizationSecretaryLayout from '@/Layouts/OrganizationSecretaryLayout.vue';


const props = defineProps({
    transactions: Object,
    filters: Object,
    summary: Object,
})

const page = usePage()

const type = ref(props.filters.type || '')

function applyFilters() {
    router.get('/finances', {
        type: type.value,
    }, {
        preserveState: true,
        replace: true,
    })
}

function deleteTransaction(transaction) {
    if (confirm('Delete this transaction?')) {
        router.delete(`/finances/${transaction.id}`)
    }
}

function money(value) {
    return Number(value || 0).toFixed(2)
}
</script>

<template>
    <OrganizationSecretaryLayout title="Finances">
<div class="container py-4">

    <div class="org-page-header mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">Finances</h1>
            <p class="mb-0">
                Track incoming and outgoing organization funds.
            </p>
        </div>

        <Link href="/finances/create" class="btn btn-org-gold">
            Add Transaction
        </Link>
    </div>

    <div v-if="page.props.flash?.success" class="alert alert-success">
        {{ page.props.flash.success }}
    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card org-card">
                <div class="card-body">
                    <div class="text-muted">Total Income</div>
                    <h3>${{ money(summary.income_total) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card org-card">
                <div class="card-body">
                    <div class="text-muted">Total Expenses</div>
                    <h3>${{ money(summary.expense_total) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card org-card">
                <div class="card-body">
                    <div class="text-muted">Balance</div>
                    <h3>${{ money(summary.balance) }}</h3>
                </div>
            </div>
        </div>

    </div>

    <div class="card org-card mb-4">
        <div class="card-body">

            <div class="row g-2">

                <div class="col-md-8">
                    <select v-model="type" class="form-select">
                        <option value="">All Transactions</option>
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                </div>

                <div class="col-md-4 d-grid">
                    <button class="btn btn-org-primary" @click="applyFilters">
                        Filter
                    </button>
                </div>

            </div>

        </div>
    </div>

    <div class="card org-card">
        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <tr
                        v-for="transaction in transactions.data"
                        :key="transaction.id"
                    >
                        <td>{{ transaction.transaction_date }}</td>
                        <td>
                            <span class="badge badge-org">
                                {{ transaction.transaction_type }}
                            </span>
                        </td>
                        <td>{{ transaction.category }}</td>
                        <td>${{ money(transaction.amount) }}</td>
                        <td>{{ transaction.payment_method || '—' }}</td>
                        <td>{{ transaction.status }}</td>

                        <td class="text-end">

                            <Link
                                :href="`/finances/${transaction.id}`"
                                class="btn btn-sm btn-outline-secondary me-1"
                            >
                                View
                            </Link>

                            <Link
                                :href="`/finances/${transaction.id}/edit`"
                                class="btn btn-sm btn-org-primary me-1"
                            >
                                Edit
                            </Link>

                            <button
                                class="btn btn-sm btn-outline-danger"
                                @click="deleteTransaction(transaction)"
                            >
                                Delete
                            </button>

                        </td>
                    </tr>

                    <tr v-if="transactions.data.length === 0">
                        <td colspan="7" class="text-center text-muted py-4">
                            No transactions found.
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>
    </div>

</div>
    </OrganizationSecretaryLayout>
</template>

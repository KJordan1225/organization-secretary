<script setup>
import { Link, router } from '@inertiajs/vue3'
import OrganizationSecretaryLayout from '@/Layouts/OrganizationSecretaryLayout.vue';


const props = defineProps({
    finance: Object,
})

function money(value) {
    return Number(value || 0).toFixed(2)
}

function deleteTransaction() {
    if (confirm('Delete this transaction?')) {
        router.delete(`/finances/${props.finance.id}`)
    }
}
</script>

<template>
    <OrganizationSecretaryLayout title="View Transaction">
<div class="container py-4">

    <div class="org-page-header mb-4 d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-1">
                Financial Transaction
            </h1>

            <p class="mb-0">
                {{ finance.transaction_date }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <Link
                :href="`/finances/${finance.id}/edit`"
                class="btn btn-org-gold"
            >
                Edit
            </Link>

            <button
                class="btn btn-outline-light"
                @click="deleteTransaction"
            >
                Delete
            </button>

        </div>

    </div>

    <div class="card org-card">
        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-6">

                    <h5 class="text-uppercase text-muted">
                        Transaction Details
                    </h5>

                    <p>
                        <strong>Type:</strong>
                        {{ finance.transaction_type }}
                    </p>

                    <p>
                        <strong>Category:</strong>
                        {{ finance.category }}
                    </p>

                    <p>
                        <strong>Amount:</strong>
                        ${{ money(finance.amount) }}
                    </p>

                    <p>
                        <strong>Date:</strong>
                        {{ finance.transaction_date }}
                    </p>

                    <p>
                        <strong>Status:</strong>
                        {{ finance.status }}
                    </p>

                </div>

                <div class="col-md-6">

                    <h5 class="text-uppercase text-muted">
                        Payment Details
                    </h5>

                    <p>
                        <strong>Method:</strong>
                        {{ finance.payment_method || '—' }}
                    </p>

                    <p>
                        <strong>Reference #:</strong>
                        {{ finance.reference_number || '—' }}
                    </p>

                    <p>
                        <strong>Payer:</strong>
                        {{ finance.payer || '—' }}
                    </p>

                    <p>
                        <strong>Payee:</strong>
                        {{ finance.payee || '—' }}
                    </p>

                </div>

                <div class="col-12">

                    <h5 class="text-uppercase text-muted">
                        Description
                    </h5>

                    <p>{{ finance.description || '—' }}</p>

                </div>

                <div class="col-12">

                    <h5 class="text-uppercase text-muted">
                        Notes
                    </h5>

                    <p>{{ finance.notes || '—' }}</p>

                </div>

            </div>

            <div class="mt-4">
                <Link href="/finances" class="btn btn-outline-secondary">
                    Back to Finances
                </Link>
            </div>

        </div>
    </div>

</div>
    </OrganizationSecretaryLayout>
</template>

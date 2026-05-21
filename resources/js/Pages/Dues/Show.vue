<script setup>
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
    due: Object,
    balance: Number,
})

function money(value) {
    return Number(value || 0).toFixed(2)
}

function deleteDue() {
    if (confirm('Delete this dues payment record?')) {
        router.delete(`/dues/${props.due.id}`)
    }
}
</script>

<template>
    <div class="container py-4">
        <div class="org-page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1">Dues Record</h1>
                <p class="mb-0">
                    {{ due.member.first_name }} {{ due.member.last_name }} — {{ due.dues_year }}
                </p>
            </div>

            <div class="d-flex gap-2">
                <Link :href="`/dues/${due.id}/edit`" class="btn btn-org-gold">
                    Edit
                </Link>

                <button class="btn btn-outline-light" @click="deleteDue">
                    Delete
                </button>
            </div>
        </div>

        <div class="card org-card">
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h5 class="text-uppercase text-muted">Member</h5>

                        <p><strong>Name:</strong> {{ due.member.first_name }} {{ due.member.last_name }}</p>
                        <p><strong>Member #:</strong> {{ due.member.member_number || '—' }}</p>
                        <p><strong>Email:</strong> {{ due.member.email || '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-uppercase text-muted">Dues</h5>

                        <p><strong>Year:</strong> {{ due.dues_year }}</p>
                        <p><strong>Status:</strong> <span class="badge badge-org">{{ due.status }}</span></p>
                        <p><strong>Amount Due:</strong> ${{ money(due.amount_due) }}</p>
                        <p><strong>Amount Paid:</strong> ${{ money(due.amount_paid) }}</p>
                        <p><strong>Balance:</strong> ${{ money(balance) }}</p>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-uppercase text-muted">Payment Info</h5>

                        <p><strong>Paid Date:</strong> {{ due.paid_at || '—' }}</p>
                        <p><strong>Payment Method:</strong> {{ due.payment_method || '—' }}</p>
                        <p><strong>Receipt Number:</strong> {{ due.receipt_number || '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-uppercase text-muted">Notes</h5>
                        <p>{{ due.notes || 'No notes entered.' }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <Link href="/dues" class="btn btn-outline-secondary">
                        Back to Dues
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

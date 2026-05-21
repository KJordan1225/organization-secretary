<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    duesPayments: Object,
    filters: Object,
    summary: Object,
})

const page = usePage()

const year = ref(props.filters.year || new Date().getFullYear())
const status = ref(props.filters.status || '')

function applyFilters() {
    router.get('/dues', {
        year: year.value,
        status: status.value,
    }, {
        preserveState: true,
        replace: true,
    })
}

function deleteDue(due) {
    if (confirm('Delete this dues payment record?')) {
        router.delete(`/dues/${due.id}`)
    }
}

function money(value) {
    return Number(value || 0).toFixed(2)
}
</script>

<template>
    <div class="container py-4">
        <div class="org-page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1">Dues</h1>
                <p class="mb-0">Track annual dues owed and paid by members.</p>
            </div>

            <Link href="/dues/create" class="btn btn-org-gold">
                Add Dues Record
            </Link>
        </div>

        <div v-if="page.props.flash?.success" class="alert alert-success">
            {{ page.props.flash.success }}
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card org-card">
                    <div class="card-body">
                        <div class="text-muted">Total Due</div>
                        <h3>${{ money(summary.total_due) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card org-card">
                    <div class="card-body">
                        <div class="text-muted">Total Paid</div>
                        <h3>${{ money(summary.total_paid) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card org-card">
                    <div class="card-body">
                        <div class="text-muted">Paid</div>
                        <h3>{{ summary.paid_count }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card org-card">
                    <div class="card-body">
                        <div class="text-muted">Partial</div>
                        <h3>{{ summary.partial_count }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card org-card">
                    <div class="card-body">
                        <div class="text-muted">Unpaid</div>
                        <h3>{{ summary.unpaid_count }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card org-card mb-4">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input v-model="year" type="number" class="form-control" placeholder="Year" />
                    </div>

                    <div class="col-md-4">
                        <select v-model="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="paid">Paid</option>
                            <option value="partial">Partial</option>
                            <option value="unpaid">Unpaid</option>
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
                            <th>Member</th>
                            <th>Year</th>
                            <th>Due</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Paid Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="due in duesPayments.data" :key="due.id">
                            <td>{{ due.member.first_name }} {{ due.member.last_name }}</td>
                            <td>{{ due.dues_year }}</td>
                            <td>${{ money(due.amount_due) }}</td>
                            <td>${{ money(due.amount_paid) }}</td>
                            <td>${{ money(due.amount_due - due.amount_paid) }}</td>
                            <td>
                                <span class="badge badge-org">
                                    {{ due.status }}
                                </span>
                            </td>
                            <td>{{ due.paid_at || '—' }}</td>
                            <td class="text-end">
                                <Link :href="`/dues/${due.id}`" class="btn btn-sm btn-outline-secondary me-1">
                                    View
                                </Link>

                                <Link :href="`/dues/${due.id}/edit`" class="btn btn-sm btn-org-primary me-1">
                                    Edit
                                </Link>

                                <button class="btn btn-sm btn-outline-danger" @click="deleteDue(due)">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <tr v-if="duesPayments.data.length === 0">
                            <td colspan="8" class="text-center text-muted py-4">
                                No dues records found.
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex gap-2 mt-3">
                    <Link
                        v-for="link in duesPayments.links"
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
</template>

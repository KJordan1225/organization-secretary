<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import OrganizationSecretaryLayout from '@/Layouts/OrganizationSecretaryLayout.vue';


const props = defineProps({
    finance: Object,
})

const form = useForm({
    transaction_type: props.finance.transaction_type,
    category: props.finance.category,
    amount: props.finance.amount,
    transaction_date: props.finance.transaction_date,
    payment_method: props.finance.payment_method || '',
    reference_number: props.finance.reference_number || '',
    payee: props.finance.payee || '',
    payer: props.finance.payer || '',
    status: props.finance.status,
    description: props.finance.description || '',
    notes: props.finance.notes || '',
})

function submit() {
    form.put(`/finances/${props.finance.id}`)
}
</script>

<template>
    <OrganizationSecretaryLayout title="Edit Transaction">
        <div class="container py-4">
            <div class="org-page-header mb-4">
                <h1 class="mb-1">Edit Transaction</h1>
            </div>

    <div class="card org-card">
        <div class="card-body">

            <form @submit.prevent="submit">

                <!-- Same fields as Create.vue -->

                <div class="mt-4 d-flex gap-2">

                    <button class="btn btn-org-primary">
                        Update Transaction
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

<script setup>
import { Link, router } from '@inertiajs/vue3'
import OrganizationSecretaryLayout from '@/Layouts/OrganizationSecretaryLayout.vue';

const props = defineProps({
    member: Object,
})

function deleteMember() {
    if (confirm(`Delete ${props.member.first_name} ${props.member.last_name}?`)) {
        router.delete(`/members/${props.member.id}`)
    }
}
</script>

<template>
    <OrganizationSecretaryLayout title="Member Profile">
    <div class="container py-4">
        <div class="org-page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1">
                    {{ member.first_name }} {{ member.last_name }}
                </h1>
                <p class="mb-0">Member Profile</p>
            </div>

            <div class="d-flex gap-2">
                <Link :href="`/members/${member.id}/edit`" class="btn btn-org-gold">
                    Edit
                </Link>

                <button class="btn btn-outline-light" @click="deleteMember">
                    Delete
                </button>
            </div>
        </div>

        <div class="card org-card">
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h5 class="text-uppercase text-muted">Membership</h5>

                        <p><strong>Member #:</strong> {{ member.member_number || '—' }}</p>
                        <p><strong>Status:</strong> <span class="badge badge-org">{{ member.membership_status }}</span></p>
                        <p><strong>Type:</strong> {{ member.membership_type || '—' }}</p>
                        <p><strong>Joined:</strong> {{ member.joined_at || '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-uppercase text-muted">Contact</h5>

                        <p><strong>Email:</strong> {{ member.email || '—' }}</p>
                        <p><strong>Phone:</strong> {{ member.phone || '—' }}</p>
                        <p><strong>Alternate Phone:</strong> {{ member.alternate_phone || '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-uppercase text-muted">Personal</h5>

                        <p><strong>First Name:</strong> {{ member.first_name }}</p>
                        <p><strong>Middle Name:</strong> {{ member.middle_name || '—' }}</p>
                        <p><strong>Last Name:</strong> {{ member.last_name }}</p>
                        <p><strong>Suffix:</strong> {{ member.suffix || '—' }}</p>
                        <p><strong>Date of Birth:</strong> {{ member.date_of_birth || '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-uppercase text-muted">Address</h5>

                        <p>{{ member.address_line_1 || '—' }}</p>
                        <p>{{ member.address_line_2 || '' }}</p>
                        <p>
                            {{ member.city || '' }}
                            {{ member.state || '' }}
                            {{ member.postal_code || '' }}
                        </p>
                    </div>

                    <div class="col-12">
                        <h5 class="text-uppercase text-muted">Notes</h5>
                        <p>{{ member.notes || 'No notes entered.' }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <Link href="/members" class="btn btn-outline-secondary">
                        Back to Members
                    </Link>
                </div>
            </div>
        </div>
    </div>
    </OrganizationSecretaryLayout>
</template>

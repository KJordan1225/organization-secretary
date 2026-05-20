<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    members: Object,
    filters: Object,
})

const search = ref(props.filters.search || '')
const page = usePage()

function submitSearch() {
    router.get('/members', { search: search.value }, {
        preserveState: true,
        replace: true,
    })
}

function deleteMember(member) {
    if (confirm(`Delete ${member.first_name} ${member.last_name}?`)) {
        router.delete(`/members/${member.id}`)
    }
}
</script>

<template>
    <div class="container py-4">
        <div class="org-page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1">Members</h1>
                <p class="mb-0">Organization Secretary Membership Registry</p>
            </div>

            <Link href="/members/create" class="btn btn-org-gold">
                Add Member
            </Link>
        </div>

        <div v-if="page.props.flash?.success" class="alert alert-success">
            {{ page.props.flash.success }}
        </div>

        <div class="card org-card mb-4">
            <div class="card-body">
                <form @submit.prevent="submitSearch" class="row g-2">
                    <div class="col-md-10">
                        <input
                            v-model="search"
                            type="text"
                            class="form-control"
                            placeholder="Search by name, email, or member number"
                        />
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-org-primary">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card org-card">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Member #</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="member in members.data" :key="member.id">
                            <td>{{ member.member_number || '—' }}</td>
                            <td>{{ member.first_name }} {{ member.last_name }}</td>
                            <td>{{ member.email || '—' }}</td>
                            <td>{{ member.phone || '—' }}</td>
                            <td>
                                <span class="badge badge-org">
                                    {{ member.membership_status }}
                                </span>
                            </td>
                            <td>{{ member.joined_at || '—' }}</td>
                            <td class="text-end">
                                <Link :href="`/members/${member.id}`" class="btn btn-sm btn-outline-secondary me-1">
                                    View
                                </Link>

                                <Link :href="`/members/${member.id}/edit`" class="btn btn-sm btn-org-primary me-1">
                                    Edit
                                </Link>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    @click="deleteMember(member)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <tr v-if="members.data.length === 0">
                            <td colspan="7" class="text-center text-muted py-4">
                                No members found.
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex gap-2 mt-3">
                    <Link
                        v-for="link in members.links"
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

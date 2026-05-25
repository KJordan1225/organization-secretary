<!-- resources/js/Layouts/OrganizationSecretaryLayout.vue -->

<template>
    <div class="org-layout">
        <aside class="org-sidebar">
            <div class="org-sidebar-brand">
                Organization Secretary
            </div>

            <Link href="/dashboard">Dashboard</Link>
            <Link href="/members">Members</Link>
            <Link href="/finances">Finances</Link>
            <Link href="/meetings">Meetings</Link>
            <Link href="/dues">Dues</Link>
            <!-- <Link href="/events">Events</Link>
            <Link href="/attendance">Attendance</Link>
            <Link href="/announcements">Announcements</Link>
            <Link href="/documents">Documents</Link>
            <Link href="/tasks">Tasks</Link>
            <Link href="/reports">Reports</Link> 
            <Link href="/organization-settings">Organization Settings</Link>
            <Link href="/profile">Profile</Link> -->
        </aside>

        <main class="org-main">
            <header class="org-topbar">
                <div>
                    <strong>{{ title }}</strong>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span>{{ userName }}</span>

                    <form method="post" action="/logout">
                        <input type="hidden" name="_token" :value="csrfToken">

                        <button class="btn btn-sm btn-org-primary" type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <section class="org-content">
                <FlashMessage />

                <slot />
            </section>
        </main>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        default: 'Organization Secretary',
    },
});

const page = usePage();

const userName = computed(() => {
    return page.props.auth?.user?.name || 'User';
});

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content') || '';
</script>

<style scoped>
.org-layout {
    min-height: 100vh;
    display: flex;
    background: #f4f6f9;
}

.org-sidebar {
    width: 260px;
    min-height: 100vh;
    background: #4b0082;
    color: #ffffff;
    padding: 1rem;
    display: flex;
    flex-direction: column;
}

.org-sidebar-brand {
    font-size: 1.25rem;
    font-weight: 700;
    padding: 0.75rem 0.5rem 1.25rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    margin-bottom: 1rem;
}

.org-sidebar a {
    color: #d1d5db;
    text-decoration: none;
    padding: 0.7rem 0.85rem;
    border-radius: 0.5rem;
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.org-sidebar a:hover {
    background: #4b0082;
    color: #ffffff;
}

.org-main {
    flex: 1;
    min-width: 0;
}

.org-topbar {
    height: 64px;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    padding: 0 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.org-content {
    padding: 1.5rem;
}

.btn-org-primary {
    background: #4b0082;
    border-color: #4b0082;
    color: #ffffff;
}

.btn-org-primary:hover {
    background: #3a0066;
    border-color: #3a0066;
    color: #ffffff;
}

@media (max-width: 768px) {
    .org-layout {
        flex-direction: column;
    }

    .org-sidebar {
        width: 100%;
        min-height: auto;
    }

    .org-topbar {
        height: auto;
        gap: 1rem;
        padding: 1rem;
        flex-direction: column;
        align-items: flex-start;
    }

    .org-content {
        padding: 1rem;
    }
}
</style>
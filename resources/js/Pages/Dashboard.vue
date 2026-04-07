<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

onMounted(() => {
    router.visit('/hoy');
});
</script>

<template>
    <Head title="Hoy" />
    <div>Redirecting...</div>
</template>

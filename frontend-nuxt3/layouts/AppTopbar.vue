<script setup>
    import {
        useLayout
    } from './composable/layout';
    const {
        layoutConfig,
        onMenuToggle
    } = useLayout();

    const logoUrl = computed(() => {
        return `/layout/images/${layoutConfig.darkTheme.value ? 'logo-white' : 'logo-dark'}.svg`;
    });

    const auth = useAuthStore();
    const errors = ref([]);
    const logOut = async () => {
        try {
            await auth.logout()
            errors.value = [];
        } catch (error) {
            console.log(error);
            errors.value = error.data.errors;
        }
    }
</script>

<template>
    <div class="layout-topbar">
        <router-link to="/" class="layout-topbar-logo">
            <img :src="logoUrl" alt="logo" />
            <span>Modern HMS</span>
        </router-link>

        <button class="p-link layout-menu-button layout-topbar-button" @click="onMenuToggle()">
            <i class="pi pi-bars"></i>
        </button>

        <button class="p-link layout-topbar-menu-button layout-topbar-button">
            <i class="pi pi-ellipsis-v"></i>
        </button>

        <div class="layout-topbar-menu">
            <button class="p-link layout-topbar-button" @click.prevent="logOut">
                <i class="pi pi-sign-out"></i>
                <span>logout</span>
            </button>
            <button class="p-link layout-topbar-button">
                <i class="pi pi-user"></i>
                <span>Profile</span>
            </button>
            <button class="p-link layout-topbar-button">
                <i class="pi pi-cog"></i>
                <span>Settings</span>
            </button>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>

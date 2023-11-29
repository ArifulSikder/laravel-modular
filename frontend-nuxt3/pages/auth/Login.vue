<script setup>
    import {
        useLayout
    } from '@/layouts/composable/layout';
    import {
        ref,
        computed
    } from 'vue';
    
    const {
        layoutConfig
    } = useLayout();
    const email = ref('');
    const password = ref('');
    const checked = ref(false);
    const logoUrl = computed(() => {
        return `/layout/images/${layoutConfig.darkTheme.value ? 'logo-white' : 'logo-dark'}.svg`;
    });

 
    definePageMeta({
        middleware: ["guest"],
        layout: false
    });



    const auth = useAuthStore();

    const form = reactive({
        email: null,
        password: null,
    })
    const errors = ref([]);

    const handleSubmit = async () => {
        try {
            await auth.login(form)
            errors.value = [];
        } catch (error) {
            errors.value = error.data.errors;
        }
    };
</script>

<template>
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <div
                style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <div class="text-center mb-5">
                        <img src="/demo/images/login/avatar.png" alt="Image" height="50" class="mb-3" />
                        <div class="text-900 text-3xl font-medium mb-3">Welcome, Modern HMS!</div>
                        <span class="text-600 font-medium">Sign in to continue</span>
                    </div>

                    <form @submit.prevent="handleSubmit">
                        <div>
                            <label for="email1" class="block text-900 text-xl font-medium mb-2">Email</label>
                            <InputText id="email1" v-model="form.email" type="text" placeholder="Email address"
                                class="w-full mb-3" inputClass="w-full" :inputStyle="{ padding: '1rem' }" />
                            <span v-if="errors.email"
                                class="text-red-500  text-xl font-medium mb-2">{{ errors . email[0] }}</span>
                        </div>
                        <div>
                            <label for="password1" class="block text-900 font-medium text-xl mb-2">Password</label>
                            <Password id="password1" v-model="form.password" placeholder="Password"
                                :toggleMask="true" class="w-full mb-3" inputClass="w-full"
                                :inputStyle="{ padding: '1rem' }"></Password>
                            <span v-if="errors.password"
                                class="text-red-500  text-xl font-medium mb-2">{{ errors . password[0] }}</span>
                        </div>
                        <div class="flex align-items-center justify-content-between mb-5 gap-5">
                            <div class="flex align-items-center">
                                <Checkbox id="rememberme1" v-model="checked" binary class="mr-2"></Checkbox>
                                <label for="rememberme1">Remember me</label>
                            </div>
                            <a href="/auth/forgot-password"
                                class="font-medium no-underline ml-2 text-right cursor-pointer"
                                style="color: var(--primary-color)">Forgot password?</a>
                        </div>
                        <button type="submit" class="p-button p-button-primary p-button-xl w-full p-3 text-xl"
                            style="display: block; width: 100%"> Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .pi-eye {
        transform: scale(1.6);
        margin-right: 1rem;
    }

    .pi-eye-slash {
        transform: scale(1.6);
        margin-right: 1rem;
    }
</style>

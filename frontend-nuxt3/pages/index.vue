<script setup>

    const checked = ref(false);

    definePageMeta({
        middleware: ["guest"],
        layout: false
    });
    const tokenStore = useTokenStore();
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
                            <label for="email" class="block text-900 text-xl font-medium mb-2">Email</label>
                            <InputText id="email" v-model="form.email" type="text" placeholder="Email address"
                                class="w-full mb-3" inputClass="w-full" :inputStyle="{ padding: '1rem' }" />
                            <span v-if="errors.email"
                                class="text-red-500  text-xl font-medium mb-2">{{ errors . email[0] }}</span>
                        </div>
                        <div>
                            <label for="password" class="block text-900 text-xl font-medium mb-2">Password</label>
                            <InputText id="password" v-model="form.password" type="password" placeholder="Password"
                                class="w-full mb-3" inputClass="w-full" :toggleMask="true" :inputStyle="{ padding: '1rem' }" />
                            <span v-if="errors.password"
                                class="text-red-500  text-xl font-medium mb-2">{{ errors . password[0] }}</span>
                        </div>
                     
                        <div class="flex align-items-center justify-content-between mb-5 gap-5">
                            <div class="flex align-items-center">
                                <Checkbox id="rememberme" v-model="checked" binary class="mr-2"></Checkbox>
                                <label for="rememberme">Remember me</label>
                            </div>
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

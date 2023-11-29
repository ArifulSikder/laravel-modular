export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: {}
    }),
    persist: true,
    getters: {
        getUser: (state) => state.user
    },
    actions: {
        async login(formData) {
            const config = useRuntimeConfig();
            const URL = config.public.apiUrl;
            try {
                const { data } = await $fetch(URL+'/api/v1/login', {
                    method: 'POST',
                    body: {
                        ...formData
                    }
                });
                this.commonSetter(data);
            } catch (error) {
                throw error;
            }
        },

        async register(formData) {
            const config = useRuntimeConfig();
            const URL = config.public.apiUrl;
            try {
                const { data } = await $fetch(URL+'/api/v1/register', {
                    method: 'POST',
                    body: {
                        ...formData
                    }
                });
                this.commonSetter(data);
            } catch (error) {
                throw error;
            }
        },

        async logout() {
            const config = useRuntimeConfig();
            const URL = config.public.apiUrl;
            const tokenStore = useTokenStore();
            try {
                const res = await $fetch(URL+'/api/v1/logout', {
                    method: 'POST',
                    headers: {
                        Accept: "application/json",
                        Authorization: `Bearer ${tokenStore.getToken}`
                    },
                });
                tokenStore.removeToken()
            } catch (error) {
                throw error;
            }
        },

        commonSetter(data) {
            const tokenStore = useTokenStore();
            tokenStore.setToken(data.token);
            this.user = data.user;
            return navigateTo('/backend/dashboard');
        },

        
    }
});

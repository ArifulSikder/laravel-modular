export default defineNuxtRouteMiddleware((to, from) => {
    const tokenStore = useTokenStore();

    if (tokenStore.getToggedIn) {
        return navigateTo('/backend/dashboard');
    }
});

export default defineNuxtRouteMiddleware((to, from) => {
    const tokenStore = useTokenStore();
    if (to.path !== '/' && !tokenStore.getToggedIn) {
        //false
        return navigateTo('/');
    }
});

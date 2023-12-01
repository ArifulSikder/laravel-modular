// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
devtools: { enabled: true },
  app: {
    head: {
      link: [
        { rel: 'stylesheet', href: '/assets/css/bootstrap.min.css' },
        { rel: 'stylesheet', href: '/assets/js/jquery.slim.min.js' },
      ]
    }
  }
})

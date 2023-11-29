// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    runtimeConfig: {
        public: {
            appUrl: process.env.NUXT_PUBLIC_APP_URL,
            apiUrl: process.env.NUXT_PUBLIC_API_URL,
        },
    },
    modules: [
        // ...
        '@pinia/nuxt',
        '@pinia-plugin-persistedstate/nuxt'
    ],
    overrides: {
        vue: 'latest'
    },
    imports: {
        dirs: ['./stores']
    },
    pinia: {
        autoImports: [
            // automatically imports `defineStore`
            'defineStore', // import { defineStore } from 'pinia'
            ['defineStore', 'definePiniaStore'] // import { defineStore as definePiniaStore } from 'pinia'
        ]
    },
    
    typescript: false,
    app: {
        head: {
            title: 'Modern HMS',
            link: [
                {
                    id: 'theme-css',
                    rel: 'stylesheet',
                    type: 'text/css',
                    href: '/themes/lara-light-indigo/theme.css'
                }
            ]
        }
    },
    build: {
        transpile: ['primevue']
    },
    script: [
        {
            strategy: 'lazyOnload',
            src: 'https://www.googletagmanager.com/gtag/js?id=UA-93461466-1'
        },
        {
            id: 'ga-analytics',
            strategy: 'lazyOnload',
            children: `
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              gtag('config', 'UA-93461466-1');
          `
        }
    ],
    loading: false,
    css: ['primeicons/primeicons.css', 'primeflex/primeflex.scss', 'primevue/resources/primevue.min.css', '@/assets/styles.scss']
});

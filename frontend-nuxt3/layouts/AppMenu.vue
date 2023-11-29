<script setup>
    import {
        ref
    } from 'vue';
    import AppMenuItem from './AppMenuItem.vue';
    const model = ref([


        {
            items: [{
                label: 'Role and Permission',
                icon: 'pi pi-fw pi-bookmark',
                items: [{
                        label: 'Role',
                        icon: 'pi pi-fw pi-users',
                        to: '/role'
                    },
                    {
                        label: 'Permission',
                        icon: 'pi pi-fw pi-users',
                        to: '/permission'
                    },
                    {
                        label: 'Give Permission',
                        icon: 'pi pi-fw pi-users',
                        to: '/give-permission'
                    },
                    {
                        label: 'Users',
                        icon: 'pi pi-fw pi-users',
                        to: '/user'
                    },
                ]
            }]
        },

        {
            label: 'Sample',
            items: [{
                label: 'Submenu 1',
                icon: 'pi pi-fw pi-bookmark',
                items: [{
                    label: 'Submenu 1.1',
                    icon: 'pi pi-fw pi-bookmark',
                    items: [{
                            label: 'Submenu 1.1.1',
                            icon: 'pi pi-fw pi-bookmark'
                        },
                        {
                            label: 'Submenu 1.1.2',
                            icon: 'pi pi-fw pi-bookmark'
                        },
                        {
                            label: 'Submenu 1.1.3',
                            icon: 'pi pi-fw pi-bookmark'
                        }
                    ]
                }]
            }]
        },
        {
            label: 'Get Started',
            items: [{
                    label: 'Documentation',
                    icon: 'pi pi-fw pi-question',
                    to: '/documentation'
                },
                {
                    label: 'View Source',
                    icon: 'pi pi-fw pi-search',
                    url: 'https://github.com/primefaces/sakai-nuxt',
                    target: '_blank'
                }
            ]
        }
    ]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>

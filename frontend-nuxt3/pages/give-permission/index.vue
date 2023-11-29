<script setup>
    const loading = ref(true); //for loading
    const position = ref('center');
    const visible = ref(false);

    const form = reactive({
        permission_id: [],
        user_id: null,
    });
    const initialFormState = {
        ...form
    };
    const resetForm = () => {
        for (const key in form) {
            form[key] = initialFormState[key];
        }
    };


    const config = useRuntimeConfig();
    const URL = config.public.apiUrl;
    const errors = ref([]);
    const permissions = ref([]);
    const getPermissions = async () => {
        loading.value = true;
        try {
            const {
                data
            } = await $fetch(URL + '/api/v1/give-permission', {
                method: 'GET',
            });

            permissions.value = data;
            loading.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }


    const users = ref([]);
    const getUsers = async () => {
        loading.value = true;
        try {
            const {
                data
            } = await $fetch(URL + '/api/v1/get-users', {
                method: 'GET',
            });

            users.value = data;
            loading.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }

    const storePermission = async () => {
        try {
            const response = await $fetch(URL + '/api/v1/give-permission', {
                method: 'POST',
                body: {
                    ...form
                }
            });

            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }

    onMounted(() => {
        getPermissions();
        getUsers();
    });
</script>


<template>
    <div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="flex justify-content-left mb-3 gap-2">
                        <Dropdown v-model="form.user_id" :options="users" optionLabel="name"
                            placeholder="Select a City" class="w-full md:w-14rem" />
                    </div>

                    <div class="mb-3 gap-2">
                        <div v-for="permission of permissions" :key="permission.key"
                            class="flex align-items-center mb-3 gap-2">
                            <Checkbox v-model="form.permission_id" :inputId="permission.key" :value="permission.name" />
                            <label :for="permission.key">{{ permission . name }}</label>
                        </div>
                    </div>

                    <div class="mb-3 gap-2">
                        <Button label="Submit" icon="pi pi-check" @click.prevent="storePermission" />
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <DataTable :value="permissions" paginator :rows="5" dataKey="id"
                        filterDisplay="menu" :loading="loading">
                        <template #header>
                            <div class="flex justify-content-between">
                                <Button label="Add Permission" icon="pi pi-plus-circle" @click="openPosition(null)"
                                    severity="primary" style="min-width: 10rem" />
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText placeholder="Keyword Search" />
                                </span>
                            </div>
                        </template>
                        <template #empty> No customers found. </template>
                        <template #loading> Loading customers data. Please wait. </template>
                        <Column field="name" header="Name" style="min-width: 12rem">
                            <template #body="{ data }">
                                {{ data . name }}
                            </template>
                        </Column>
                        <Column field="display_name" header="Display Name" style="min-width: 12rem">
                            <template #body="{ data }">
                                {{ data . display_name }}
                            </template>
                        </Column>
                        <Column header="Action" style="min-width: 12rem">
                            <template #body="{data}">
                                <Button label="View" icon="pi pi-eye" severity="primary" @click="viewChildIndex(data)"
                                    rounded size="small" />
                                <Button label="Edit" icon="pi pi-pencil" severity="success"
                                    @click="openPosition(data)" rounded size="small" />
                                <Button label="Delete" icon="pi pi-trash" severity="danger" @click="destroy(data.id)"
                                    rounded size="small" />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </div>
</template>

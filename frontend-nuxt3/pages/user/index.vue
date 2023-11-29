<script setup>
    const loading = ref(true); //for loading
    const position = ref('center');
    const visible = ref(false);
    
    const form = reactive({
        name: null
    });
    const initialFormState = {
        ...form
    };
    const resetForm = () => {
        for (const key in form) {
            form[key] = initialFormState[key];
        }
    };

    const editData = ref([]);
    const edit = ref(null);
    const cardHeader = ref(null);
    const openPosition = (data) => {
        errors.value = [];
        if (data) {
            cardHeader.value = "Edit User Form";
            edit.value = 1;
            editData.value = data;
            form.name = data.name;
            position.value = "top";
            visible.value = true;
        } else {
            cardHeader.value = "Add New User Form";
            form.name = null;
            edit.value = null;
            position.value = "top";
            visible.value = true;
        }
    }

    const config = useRuntimeConfig();
    const URL = config.public.apiUrl;
    const errors = ref([]);
    const users = ref([]);
    const getUser = async () => {
        loading.value = true;
        try {
            const {
                data
            } = await $fetch(URL + '/api/v1/user', {
                method: 'GET',
            });
            
            users.value = data;
            loading.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }

    const handleSubmit = () => {
        if (edit.value) {
            editUser();
        } else {
            addUser();
        }
    }

    const addUser = async () => {
        loading.value = true;
        try {
            const response = await $fetch(URL + '/api/v1/user', {
                method: 'POST',
                body: {
                    ...form
                }
            });

            getUser();
            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    };

    const editUser = async () => {
        form.id = editData.value.id;
        loading.value = true;
        try {
            const response = await $fetch(URL + '/api/v1/user/'+editData.value.id, {
                method: 'PUT',
                body: {
                    ...form
                }
            });

            getUser();
            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }

    const destroy = async (user_id) => {
        loading.value = true;
        try {
            const response = await $fetch(URL + '/api/v1/user/'+user_id, {
                method: 'DELETE'
            });

            getUser();
            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }

    const getGivenPermission = async (user_id) => {
        loading.value = true;
        try {
            const response = await $fetch(URL + '/api/v1/user-get-permission/'+user_id, {
                method: 'GET'
            });

            getUser();
            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }



    onMounted(() => {
        getUser()
    });
</script>


<template>
    <div>
        <div class="card">
            {{ users }}
            <DataTable :value="users" paginator :rows="10" dataKey="id" filterDisplay="menu"
                :loading="loading">
                <template #header>
                    <div class="flex justify-content-between">
                        <Button label="Add User" icon="pi pi-plus-circle" @click="openPosition(null)" severity="primary"
                            style="min-width: 10rem" />
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
                <Column field="email" header="Email" style="min-width: 12rem">
                    <template #body="{ data }">
                        {{ data . email }}
                    </template>
                </Column>
                <Column header="Action" style="min-width: 12rem">
                    <template #body="{data}">
                        <Button label="Edit" icon="pi pi-pencil" severity="success" @click="openPosition(data)" rounded size="small" />
                        <Button label="Delete" icon="pi pi-trash" severity="danger" @click="destroy(data.id)"  rounded size="small" />
                        <Button label="View" icon="pi pi-eye" severity="primary" @click="getGivenPermission(data.id)"  rounded size="small" />
                    </template>
                </Column>
            </DataTable>


            <template>
                <div class="card">
                    <Dialog v-model:visible="visible" :header="cardHeader" :style="{ width: '50rem' }"
                        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" :position="position"
                        :modal="true" :draggable="false">
                        <form>
                            <div>
                                <label for="name" class="block text-900 text-xl font-medium mb-2">Role Name</label>
                                <InputText id="name" v-model="form.name" type="text"
                                    placeholder="Enter Role Name" class="w-full mb-3" inputClass="w-full"
                                    :inputStyle="{ padding: '1rem' }" />
                                <span v-if="errors.name"
                                    class="text-red-500  text-xl font-medium mb-2">{{ errors . name[0] }}</span>
                            </div>
                        </form>

                        <template #footer>
                            <Button label="No" icon="pi pi-times" @click="visible = false" text />
                            <Button label="Yes" icon="pi pi-check" @click="handleSubmit" autofocus />
                        </template>
                    </Dialog>
                </div>
            </template>
        </div>
    </div>
</template>

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
            cardHeader.value = "Edit Role Form";
            edit.value = 1;
            editData.value = data;
            form.name = data.name;
            position.value = "top";
            visible.value = true;
        } else {
            cardHeader.value = "Add New Role Form";
            form.name = null;
            edit.value = null;
            position.value = "top";
            visible.value = true;
        }
    }

    const config = useRuntimeConfig();
    const URL = config.public.apiUrl;
    const errors = ref([]);
    const roles = ref([]);
    const getRoles = async () => {
        loading.value = true;
        try {
            const {
                data
            } = await $fetch(URL + '/api/v1/role', {
                method: 'GET',
            });
            roles.value = data.data;
            loading.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }

    const handleSubmit = () => {
        if (edit.value) {
            editRole();
        } else {
            addRole();
        }
    }

    const addRole = async () => {
        loading.value = true;
        try {
            const response = await $fetch(URL + '/api/v1/role', {
                method: 'POST',
                body: {
                    ...form
                }
            });

            getRoles();
            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    };

    const editRole = async () => {
        form.id = editData.value.id;
        loading.value = true;
        try {
            const response = await $fetch(URL + '/api/v1/role/'+editData.value.id, {
                method: 'PUT',
                body: {
                    ...form
                }
            });

            getRoles();
            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }

    const destry = async (role_id) => {
        console.log(role_id);
        loading.value = true;
        try {
            const response = await $fetch(URL + '/api/v1/role/'+role_id, {
                method: 'DELETE'
            });

            getRoles();
            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }



    onMounted(() => {
        getRoles()
    });
</script>


<template>
    <div>
        <div class="card">
            <DataTable :value="roles" paginator :rows="10" dataKey="id" filterDisplay="menu"
                :loading="loading">
                <template #header>
                    <div class="flex justify-content-between">
                        <Button label="Add Role" icon="pi pi-plus-circle" @click="openPosition(null)" severity="primary"
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
                <Column header="Action" style="min-width: 12rem">
                    <template #body="{data}">
                        <Button label="Edit" icon="pi pi-pencil" severity="success" @click="openPosition(data)" rounded size="small" />
                        <Button label="Delete" icon="pi pi-trash" severity="danger" @click="destry(data.id)"  rounded size="small" />
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

<script setup>
    const route = useRoute();
    const loading = ref(true); //for loading
    const position = ref('center');
    const visible = ref(false);
    const initialPermissionParentId = ref(route.params.id);
    const permissionParentId = ref(route.params.id);

    const form = reactive({
        name: null,
        display_name: null,
        parent_id: null,
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
            cardHeader.value = "Edit Permission Form";
            edit.value = 1;
            editData.value = data;
            form.name = data.name;
            position.value = "top";
            visible.value = true;
        } else {
            cardHeader.value = "Add New Permission Form";
            form.name = null;
            edit.value = null;
            position.value = "top";
            visible.value = true;
        }
    }

    const config = useRuntimeConfig();
    const URL = config.public.apiUrl;
    const errors = ref([]);
    const permissions = ref([]);
    const getChildPermissions = async () => {
        loading.value = true;
        try {
            const {
                data
            } = await $fetch(URL + '/api/v1/permission/' + permissionParentId.value, {
                method: 'GET',
            });
        console.log(data);
            permissions.value = data.data;
            loading.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }

    const handleSubmit = () => {
        if (edit.value) {
            editPermission();
        } else {
            addPermission();
        }
    }

    const addPermission = async () => {
        loading.value = true;
        form.parent_id = permissionParentId.value;
        try {
            const response = await $fetch(URL + '/api/v1/permission', {
                method: 'POST',
                body: {
                    ...form
                }
            });

            getChildPermissions();
            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    };

    const editPermission = async () => {
        form.id = editData.value.id;
        loading.value = true;
        try {
            const response = await $fetch(URL + '/api/v1/permission/' + editData.value.id, {
                method: 'PUT',
                body: {
                    ...form
                }
            });

            getChildPermissions();
            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }

    const destroy = async (permission_id) => {
        loading.value = true;
        try {
            const response = await $fetch(URL + '/api/v1/permission/' + permission_id, {
                method: 'DELETE'
            });

            getChildPermissions();
            resetForm();
            loading.value = false;
            visible.value = false;
        } catch (error) {
            loading.value = false;
            errors.value = error.data.errors;
        }
    }

    const viewChild = (data) => {
        return navigateTo('/permission/' + data.id);
    }

    watch(() => route.params.id, async (newParams, oldParams) => {
        console.log(newParams, oldParams);
        permissionParentId.value = newParams;
        await getChildPermissions();
    });

    onMounted(async () => {
        permissionParentId;
        permissionParentId.value = initialPermissionParentId.value;
        await getChildPermissions();
    });
</script>


<template>
    <div>
        {{ permissionParentId }}
        {{ route . params . id }}

        <div class="card">
            <DataTable :value="permissions" paginator :rows="5" dataKey="id" filterDisplay="menu"
                :loading="loading">
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
                        <Button label="View" icon="pi pi-eye" severity="primary" @click="viewChild(data)" rounded
                            size="small" />
                        <Button label="Edit" icon="pi pi-pencil" severity="success" @click="openPosition(data)"
                            rounded size="small" />
                        <Button label="Delete" icon="pi pi-trash" severity="danger" @click="destroy(data.id)" rounded
                            size="small" />
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
                                <label for="name" class="block text-900 text-xl font-medium mb-2">Permission
                                    Name</label>
                                <InputText id="name" v-model="form.name" type="text"
                                    placeholder="Enter Permission Name" class="w-full mb-3" inputClass="w-full"
                                    :inputStyle="{ padding: '1rem' }" />
                                <span v-if="errors.name"
                                    class="text-red-500  text-xl font-medium mb-2">{{ errors . name[0] }}</span>

                                <label for="display_name" class="block text-900 text-xl font-medium mb-2">Display
                                    Name</label>
                                <InputText id="name" v-model="form.display_name" type="text"
                                    placeholder="Enter Display Name" class="w-full mb-3" inputClass="w-full"
                                    :inputStyle="{ padding: '1rem' }" />
                                <span v-if="errors.display_name"
                                    class="text-red-500  text-xl font-medium mb-2">{{ errors . display_name[0] }}</span>
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

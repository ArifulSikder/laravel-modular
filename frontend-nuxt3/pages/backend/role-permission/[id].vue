<script setup>
    import {
        ref
    } from 'vue';
    const allPermission = ref();
    const patient = ref(false);
    const selectedValue = ref('Unchecked');

    const handleCheckboxChange = () => {
        selectedValue.value = checked.value ? 'Checked' : 'Unchecked';
        console.log(selectedValue.value);
    };

    const route = useRoute();
    const roleId = ref(null);
    const form = ref({
        name: null,
    });

    const getRole = async () => {
        try {
            const {
                data
            } = await $fetch('http://127.0.0.1:8000/api/v1/user/role/'+roleId.value, {
                method: 'GET',
            });
            console.log(data.name);
            form.value.name = data.name;
        } catch (error) {
            errors.value = error.data.errors;
        }
    }

    const errors = ref([]);
    const createRole = async () => {
        try {
            const {
                data
            } = await $fetch('http://127.0.0.1:8000/api/v1/user/role'+roleId.value, {
                method: 'POST',
                body: {
                    ...form
                }
            });
            return navigateTo('/backend/role-permission');
        } catch (error) {
            errors.value = error.data.errors;
        }
    }
    onMounted(() => {
        roleId.value = route.params.id,
        console.log(route.params.id),
        console.log(roleId.value),
        getRole()
    });
</script>
<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <h5>Create role and assign permissions</h5>
                <div class="p-fluid formgrid grid">
                    <form class="field col-6" @submit.prevent="createRole">
                        <label for="role">Role</label>
                        <div class="input-button-container">
                            <InputText id="role" v-model="form.name" type="text" placeholder="Enter role name" />
                            <span v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</span>
                        </div>
                        <div class="mt-2 card flex flex-wrap justify-content-sm-start gap-3">
                            <div class="flex align-items-center">
                                <Checkbox v-model="allPermission" inputId="allPermission" name="allPermission"
                                    value="all_permission" @click="handleCheckboxChange" />
                                <label for="allPermission" class="ml-2">Allow all permissions</label>
                            </div>

                        </div>
                        <!-- Permission Checkbox Row -->
                        <div class="mt-2 card flex flex-wrap justify-content-sm-start gap-3">
                            <label for="Patients">Patients</label>
                            <div class="flex">
                                <Checkbox v-model="patient" inputId="patient_all" name="patient" value="patient_all" />
                                <label for="patient_all" class="ml-2">All</label>
                            </div>
                        </div>
                        <Button label="Save" type="submit" icon="pi pi-save"
                            class="p-button-success mr-2 mb-2 max-size" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .mt-20 {
        margin-top: 20px !important;
    }

    .max-size {
        max-width: 100px;
        max-height: 40px;
    }
</style>

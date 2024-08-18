<template>

    <div class="container">
        <div class="row form-block justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Реєстрація</div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" v-model="formdata.email">
                            </div>
                            <div class="error col-md-6 offset-md-4" v-for="error in errors.email" :key="error">{{ error }}</div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Ім’я</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" v-model="formdata.name">
                            </div>
                            <div class="error col-md-6 offset-md-4" v-for="error in errors.name" :key="error">{{ error }}</div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Пароль</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" v-model="formdata.password">
                            </div>
                            <div class="error col-md-6 offset-md-4" v-for="error in errors.password" :key="error">{{ error }}</div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Підтвердити пароль</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" v-model="formdata.password_confirmation">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input type="submit" value="Зареєструватись" class="btn btn-primary" @click.prevent="register" :disabled="isRegBtnDsbld">
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
    import axios from 'axios';
    import { useRouter } from "vue-router";
    import {ref} from 'vue';


    const router = useRouter();
    const errors = ref([]);
    const isRegBtnDsbld = ref(false);

    const formdata = {
        email: null,
        name: null,
        password: null,
        password_confirmation: null
    }

    const register = () => {
        isRegBtnDsbld.value = true;

        let data = {
            name: formdata.name,
            email: formdata.email,
            password: formdata.password,
            password_confirmation: formdata.password_confirmation
        }

        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/register', data).then(r => {
                isRegBtnDsbld.value = false;
                localStorage.setItem('auth', true);
                window.location.href = '/';
            }).catch(error => {
                isRegBtnDsbld.value = false;
                console.error(error.response.data.errors);
                errors.value = error.response.data.errors;
            });
        })
    }



</script>

<style scoped>
    .form-block {
        margin-top: 20px;
    }

    .register_link {
        color: rgb(146, 75, 217);
    }

    .card-header {
        background: rgb(146, 75, 217);
        color: white;
    }

    .error {
        color: red;
    }

</style>

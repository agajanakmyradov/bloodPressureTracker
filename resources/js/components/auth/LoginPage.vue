<template>

    <div class="container">
        <div class="row form-block justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Увійдіть на сайт</div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">email</label>
                            <div class="col-md-6">
                                <input type="email" placeholder="email" class="form-control" v-model="formdata.email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">пароль</label>
                            <div class="col-md-6">
                                <input type="password" placeholder="pass" class="form-control" v-model="formdata.password">
                            </div>
                            <a class="col-md-6 offset-md-4 " href="">
                                <router-link v-if="!isAuthenticated"  :to="{ name: 'register' }" class="register_link">Зареєструватися</router-link>
                            </a>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6 offset-md-4" style="color:red">{{ errors }}</div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input type="submit" value="Увійти" class="btn btn-primary" @click.prevent="login" :disabled="isLoginBtnDsbld">
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
    const errors = ref('');
    const isLoginBtnDsbld = ref(false);

    const formdata = ref({
        email: null,
        password: null
    });

   const login = () => {
            isLoginBtnDsbld.value = true;

            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', { email: formdata.value.email, password: formdata.value.password }).then(r => {
                    isLoginBtnDsbld.value = false;
                    localStorage.setItem('auth', true);
                    window.location.href = '/';
                }).catch(error => {
                    isLoginBtnDsbld.value = false;
                    console.error(error.response.data.message);
                    errors.value = 'Неправильні введені дані';
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

</style>

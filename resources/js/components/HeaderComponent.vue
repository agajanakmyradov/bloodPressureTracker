<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <router-link :to="{ name: 'home' }" class="navbar-brand ms-5">Home</router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container-fluid mx-6">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link :to="{ name: 'measurements.index' }" class="nav-link active">Замері</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'test1' }" class="nav-link active">test1</router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <router-link :to="{ name: 'test2' }" class="nav-link active">test2</router-link>
                    </li>
                </ul>

                <div class="me-5" >
                    <router-link v-if="!isauth"  :to="{ name: 'login' }" class="nav-link active">Увійти</router-link>
                    <div class="nav-link active" v-if="isauth" @click="logout" style="cursor: pointer;">Вийти</div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
    import { ref } from 'vue';
    import axios from 'axios';
    import { useRouter } from 'vue-router';
    const router = useRouter();

    const props = defineProps({
        isauth: Boolean,
    });

    const emit = defineEmits(['changeAuth']);

    const logout = () => {
        const token = localStorage.getItem('auth');

        if (token) {
            axios.post('/logout').then(() => {
                localStorage.removeItem('auth');
                emit('changeAuth', !props.isauth);
                router.push({name: 'home'});
            }).catch(error => {
                if (error.response.status == 401) {
                    localStorage.removeItem('auth');
                    emit('changeAuth', !props.isauth);
                    router.push({name: 'home'});
                }
            });
        } else {
            console.log('Токен отсутствует. Пользователь не в системе.');
        }

    }
</script>

<style scoped>

</style>

<template>
    <div>
        <header-component :isauth="isAuth" @changeAuth="changeAuthStatus" />
        <router-view :isauth="isAuth" @changeAuth="changeAuthStatus"  />
    </div>

</template>

<script setup>
import HeaderComponent from "./components/HeaderComponent.vue";
import {ref} from "vue";

let testArg = 'this is test from app';
let isAuth =  ref(localStorage.getItem('auth') !== null);

function changeAuthStatus(arg) {
    isAuth.value = arg;
}

</script>

<style >



</style>

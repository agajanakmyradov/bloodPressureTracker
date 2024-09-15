<template>
    <div class="container">

    </div>
</template>

<script setup>
    import {ref} from 'vue';
    import axios from 'axios';
    import { useRouter } from 'vue-router';
    import useMeasurements from "../composables/measurements";

    const {destroyMeasurement} = useMeasurements();

    const props = defineProps({
        isauth: Boolean,
    });

    const router = useRouter();
    const emit = defineEmits(['changeAuth']);

    const id = 15;

    const getMeasurements = async() => {
        try {
            let response = await axios.get('/api/bp');
            console.log(response);

        } catch (e) {
            if (e.response && e.response.status === 401) {
                localStorage.removeItem('auth');
                emit('changeAuth', !props.isauth);
                router.push({name: 'login'});
            } else {
                console.error('An error occurred:', e);
            }
        }
    }

    const deleteMeasurement = async(id) => {
        await destroyMeasurement(id);
    }



    const getMeasurement = async(id) => {
        try {
            let response = await axios.get('/api/bp/' + id);
            console.log(response.data);
        } catch (e) {
            if (e.response && e.response.status === 401) {
                localStorage.removeItem('auth');
                emit('changeAuth', !props.isauth);
                router.push({name: 'login'});
            } else {
                console.error('An error occurred:', e);
            }
        }
    }


</script>

<style scoped>

</style>

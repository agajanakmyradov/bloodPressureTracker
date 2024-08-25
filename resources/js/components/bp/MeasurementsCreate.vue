<template>
    <div class="container">
        <div class="row form-block justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Увійдіть на сайт</div>

                    <div class="card-body">
                        <form>
                            <div class="row mb-3">
                                <label for="sys" class="col-md-4 col-form-label text-md-end">Cистолічний</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="sys" class="form-control" v-model="form.sys">
                                </div>
                                <div class="error col-md-6 offset-md-4" v-for="error in errors.sys" :key="error">{{ error }}</div>
                            </div>

                            <div class="row mb-3">
                                <label for="dia" class="col-md-4 col-form-label text-md-end">Діастолічний</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="dia" class="form-control" v-model="form.dia">
                                </div>
                                <div class="error col-md-6 offset-md-4" v-for="error in errors.dia" :key="error">{{ error }}</div>
                            </div>

                            <div class="row mb-3">
                                <label for="pulse" class="col-md-4 col-form-label text-md-end">Пульс</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="pulse" class="form-control"  v-model="form.pulse">
                                </div>
                                <div class="error col-md-6 offset-md-4" v-for="error in errors.pulse" :key="error">{{ error }}</div>
                            </div>

                            <div class="row mb-3">
                                <label for="date" class="col-md-4 col-form-label text-md-end">Дата</label>
                                <div class="col-md-6">
                                    <input type="date" placeholder="date" class="form-control" :max="today"  v-model="form.date">
                                </div>
                                <div class="error col-md-6 offset-md-4" v-for="error in errors.date" :key="error">{{ error }}</div>
                            </div>

                            <div class="row mb-3">
                                <label for="time" class="col-md-4 col-form-label text-md-end">Час</label>
                                <div class="col-md-6">
                                    <input type="time" placeholder="time" class="form-control"  v-model="form.time">
                                </div>
                                <div class="error col-md-6 offset-md-4" v-for="error in errors.time" :key="error">{{ error }}</div>
                            </div>

                            <div class="row mb-3">
                                <label for="time" class="col-md-4 col-form-label text-md-end">Примітка (не обов'язково)</label>
                                <div class="col-md-6">
                                    <textarea name="note" cols="20" rows="5"  v-model="form.note"></textarea>
                                </div>
                                <div class="error col-md-6 offset-md-4" v-for="error in errors.note" :key="error">{{ error }}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6 offset-md-4" style="color:red"></div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4 ">
                                    <input type="submit" value="Додати" class="btn btn-primary" @click.prevent="addMeasurement">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import {ref, onMounted} from "vue";
    import { useRouter } from "vue-router";
    import useMeasurements from "../../composables/measurements";

    const props = defineProps({
        isauth: Boolean
    });
    const emit = defineEmits(['changeAuth']);

    const {storeMeasurement, errors} = useMeasurements(emit);
    const router = useRouter();
    const date =new Date();
    const today = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');


    const form = ref({
        sys: '',
        dia: '',
        pulse: '',
        date: '',
        time: '',
        note: ''
    });

    const addMeasurement = async() => {
        await storeMeasurement(form.value);
    }





</script>

<style scoped>

    .card-header {
        background: rgb(146, 75, 217);
        color:white

    }

    .error {
        color: red;
    }
</style>

<template>
    <div class="container">

        <div class="card mt-3">
            <div class="card-header">
               <h5 class=" mb-0 toggle-card">Таблиця вимірювань АТ</h5>
               <br />
            </div>
            <div class="d-flex justify-content-end">
                <div class="m-2">
                    <router-link :to="{ name: 'measurements.create' }">Додати</router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <div class="mt-1 me-2">Показати</div>
                        <select class="form-select limitSelect" name="limit" v-model="currnetLimit" @change="changeLimit">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="d-flex">
                        <div>
                            <label for="startDate mt-1">До</label>
                            <input type="date" class="form-control dateInput" v-model="startDate" @change="changeDate">
                        </div>

                        <div>
                            <label for="startDate mt-2">Після</label>
                            <input type="date" class="form-control dateInput" v-model="endDate" @change="changeDate">
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    Показано від {{ measurements.from }} до {{ measurements.to }} із {{ measurements.total }} записів
                </div>
                <table id="bpMeasurements" class=" table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Дата</th>
                            <th class="text-center">Час</th>
                            <th class="text-center" >Cистолічний <br> (верхній)</th>
                            <th class="text-center">Діастолічний <br> (нижній)</th>
                            <th class="text-center">Пульс</th>
                            <th class="text-center">Примітка</th>
                            <th class="text-center">Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="measurement in measurements.data" :key="measurement.id">
                            <td class="text-center date-col" >{{ measurement.date }}</td>
                            <td class="text-center" >{{ measurement.time }}</td>
                            <td class="text-center" >{{ measurement.sys }}</td>
                            <td class="text-center" >{{ measurement.dia }}</td>
                            <td class="text-center" >{{ measurement.pulse }}</td>
                            <td class="text-center" >{{ measurement.note }}</td>
                            <td class="text-center" >
                                <button class="btn" @click="deleteMeasurement(measurement.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                  </table>
                  <Bootstrap5Pagination class="mt-2"
                            :data="measurements"
                            @pagination-change-page="getResult"
                            :limit="3"
                        />
              </div>
       </div>

    </div>
</template>

<script setup>
    import {ref, onMounted} from "vue";
    import useMeasurements from "../../composables/measurements";
    import { Bootstrap5Pagination } from 'laravel-vue-pagination';

    const props = defineProps({
        isauth: Boolean
    });
    const emit = defineEmits(['changeAuth']);

    const {destroyMeasurement, measurements, getMeasurements} = useMeasurements(emit);

    const currnetLimit = ref(10);
    const currentPage = ref(1);
    const startDate = ref('');
    const endDate = ref('');

    onMounted(async () => {
        await getMeasurements();
    });

    const getResult = async(page) => {
        await getMeasurements(page, currnetLimit.value);
        currentPage.value = page;
    }

    const changeLimit = async() => {
        await getMeasurements(1, currnetLimit.value);
    }

    const changeDate = async() => {
        await getMeasurements(1, currnetLimit.value, startDate.value, endDate.value);
    }

    const deleteMeasurement = async(id) => {
        if(!window.confirm('Ви впевнені?')) {
                    return;
                }

        await destroyMeasurement(id);
        await getMeasurements(currentPage.value, currnetLimit.value, startDate.value, endDate.value);
    }

</script>

<style scoped>
    .limitSelect {
        width: 80px;
        height: 40px;
    }

    .dateInput {
        max-width: 200px;
    }

    .card-header {
        background: rgb(146, 75, 217);
        color:white

    }

</style>



<template>
    <div>
        <select class="form-select mt-2 ms-5" v-model="selected_month" @change="changeCharts" style="max-width: 200px;">
            <option v-for="month in months"  :key="month">{{ month }}</option>
        </select>
      <canvas id="testchart"></canvas>
    </div>
  </template>

  <script setup>
    import Chart from 'chart.js/auto';
    import 'chartjs-adapter-moment';
    import { ref, onMounted } from 'vue';
    import useMeasurements from "../../composables/measurements";
    import axios from 'axios';

    const props = defineProps({
        isauth: Boolean
    });
    const emit = defineEmits(['changeAuth']);

    const { measurements, getMeasurements, getMonths, months } = useMeasurements(emit);

    const data = ref([]);
    const selected_month = ref(null);
    let mychart =null;

    const months_in_ua = [
        "Січень",
        "Лютий",
        "Березень",
        "Квітень",
        "Травень",
        "Червень",
        "Липень",
        "Серпень",
        "Вересень",
        "Жовтень",
        "Листопад",
        "Грудень"
    ];

    const getSelected = (selected_month) => {
        let month_name = selected_month.value.replace(/^\d+\s*/g, '').trim();

        let index = months_in_ua.findIndex((elem) => month_name === elem);

        if (index !== -1) {
            index++;
            index = index < 10 ? '0' + String(index) : String(index);
           return  selected_month.value.replace(/[^\d]+\s*$/g, '-'+ index + '-01');
        } else {
            console.error("Месяц не найден!");
            return null;
        }
    };

    const changeMeasurements = async() => {
        selected_month.value = selected_month.value == null ? months.value[months.value.length - 1] : selected_month.value;
        let startDate = getSelected(selected_month);
        let updated_month_arr = startDate.split('-');
        let date =  new Date(updated_month_arr[0], updated_month_arr[1], updated_month_arr[2] - 1);
        let endDate = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');

        await  getMeasurements(1, 10000, startDate, endDate);

    }

    const createChart = () => {
        const ctx = document.getElementById('testchart').getContext('2d');

        if (mychart) {
            mychart.destroy();
        }

        mychart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.value.map(row => `${row.date} ${row.time}`),
                datasets: [
                    {
                        label: 'Systolic (SYS)',
                        data: data.value.map(row => row.sys),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Diastolic (DIA)',
                        data: data.value.map(row => row.dia),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pulse',
                        data: data.value.map(row => row.pulse),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day'
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Values'
                        }
                    }
                }
            }
        });
    };


    onMounted(async () => {
        await getMonths();
        await changeMeasurements();

        data.value = measurements.value.data;

        createChart()
    });

    const changeCharts = async() => {
        await changeMeasurements();

        data.value = measurements.value.data;

        createChart()

    }
  </script>

  <style scoped>
  #testchart {
    max-width: 800px;
    max-height: 600px;
  }
  </style>

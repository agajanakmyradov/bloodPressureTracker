import {ref} from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

function deleteAuth(emit, router) {
    localStorage.removeItem('auth');
    emit('changeAuth', false);
    router.push({name: 'login'});

}


export default function useMeasurements(emit) {
    let measurements = ref({});
    let router = useRouter();
    let errors = ref([]);
    let months = ref([]);

    const destroyMeasurement = async(id) => {
        try {
             let response = await axios.delete('/api/bp/' + id);
        } catch (e) {
             if (e.response && e.response.status === 401) {
                deleteAuth(emit, router)
             } else {
                 console.error('An error occurred:', e);
             }
        }
    }

    const getMeasurements = async(page = 1, limit = 10, startDate = null, endDate = null) => {
        try {
            let url = `/api/bp?page=${page}&limit=${limit}`;
            if (startDate) url += `&start_date=${startDate}`;
            if (endDate) url += `&end_date=${endDate}`;

            let response = await axios.get(url);

            if (response.data.success && response.data.success === true) {
                measurements.value = response.data.data;
            } else {
                console.log(response.data.error);
            }

        } catch (e) {
            if (e.response && e.response.status === 401) {
                deleteAuth(emit, router);
            } else {
                console.error('An error occurred:', e);
            }
        }
    }

    const storeMeasurement = async(form) => {
        errors.value = [];

        try {
            const formData = new FormData();
            formData.append('sys', form.sys);
            formData.append('dia', form.dia);
            formData.append('pulse', form.pulse);
            formData.append('date', form.date);
            formData.append('time', form.time);
            formData.append('note', form.note);

            let response = await axios.post('/api/bp', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            if (response.data.success == true) {
                await router.push({name: 'measurements.index'});
            } else {
                console.log(response);
            }

        } catch (e) {
            if (e.response && e.response.status === 422) {
                console.log(e);
                errors.value = e.response.data.errors;
            } else {
                console.error('An error occurred:', e);
            }
        }


    }

    const getMonths = async() => {
        try {
            let response = await axios.get('/api/bp/getmonths');


            if (response.data.success && response.data.success === true) {
                months.value = response.data.months;
            } else {
                console.log(response.data.error);
            }

        } catch (e) {
            if (e.response && e.response.status === 401) {
                deleteAuth(emit, router);
            } else {
                console.error('An error occurred:', e);
            }
        }
    }

     return {
        measurements,
        destroyMeasurement,
        getMeasurements,
        storeMeasurement,
        getMonths,
        months,
        errors
     }
}

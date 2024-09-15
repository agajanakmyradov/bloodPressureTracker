import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../components/auth/LoginPage.vue";
import HomePage from "../components/HomePage.vue";
import RegisterPage from "../components/auth/RegisterPage.vue";
import MeasurementsIndex from "../components/bp/MeasurementsIndex.vue";
import MeasurementsCreate from "../components/bp/MeasurementsCreate.vue";
import ChartsIndex from "../components/charts/ChartsIndex.vue";


const routes = [
    {
        path: '/login',
        name: 'login',
        component: LoginPage,
        allowedWithoutAuth: true,
    },
    {
        path: '/',
        name: 'home',
        component: HomePage,
        allowedWithoutAuth: true,
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterPage,
        allowedWithoutAuth: true,
    },
    {
        path: '/measurements',
        name: 'measurements.index',
        component: MeasurementsIndex,
        allowedWithoutAuth: false,
    },
    {
        path: '/measurements/create',
        name: 'measurements.create',
        component: MeasurementsCreate,
        allowedWithoutAuth: false,
    },
    {
        path: '/charts',
        name: 'charts.index',
        component: ChartsIndex,
        allowedWithoutAuth: false,
    },

];

const router = createRouter({
    routes,
    history: createWebHistory()
});

let allowed = routes
.filter(route => route.allowedWithoutAuth === true)
.map(route => route.name);

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('auth');

    if (!token) {
        if (allowed.includes(to.name)) {
            return next();
        } else {
            return next({
                name: 'login'
            });
        }
    }

    if (token && (to.name === 'login' || to.name === 'register')) {
        return next({
            name: 'home'
        });
    }

    next();
})

export default router;

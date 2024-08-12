import { createRouter, createWebHistory } from "vue-router";
import Test1Component from "../components/Test1Component.vue";
import Test2Component from "../components/Test2Component.vue";


const routes = [
    {
        path: '/test1',
        name: 'test1',
        component: Test1Component
    },
    {
        path: '/test2',
        name: 'test2',
        component: Test2Component
    }
];

const router = createRouter({
    routes,
    history: createWebHistory()
});

export default router;

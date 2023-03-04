import { createRouter, createWebHistory } from "vue-router";
const routes = [
    {
        path: "/",
        name: "home",
        component: () =>
            import(/* webpackChunkName: "Home" */ "../view/Home.vue"),
    },
    {
        path: "/login",
        name: "login",
        component: () =>
            import(/* webpackChunkName: "Login" */ "../view/Login.vue"),
    },
    {
        path: "/register",
        name: "registration",
        component: () =>
            import(/* webpackChunkName: "Register" */ "../view/Register.vue"),
    },
];

const router = createRouter({
    history: createWebHistory("/"),
    routes,
});

router.beforeEach((to, from, next) => {
    next();
});
export default router;

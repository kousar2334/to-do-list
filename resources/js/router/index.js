import { createRouter, createWebHistory } from "vue-router";
import store from "../store";
const routes = [
    {
        path: "/",
        name: "home",
        component: () =>
            import(/* webpackChunkName: "Home" */ "../view/Home.vue"),
        beforeEnter: authGuard,
    },
    {
        path: "/login",
        name: "login",
        component: () =>
            import(/* webpackChunkName: "Login" */ "../view/Login.vue"),
        beforeEnter: guestAccess,
    },
    {
        path: "/register",
        name: "registration",
        component: () =>
            import(/* webpackChunkName: "Register" */ "../view/Register.vue"),
        beforeEnter: guestAccess,
    },
];

const router = createRouter({
    history: createWebHistory("/"),
    routes,
});

router.beforeEach((to, from, next) => {
    next();
});

function authGuard(to, from, next) {
    if (store.state.isUserLogin) {
        next();
    } else {
        next("/login");
    }
}
function guestAccess(to, from, next) {
    if (!store.state.isUserLogin) {
        next();
    } else {
        next("/");
    }
}
export default router;

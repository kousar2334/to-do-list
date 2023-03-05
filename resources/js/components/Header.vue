<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <router-link class="navbar-brand" to="/">Todo App</router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav">
                    <li class="nav-item" v-if="!isUserLogin">
                        <router-link to="/login" class="btn btn-outline-secondary">Login</router-link>
                    </li>
                    <li class="nav-item dropdown" v-if="isUserLogin">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">{{ authUser.name }} </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#" @click.prevent="logout">Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';
import { useToast } from "vue-toastification";
import { useRouter } from 'vue-router';
import axios from 'axios'

export default {
    setup() {
        const store = useStore();
        const toast = useToast();
        const router = useRouter();

        function logout() {
            axios.get('api/v1/user-logout', {
                headers: {
                    Authorization: `Bearer ${store.getters.userToken}`,
                },
            }).then((response) => {
                if (response.data.success) {
                    store.dispatch('userLogout').then(() => {
                        toast.success("Logout successfully");
                        router.push('/login')
                    });
                }

                if (!response.data.success) {
                    toast.error("Login Failed");
                }
            }).catch((error) => {
                toast.error("Login Failed");
            });
        }

        return {
            logout,
            isUserLogin: computed(() => store.getters.isUserLogin),
            authUser: computed(() => store.getters.authUser),
        }
    }
}
</script>
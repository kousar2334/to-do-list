<template>
    <div class="row mt-5 no-gutters p-3">
        <div class="col-md-4 col-lg-4 col-12 bg-white p-5 mx-auto shadow-lg">
            <h3 class="pb-3">Login</h3>
            <div class="form-style">
                <form>
                    <div class="form-group pb-3">
                        <input type="email" placeholder="Email" class="form-control" v-model="state.email">
                        <template v-if="state.errors.email">
                            <p class="fz-12 text-danger mt-1 mb-0" v-for="(error, index) in state.errors.email"
                                :key="index">
                                {{ error }}
                            </p>
                        </template>
                    </div>
                    <div class="form-group pb-3">
                        <input type="password" placeholder="Password" class="form-control" v-model="state.password">
                        <template v-if="state.errors.password">
                            <p class="fz-12 text-danger mt-1 mb-0" v-for="(error, index) in state.errors.password"
                                :key="index">
                                {{ error }}
                            </p>
                        </template>
                    </div>

                    <div class="pb-2">
                        <button type="submit" @click.prevent="userLogin"
                            class="btn btn-primary w-100 font-weight-bold mt-2">Login</button>
                    </div>
                </form>

                <div class="pt-4 text-center">
                    Create a new account. <router-link to="/register">Sign Up</router-link>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import axios from "axios";
import { defineComponent, reactive } from "vue";
import { useToast } from "vue-toastification";
import { useStore } from 'vuex';
import { useRouter } from "vue-router";
export default defineComponent({
    setup() {
        const state = reactive({
            email: "",
            password: "",
            errors: [],
            submit_data: false,
        });
        const store = useStore();
        const toast = useToast();
        const router = useRouter();

        function userLogin() {
            state.submit_data = true;
            state.errors = [];
            axios.post('api/v1/user-login', {
                email: state.email,
                password: state.password,
            }).then((response) => {
                state.submit_data = false;
                if (response.data.success) {
                    store.dispatch('userLogin', response.data).then(() => {
                        router.push('/');
                        toast.success("Login successfully");
                    });
                }
                if (!response.data.success) {
                    toast.error(response.data.message);
                }
            }).catch((error) => {
                state.submit_data = false;
                if (error.response.status == 422) {
                    state.errors = error.response.data.errors;
                } else {
                    toast.error("Login Failed");
                }
            });
        }

        return {
            state,
            userLogin,
        };
    },
});
</script>
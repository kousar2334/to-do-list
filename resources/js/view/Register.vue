<template>
    <div class="row my-5 no-gutters p-3">
        <div class="col-md-4 col-lg-4 col-12 bg-white p-5 mx-auto shadow-lg">
            <h3 class="pb-3">Sign Up</h3>
            <div class="form-style">
                <form>
                    <div class="form-group pb-3">
                        <input type="text" v-model="state.name" placeholder="Name" class="form-control">
                        <template v-if="state.errors.name">
                            <p class="fz-12 text-danger mt-1 mb-0" v-for="(error, index) in state.errors.name" :key="index">
                                {{ error }}
                            </p>
                        </template>
                    </div>
                    <div class="form-group pb-3">
                        <input type="email" v-model="state.email" placeholder="Email" class="form-control">
                        <template v-if="state.errors.email">
                            <p class="fz-12 text-danger mt-1 mb-0" v-for="(error, index) in state.errors.email"
                                :key="index">
                                {{ error }}
                            </p>
                        </template>
                    </div>
                    <div class="form-group pb-3">
                        <input type="password" v-model="state.password" placeholder="Password" class="form-control">
                        <template v-if="state.errors.password">
                            <p class="fz-12 text-danger mt-1 mb-0" v-for="(error, index) in state.errors.password"
                                :key="index">
                                {{ error }}
                            </p>
                        </template>
                    </div>
                    <div class="form-group pb-3">
                        <input type="password" v-model="state.password_confirmation" placeholder="Confirm Password"
                            class="form-control">
                    </div>

                    <div class="pb-2">
                        <button type="submit" :class="{ loading: state.submit_data }" @click.prevent="userRegistration"
                            class="btn btn-primary w-100 font-weight-bold mt-2">Sign Up</button>
                    </div>
                </form>

                <div class="pt-4 text-center">
                    Already have a account <router-link to="/login">Login Here</router-link>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import axios from "axios";
import { defineComponent, reactive } from "vue";
import { useToast } from "vue-toastification";
export default defineComponent({
    setup() {
        const state = reactive({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            errors: [],
            submit_data: false,
        });
        const toast = useToast();

        function userRegistration() {
            state.submit_data = true;
            state.errors = [];
            axios.post('api/v1/user-register', {
                name: state.name,
                email: state.email,
                password: state.password,
                password_confirmation: state.password_confirmation,
            }).then((response) => {
                if (response.data.success) {
                    toast.success("Registration successfully");
                    this.$router.push('/login')
                }
                if (!response.data.success) {
                    toast.error("Registration Failed");
                }
                state.submit_data = false;
            }).catch((error) => {
                state.submit_data = false;
                if (error.response.status == 422) {
                    state.errors = error.response.data.errors;
                } else {
                    toast.error("Registration Failed");
                }
            });
        }

        return {
            state,
            userRegistration,
        };
    },
});
</script>
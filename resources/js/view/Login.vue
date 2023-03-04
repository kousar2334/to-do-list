<template>
    <div class="row mt-5 no-gutters p-3">
        <div class="col-md-4 col-lg-4 col-12 bg-white p-5 mx-auto shadow-lg">
            <h3 class="pb-3">Login Form</h3>
            <div class="form-style">
                <form>
                    <div class="form-group pb-3">
                        <input type="email" placeholder="Email" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="form-group pb-3">
                        <input type="password" placeholder="Password" class="form-control" id="exampleInputPassword1">
                    </div>

                    <div class="pb-2">
                        <button type="submit" class="btn btn-primary w-100 font-weight-bold mt-2">Login</button>
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
export default {
    name: "Login",
}
</script>
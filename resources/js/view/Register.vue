<template>
    <div class="row mt-5 no-gutters p-3">
        <div class="col-md-4 col-lg-4 col-12 bg-white p-5 mx-auto shadow-lg">
            <h3 class="pb-3">Sign Up</h3>
            <div class="form-style">
                <form>
                    <div class="form-group pb-3">
                        <input type="text" placeholder="Name" class="form-control">
                    </div>
                    <div class="form-group pb-3">
                        <input type="email" placeholder="Email" class="form-control">
                    </div>
                    <div class="form-group pb-3">
                        <input type="password" placeholder="Password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="form-group pb-3">
                        <input type="password" placeholder="Confirm Password" class="form-control"
                            id="exampleInputPassword1">
                    </div>

                    <div class="pb-2">
                        <button type="submit" class="btn btn-primary w-100 font-weight-bold mt-2">Sign Up</button>
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
export default {
    name: "Registration",
}
</script>
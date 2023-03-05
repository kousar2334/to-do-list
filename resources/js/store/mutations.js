export default {
    /**
     * Set customer login state
     */
    userLogin(state, data) {
        if (data.token_refresh) {
            state.userToken = data.access_token;
            localStorage.setItem("userToken", JSON.stringify(state.userToken));
        }

        state.isUserLogin = true;
        localStorage.setItem("isUserLogin", JSON.stringify(state.isUserLogin));

        state.authUser = data.user;
        localStorage.setItem("authUser", JSON.stringify(state.authUser));
    },

    userLogout(state) {
        state.isUserLogin = false;
        state.userToken = "";
        state.authUser = {};
        localStorage.removeItem("isUserLogin");
        localStorage.removeItem("authUser");
        localStorage.removeItem("userToken");
    },
};

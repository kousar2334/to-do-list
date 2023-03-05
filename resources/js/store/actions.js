export default {
    /**
     * Set user login state
     */
    userLogin(context, data) {
        context.commit("userLogin", data);
    },
    /**
     * user logout
     */
    userLogout(context) {
        context.commit("userLogout");
    },
};

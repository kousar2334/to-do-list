import { createStore } from "vuex";
import actions from "./actions";
import mutations from "./mutations";
import getters from "./getters";
const store = createStore({
    state() {
        return {
            userToken: JSON.parse(localStorage.getItem("userToken")) || "",
            authUser: JSON.parse(localStorage.getItem("authUser")) || {},
            isUserLogin:
                JSON.parse(localStorage.getItem("isUserLogin")) || false,
        };
    },
    mutations,
    actions,
    getters,
});

export default store;

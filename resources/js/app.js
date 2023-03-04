import { createApp } from "vue";
import App from "./App.vue";
import router from "./router/index.js";
import BootstrapVue3 from "bootstrap-vue-3";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
library.add(fas);
const app = createApp(App);
app.use(router);
app.component("font-awesome-icon", FontAwesomeIcon);
app.use(BootstrapVue3);
app.mount("#app");

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue-3/dist/bootstrap-vue-3.css";

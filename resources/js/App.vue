<template>
    <component :is="layout">
        <routerView />
    </component>
</template>
<script>
import AppLayout from "./layouts/AppLayout";
export default {
    name: "App",
    components: {
        AppLayout,
    },
    computed: {
        layout() {
            return AppLayout;
        },
    },
};
</script>

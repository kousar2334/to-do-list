<template>
    <div class="app-layout">
        <Header />
        <div class="main_content container">
            <slot />
        </div>
        <Footer />
    </div>
</template>
<script>
import Header from '../components/Header.vue';
import Footer from '../components/Footer.vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import { onMounted } from 'vue';
import axios from 'axios';
export default {
    name: "AppLayout",
    components: { Header, Footer },
    setup() {
        const store = useStore();
        const router = useRouter();
        onMounted(() => {
            if (store.getters.isUserLogin) {
                refresh();
                setInterval(refresh, 1000 * 60);

            }
        });

        function refresh() {
            axios.get('api/v1/token-refresh', {
                headers: {
                    Authorization: `Bearer ${store.getters.userToken}`,
                },
            }).then((response) => {
                if (response.data.success) {
                    this.$store.dispatch("userLogin", response.data);
                }
                if (!response.data.success) {
                    store.dispatch('userLogout').then(() => {
                        router.push('/login')
                    });
                }

            }).catch((error) => { });
        }

        return {
            refresh,
        }
    }
}
</script>
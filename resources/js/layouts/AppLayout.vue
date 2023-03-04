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
export default {
    name: "AppLayout",
    components: { Header, Footer }
}
</script>
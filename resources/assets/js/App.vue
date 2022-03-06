<template>
    <div>
        <navbar></navbar>
        <router-view></router-view>
        <Footer></Footer>
    </div>
</template>

<script>
import Footer from "./components/includes/Footer";
export default {
    components:{
        Footer
    }
}
</script>

<style scoped>

</style>
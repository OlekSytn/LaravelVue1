<template>
    <main class="app-content">
        <p>Welcome To My world {{ user.name }}</p>
    </main>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: "AdminScreen",
    computed:{
        ...mapGetters(['user'])
    }
}
</script>

<style>
    .add_button {
        position: absolute;
        top: 5%;
        right: 5%;
    }
</style>
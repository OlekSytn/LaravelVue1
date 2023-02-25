<template>
  <div>
    <Loader v-if="loader"/>
    <router-view></router-view>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Loader from './common/Loader.vue';
export default {
    name: "AuthLayout",
    computed: {
        ...mapGetters(["loader"])
    },
    components: { Loader }
};
</script>

<style>
</style>
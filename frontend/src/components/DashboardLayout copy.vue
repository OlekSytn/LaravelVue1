<template>
  <div>
     <Loader v-if="loader"/>
     <!-- Navbar-->
     <header class="app-header">
         <router-link to="/admin"  class="app-header__logo" >Appnap</router-link>
        <!-- Sidebar toggle button--><a
           class="app-sidebar__toggle sidebar_menu"
           href="#"
           @click="sidebarMenuToggle"
           data-toggle="sidebar"
           aria-label="Hide Sidebar"
           ></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
           <!-- User Menu-->
           <li class="dropdown">
              <a
                 class="app-nav__item sidebar"
                 href="#"
                 
                 data-toggle="dropdown"
                 aria-label="Open Profile Menu"
                 ><i class="fa fa-user fa-lg"></i
                 ></a>
              <ul class="dropdown-menu settings-menu dropdown-menu-right">
                 <li>
                    <a class="dropdown-item" href="#" @click="handleLogout"
                       ><i class="fa fa-sign-out fa-lg"></i> Logout</a
                       >
                 </li>
              </ul>
           </li>
        </ul>
     </header>
     <!-- Sidebar menu-->
     <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
     <aside class="app-sidebar" v-if="sidebar">
        <div class="app-sidebar__user">
           <div>
              <p class="app-sidebar__user-name">{{ user.name }}</p>
           </div>
        </div>
        <ul class="app-menu">
           <li>
              <router-link class="app-menu__item" to="/admin">
                 <i class="app-menu__icon fa fa-dashboard"></i>
                 <span class="app-menu__label">Dashboard</span>
              </router-link>
           </li>
           <li>
              <router-link class="app-menu__item" to="categories">
                 <i class="app-menu__icon fa fa-snowflake-o"></i>
                 <span class="app-menu__label">Category</span>
              </router-link>
           </li>
           <li>
              <router-link class="app-menu__item" to="products">
                 <i class="app-menu__icon fa fa-gift"></i
                    ><span class="app-menu__label">Product</span>
              </router-link>
           </li>
        </ul>
     </aside>
     <router-view></router-view>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Vue from 'vue';
import Loader from './common/Loader.vue';
export default {
    name: "DashboardScreen",
    data(){
      return {
         sidebar: true
      }
    },
    methods: {
        handleLogout() {
            localStorage.removeItem("token");
            Vue.$toast.open({
                message: "Logout successfully",
                type: "success",
                position: "top"
            });
            this.$store.dispatch("user", null);
            this.$router.push("/");
        },
        sidebarMenuToggle(){
         if(this.sidebar === false && window.innerWidth > 710){
            this.sidebar = !this.sidebar
         }  
         
         if( window.innerWidth < 710) {
            this.sidebar = !this.sidebar
         }
               
        }
    },
    computed: {
        ...mapGetters(["user", "loader"])
    },
    components: { Loader }
};
</script>

<style scoped>
</style>
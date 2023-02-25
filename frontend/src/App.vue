<template>
  <div id="app">
    <AuthLayout v-if="authenticationRoute.includes(this.$route.name) == true" />    
    <DashboardLayout v-else />
  </div>
</template>

<script>
import axios from 'axios';
import AuthLayout from './components/AuthLayout.vue'
import DashboardLayout from './components/DashboardLayout.vue';
export default {
  name: 'App',
  components:{
    AuthLayout,
    DashboardLayout
  },
  async created(){
    const token = localStorage.getItem("token");
    if(!token){          
      if(!this.authenticationRoute.includes(this.$route.name)){
        this.$router.push("/");
      }      
    }else{    
        const token    = await localStorage.getItem('token');
        const response = await axios.get("/auth/user-info", { headers: {Authorization: 'Bearer ' + token }  }); 
        if(response.data.success === true){ // success request   
          this.$store.dispatch("user", response.data.data);
        }else{ // failed request
          this.$router.push("/");
        }
    }    
  },
   computed: {
    authenticationRoute () {
      return ['register', 'login', 'forget-password', 'reset-password', 'home', 'product-details' ]
    }
  }
}
</script>

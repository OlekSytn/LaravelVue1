<template>
  <div>
     <section class="material-half-bg">
        <div class="cover"></div>
     </section>
     <section class="login-content">
        <div class="logo">
           <h1>Appnap</h1>
        </div>
        <div class="login-box">
           <form class="login-form" @submit.prevent="handleSubmitPasswordReset">
              <h3 class="login-head">
                 <i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?
              </h3>
              <div class="form-group">
                 <label class="control-label">Password</label>
                 <input class="form-control" v-model="password" type="password" placeholder="New Password" />
              </div>
              <div class="form-group">
                 <label class="control-label">Confirm Password</label>
                 <input class="form-control" v-model="confirm_password" type="password" placeholder="Confirm Password" />
              </div>
              <div class="form-group mt-3">
                 <p class="semibold-text mb-0">
                    <router-link to="/login"><i class="fa fa-angle-left fa-fw"></i> Back to Login</router-link>
                 </p>
              </div>
              <div class="form-group btn-container">
                 <button class="btn btn-primary btn-block">
                 <i class="fa fa-unlock fa-lg fa-fw"></i>Password Reset
                 </button>
              </div>
           </form>
        </div>
     </section>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
export default {
  name: "ResetPasswordScreen",
  data(){
    return {
      password: null,
      confirm_password: null
    }
  },
  methods:{
    async handleSubmitPasswordReset(){
      const token = this.$route.params.token;
      const data = {
        password: this.password,
        confirm_password: this.confirm_password
      }

      try{
         const response =  await axios.post(`/auth/reset-password/${token}`, data);
         if(response.data.success === true){ // success request  
            Vue.$toast.open({
               message:  response.data.message,
               type: "success",
               position: 'top'
            });
            this.$router.push("/login")
         }else{ // failed request
            Vue.$toast.open({
               message: response.data.message,
               type: "error",
               position: 'top'
            });
         }



      }catch(error){
        console.log(error)
      }

    }
  }
};
</script>

<style >
</style>
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
           <form class="login-form" @submit.prevent="handlePasswordResetMailSent">
              <h3 class="login-head">
                 <i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?
              </h3>
              <Error  v-if="error" :error="error" />
              <div class="bs-component" v-if="mail_sent">
                 <div class="alert alert-dismissible alert-success">
                    <button class="close" type="button" data-dismiss="alert">×</button><strong>{{ mail_sent }}!</strong>. Please check your inbox
                 </div>
              </div>
              <div class="form-group">
                 <label class="control-label">EMAIL</label>
                 <input class="form-control" type="email" v-model="email" placeholder="Email" />
              </div>
              <div class="form-group mt-3">
                 <p class="semibold-text mb-0">
                    <router-link to="login"
                       ><i class="fa fa-angle-left fa-fw"></i> Back to Login</router-link>
                 </p>
              </div>
              <div class="form-group btn-container">
                 <button class="btn btn-primary btn-block">
                 <i class="fa fa-unlock fa-lg fa-fw"></i>RESET
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
import Error from '../common/Error.vue';
export default {
    name: "ForgetPasswordScreen",
    data() {
        return {
            email: "",
            mail_sent: null,
            error: ""
        };
    },
    methods: {
        // send password reset mail
        async handlePasswordResetMailSent() {
          this.$store.dispatch("loader", true);
            const data = {
                email: this.email
            };
            try {
                const response = await axios.post("/auth/forget-password", data);
                this.$store.dispatch("loader", false);
                if(response.data.success === true){ // success request  
                   
                  this.mail_sent = response.data.message;
                  Vue.$toast.open({
                     message: response.data.message,
                     type: "success",
                     position: "top"
                  });
                 }else{ // failed request
                   Vue.$toast.open({
                     message: response.data.message,
                     type: "error",
                     position: 'top'
                   });
                 }

                
            }
            catch (error) {
              this.$store.dispatch("loader", false);
              this.error = error.message;
            }
        }
    },
    components: { Error }
};
</script>

<style >
</style>
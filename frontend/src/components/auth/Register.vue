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
           <form class="login-form" @submit.prevent="handleSubmitRegister">
              <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN UP</h3>
              <!-- <Error  v-if="error" :error="error" /> -->
              <div class="form-group">
                 <label class="control-label">Full Name</label>
                 <input class="form-control" type="text" v-model="name" placeholder="Full Name" autofocus />
              </div>
              <div class="form-group">
                 <label class="control-label">Email</label>
                 <input class="form-control" type="email" v-model="email" placeholder="Email" autofocus />
              </div>
              <div class="form-group">
                 <label class="control-label">PASSWORD</label>
                 <input class="form-control" type="password" v-model="password" placeholder="*********" />
              </div>
              <div class="form-group">
                 <label class="control-label">CONFIRM PASSWORD</label>
                 <input class="form-control" type="password" v-model="confirm_password" placeholder="*********" />
              </div>
              <div class="form-group">
                 <div class="utility">
                    <p class="semibold-text mb-2">
                       <router-link to="login">Already have an account ?</router-link>
                    </p>
                 </div>
              </div>
              <div class="form-group btn-container">
                 <button type="submit" class="btn btn-primary btn-block">
                 <i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN UP
                 </button>
              </div>
           </form>
        </div>
     </section>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue';
export default {
    name: "RegisterScreen",
    data() {
        return {
            name: "",
            email: "",
            password: "",
            confirm_password: "",
            error: ""
        };
    },
    methods: {
        async handleSubmitRegister() {
          this.$store.dispatch("loader", true);
            const data = {
                name: this.name,
                email: this.email,
                password: this.password,
                confirm_password: this.confirm_password,
            };
            try {              
                const res = await axios.post("/auth/registration", data);
                  this.$store.dispatch("loader", false);

                  if(res.data.success === true){
                     Vue.$toast.open({
                        message: res.data.message,
                        type: "success",
                        position: "top"
                     });
                     localStorage.setItem("token", res.data.data.token);
                     this.$store.dispatch("user", res.data.data);
                     this.$router.push("/admin");
                  }else{
                     Vue.$toast.open({
                     message: res.data.message,
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
    }
};
</script>

<style scoped>
.login-box {
    height: 576px!important;
}
</style>
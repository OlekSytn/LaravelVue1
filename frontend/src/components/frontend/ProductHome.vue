<template>
  <div>
     <header>
        <div class="navbar navbar-dark bg-dark box-shadow">
           <div class="container d-flex justify-content-between">
              <a href="#" class="navbar-brand d-flex align-items-center">
                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                 </svg>
                 <strong>Appnap Assignment</strong>
              </a>
              <div>
                 <router-link :to="{ name: 'login' }" class="link" >Login</router-link>
                 <router-link :to="{ name: 'register' }" class="link">Register</router-link>
              </div>
           </div>
        </div>
     </header>
     <main role="main">
        <div class="album py-5 bg-light">
           <div class="container">
              <div class="row">
                 <div class="col-md-4" v-for="product in products" :key="product.id">
                    <div class="card mb-4 box-shadow">
                       <img class="card-img-top" :src="product.image" alt="Card image cap">
                       <div class="card-body">
                          <h5 class="card-text">{{ product.name }} </h5>
                          <p>Product Owner: {{ product.user }}</p>
                          <p>Category: {{ product.category }}</p>
                          <div class="d-flex justify-content-between align-items-center">
                             <div class="btn-group">
                                <router-link :to="{ name: 'product-details', params: { id: product.id }}" class="btn btn-sm btn-outline-secondary">View</router-link>
                             </div>
                             <small class="text-muted price">$ {{ product.price }}</small>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </main>
  </div>
</template>

<script>
import axios from 'axios';
import Vue from 'vue';
export default {
    name: "ProductHomeScreen",
    data(){
      return {
        products: [],
      }
    },
    methods:{
      // fetch all product list
      async getProducts(){       
         this.$store.dispatch("loader", true);    
         const response = await axios.get("/guest/products");
         this.$store.dispatch("loader", false); //loader off
         if(response.data.success === true){ // success request                 
            this.products = response.data.data
         }else{ // failed request
            Vue.$toast.open({
               message: response.data.message,
               type: "error",
               position: 'top'
            });
         }
      }
    },
    mounted() {
      this.getProducts();
    }
}
</script>

<style>
    .add_button {
        position: absolute;
        top: 5%;
        right: 5%;
    }
    .link {
        text-transform: uppercase;
        font-weight: bold;
        color: white;
        margin-right: 12px;
    }
    .price{
      font-weight: bold;
      font-size: 14px;
      color: black;
    }
</style>
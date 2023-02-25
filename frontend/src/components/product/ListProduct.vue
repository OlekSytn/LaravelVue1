<template>
  <main class="app-content">
     <div class="col-md-10 offset-md-1">
        <div class="tile">
           <h3 class="tile-title">Product</h3>
           <router-link :to="{ name: 'add_product' }" class="add_button btn btn-primary" type="button"><i class="fa fa-plus-circle"></i>  Add New</router-link>
           <div class="table-responsive-all">
            <table class="table table-striped ">
              <thead>
                 <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>User</th>
                    <th>Created</th>
                    <th>Action</th>
                 </tr>
              </thead>
              <tbody>
                 <tr v-for="product in products" :key="product.id">
                    <td>{{ product.id }}</td>
                    <td>
                       <img :src="product.image" class="box_image" />  
                    </td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.category }}</td>
                    <td>{{ product.user }}</td>
                    <td>{{ product.created_at }}</td>
                    <td>
                       <router-link :to="{ name: 'edit_product', params: { id: product.id }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square"></i></router-link>
                       ||
                       <button class="btn btn-sm btn-danger" @click="removeProduct(product.id)"><i class="fa fa-trash"></i></button>  
                    </td>
                 </tr>
              </tbody>
           </table>
           </div>
          
        </div>
     </div>
  </main>
</template>

<script>
import axios from 'axios';
import Vue from 'vue';
export default {
    name: "ListProduct",
    data(){
      return {
        products: [],
      }
    },
    methods:{
        // fetch all products
        async getProducts(){       
          this.$store.dispatch("loader", true);   
          const token    = await localStorage.getItem('token');
          const response = await axios.get("/products", { headers: {Authorization: 'Bearer ' + token }  });
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
        },

        // delete products
        async removeProduct(id){
          if(confirm("Are you sure? You want to delete this product?")){
            this.$store.dispatch("loader", true);    
            const token    = await localStorage.getItem('token');
            const response = await axios.delete(`/products/${id}`, { headers: {Authorization: 'Bearer ' + token }  });
            this.$store.dispatch("loader", false); //loader off
            if(response.data.success === true){ // success request                  
              Vue.$toast.open({
                message: response.data.message,
                type: "success",
                position: 'top'
              });
              this.getProducts();
            }else{ // failed request
              Vue.$toast.open({
                message: response.data.message,
                type: "error",
                position: 'top'
              });
            }    

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
        top: 3%!important;
        right: 5%!important;
    }
    .box_image{
      height: 50px!important;
      width: 50px!important;
      border-radius: 50%;
      border: 2px solid #ccc;
    }
    .table-responsive-all{
      overflow-x: scroll!important;;
    }
</style>
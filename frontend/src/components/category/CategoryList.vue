<template>
  <main class="app-content">
     <div class="col-md-6 offset-md-3">
        <div class="tile">
           <h3 class="tile-title">Category</h3>
           <router-link to="/categories/create" class="add_button btn btn-primary" type="button"><i class="fa fa-plus-circle"></i>  Add New</router-link>
            <div class="table-responsive-all">
              <table class="table table-sm table-striped">
                <thead>
                  <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Created</th>
                      <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="category in categories" :key="category.id">
                      <td>{{ category.id }}</td>
                      <td>{{ category.name }}</td>
                      <td>{{ category.created_at }}</td>
                      <td>
                        <router-link :to="{ name: 'category_edit', params: { id: category.id }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square"></i></router-link>
                        ||
                        <button class="btn btn-sm btn-danger" @click="removeCategory(category.id)"><i class="fa fa-trash"></i></button>  
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
    name: "AddCategory",
    data(){
      return {
        categories: [],
      }
    },
    methods:{
        // fetch all category
        async getCategories(){       
          this.$store.dispatch("loader", true);  
          const token = await localStorage.getItem('token');  
          const response = await axios.get("/categories",{ headers: {Authorization: 'Bearer ' + token }  });
          this.$store.dispatch("loader", false); //loader off
          if(response.data.success === true){ // success request                 
            this.categories = response.data.data
          }else{ // failed request
            Vue.$toast.open({
              message: response.data.message,
              type: "error",
              position: 'top'
            });
          }
        },

        // delete category
        async removeCategory(id){
          if(confirm("Are you sure? You want to delete it?")){
            this.$store.dispatch("loader", true);   
            const token = await localStorage.getItem('token');  
            const response = await axios.delete(`/categories/${id}`, { headers: {Authorization: 'Bearer ' + token }  });
            this.$store.dispatch("loader", false); //loader off
            if(response.data.success === true){ // success request                  
              Vue.$toast.open({
                message: response.data.message,
                type: "success",
                position: 'top'
              });
              this.getCategories();
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
      this.getCategories();
    }
}
</script>

<style scoped>
    .add_button {
        position: absolute;
        top: 3%!important;
        right: 5%!important;
    }
    .table-responsive-all{
      overflow-x: scroll;
    }
</style>
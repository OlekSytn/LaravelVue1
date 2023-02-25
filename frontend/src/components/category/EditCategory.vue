<template>
  <main class="app-content">
     <div class="col-md-6 offset-md-3">
        <div class="tile">
           <h3 class="tile-title">Category Update</h3>
           <div class="tile-body">
              <form @submit.prevent="handleCategoryUpdate">
                 <div class="form-group">
                    <label class="control-label">Name</label>
                    <input class="form-control" v-model="name" type="text" placeholder="Category Name">
                 </div>
                 <div class="tile-footer">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>                
                 </div>
              </form>
           </div>
        </div>
     </div>
  </main>
</template>

<script>
import axios from 'axios'
import Vue from 'vue';
export default {
    name: "AddCategory",
    data() {
        return {
            name: "",
        };
    },
    mounted() {
        
      this.getCategoryDetails();
    },
    methods: {
        // fetch category details
        async getCategoryDetails(){    
          this.$store.dispatch("loader", true);   
          const token = await localStorage.getItem('token');  
          const response = await axios.get(`/categories/${this.$route.params.id}`, { headers: {Authorization: 'Bearer ' + token }  });
          this.$store.dispatch("loader", false); //loader off
          if(response.data.success === true){ // success request                 
            this.name = response.data.data.name;
          }else{ // failed request
            Vue.$toast.open({
              message: response.data.message,
              type: "error",
              position: 'top'
            });
          }
        },

        // update category
        async handleCategoryUpdate() {
            this.$store.dispatch("loader", true);
            const data = {
                name: this.name,
            };
            const token = await localStorage.getItem('token'); 
            const response = await axios.patch(`/categories/${this.$route.params.id}`, data, { headers: {Authorization: 'Bearer ' + token }  });
            this.$store.dispatch("loader", false); //loader off
            if(response.data.success === true){ // success request                  
                Vue.$toast.open({
                    message: response.data.message,
                    type: "success",
                    position: 'top'
                });
                this.$router.push("/categories");
            }else{ // failed request
                Vue.$toast.open({
                    message: response.data.message,
                    type: "error",
                    position: 'top'
                });
            } 
            
        }
    }
}
</script>

<style scoped>
    
</style>
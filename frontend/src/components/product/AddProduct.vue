<template>
  <main class="app-content">
     <div class="col-md-6 offset-md-3">
        <div class="tile">
           <h3 class="tile-title">Product Add</h3>
           <div class="tile-body">
              <form @submit.prevent="handleProductAdd" enctype="multipart/form-data">
                 <div class="form-group">
                    <label class="control-label">Name</label>
                    <input class="form-control" v-model="formData.name" type="text" placeholder="Name">
                 </div>
                 <div class="form-group">
                    <label class="control-label">Details</label>
                    <input class="form-control" v-model="formData.details" type="text" placeholder="Details">
                 </div>
                 <div class="form-group">
                    <label class="control-label">Price</label>
                    <input class="form-control" v-model="formData.price" type="number" placeholder="Price">
                 </div>
                 <div class="form-group">
                    <label for="exampleSelect1">Select Category</label>
                    <select class="form-control" id="exampleSelect1" @change="handleCategoryChange">
                       <option value="">Select Product</option>
                       <option v-for="item in categories" v-bind:key="item.id" :value="item.id">{{item.name}}</option>
                    </select>
                 </div>
                 <div class="form-group">
                    <label class="control-label">Image</label>
                    <input class="form-control" type="file" accept="image/*" @change="handleFileObject()" id="customFile" ref="file">               
                 </div>
                 <div class="tile-footer">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>                
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
// import Vue from 'vue';
export default {
    name: "AddProduct",
    data() {
        return {
            formData:{
                name: '',
                details: '',
                price: '',
                category_id: '',
                image: ''
            },
            image: null,
            categories:[]
        };
    },
    mounted() {
      this.getCategories();
    },
    methods: {
        // fetch all category
        async getCategories(){
             const token           = await localStorage.getItem('token');
             const response        = await axios.get('categories', { headers: {Authorization: 'Bearer ' + token }  });
                   this.categories = response.data.data
        },

        // category  changes event
        handleCategoryChange(event){
            this.formData.category_id = event.target.value
        },

        // product add
        async  handleProductAdd() {
            let formData = new FormData()
            formData.append('image', this.image)
            formData.append('name', this.formData.name)
            formData.append('details', this.formData.details)
            formData.append('category_id', this.formData.category_id)
            formData.append('price', this.formData.price)

            const token = await localStorage.getItem('token'); 
            const response = await axios.post('/products', formData, { headers: {Authorization: 'Bearer ' + token }  });
            this.$store.dispatch("loader", false); //loader off
            if(response.data.success === true){ // success request                  
                Vue.$toast.open({
                    message: response.data.message,
                    type: "success",
                    position: 'top'
                });
                this.$router.push("/products");
            }else{ // failed request
                Vue.$toast.open({
                    message: response.data.message,
                    type: "error",
                    position: 'top'
                });
            } 
      },
      // file selected handler
      handleFileObject() {
        this.image = this.$refs.file.files[0]
      }
    }
    
}
</script>

<style>
    .add_button {
        position: absolute;
        top: 5%;
        right: 5%;
    }
</style>
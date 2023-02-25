<template>
  <div>
     <header>
        <div class="navbar navbar-dark bg-dark box-shadow">
           <div class="container d-flex justify-content-between">
              <router-link to="/"  class="navbar-brand d-flex align-items-center">
                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                 </svg>
                 <strong>Appnap Assignment</strong>
              </router-link>
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
              <div>
                 <div class="container container-space">
                    <div class="row">
                       <div class="col-md-6">
                          <img class="img-fluid product_image" :src="image" alt="" />
                          <div class="product-thumbnails">
                             <ul>
                                <li v-for="(image, index) in productImages" :class="[activeClass == index ? 'thumbnail-active': '']" :key="index"><img @click="currentThumnail(image.imageUrl, index)" :src="image.imageUrl" alt="" /></li>
                             </ul>
                          </div>
                       </div>
                       <div class="col-md-4">
                          <p>{{category}} Company</p>
                          <h3 class="text-uppercase">{{name}}</h3>
                          <h3 class="my-3">            
                             $ {{price}}
                          </h3>
                          <h3 class="my-3">Details</h3>
                          <ul>
                             <li>Category : {{category}}</li>
                             <li>Owner : {{user}}</li>
                             <li>Details : {{details}}</li>
                          </ul>
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
import axios from 'axios'
export default {
    name: "ProductDetailsScreen",   
  data () {
    return {
        name: "",
        price: "",
        details: "",
        category: "",
        user: "",
        image: "",
        productImages: [
            {
                id: 1,
                imageUrl: ""
            }
        ],
        activeClass: 0
    }
  },
  mounted() {
      this.getProductInfo();
    },
  methods: {
   // image gallery 
    currentThumnail: function (image, index) {
      this.bannerImage = image;
      this.activeClass = index;
    },

    // fetch single product details
    async getProductInfo(){
        const response      = await axios.get(`/guest/products/${this.$route.params.id}/details`);
        const data          = response.data.data;
              this.name     = data.name;
              this.price    = data.price;
              this.details  = data.details;
              this.image = data.image;
              this.productImages[0].imageUrl = data.image;
              this.category = data.category;
              this.user = data.user;
    },

  }

}
</script>

<template>
    <div class="">
        
        <div class="product-single-container product-single-default">
            <div class="row">
                <div class="col-md-6 d-sm-block d-md-none product-single-gallery">
                    <images  :image="image" :images="images" />
                    
                </div><!-- End .product-single-gallery -->
                <div class="col-md-7">
                    <images  :image="image" :images="images" />
                </div><!-- End .col-md-8 -->
                
                <div v-for="(img,index)  in variant_images" :key="img.id"  :id="index" class="border   d-none col-md-7">
                    <div class="product-single-gallery popup-gallery">
                        <div class="row no-gutters">
                            <div class="col-6 d-none d-lg-block d-xl-block  d-md-block  product-item">
                                <div class="inner">
                                    <img  :data-zoom-image="img.image_to_show" :src="img.image_to_show"   alt="product name">
                                    
                                </div>
                            </div><!-- End .col-6 -->
                            <div  v-for="image in img.images" :key="image.id"  class="col-6 d-none d-xl-block  d-md-block  product-item">
                                <div class="inner">
                                    <img  :src="image.image"   :data-zoom-image="image.image" alt="product name">
                                    <span   class="prod-full-screen">
                                        <i class="fas fa-search-plus fa-3x"></i>
                                    </span>
                                </div>
                            </div><!-- End .col-6 -->
                           
                        </div><!-- End .row -->
                    </div><!-- End .product-single-gallery -->
                </div><!-- End .col-md-8 -->

                <div id="imageModal" class="image-modal">
                    <span class="image-modal-close close">&times;</span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-1 product-single-gallery d-none d-lg-block">
                                <div class="prod-thumbnail owl-dots" id='carousel-custom-dots'>
                                    <div  class="owl-dot">
                                        <img  class="animated"    @click.prevent="currentSlide(product.image_to_show)"  :src="image_tn" />
                                    </div>
                                    <div   v-for="image in images" :key="image.id"  class="owl-dot">
                                        <img :src="image.image_tn"   @click.prevent="currentSlide(image.image)"  :alt="image.image_tn">
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-10 product-single-gallery">
                                <div class="product-slider-container">
                                    <div class="product-single-carousel owl-carousel owl-theme">
                                        <div class="product-item">
                                            <img class="product-single-image"    :data-zoom-image="image" :src="image" />
                                        </div>
                                        <div v-for="image in  images" :key="image.id" class="product-item">
                                            <img  class="product-single-image"   :data-zoom-image="image.image" :src="image.image"  v-if="image.image !== ''"  :alt="image.image_tn">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none d-sm-block d-md-none">
                                    <div class="prod-thumbnail-under owl-dots tn" id='carousel-custom-dots'>
                                        <div  class="owl-dot">
                                            <img  class="animated"    @click.prevent="currentSlide(product.image_to_show)"  :src="image_tn" />
                                        </div>
                                        <div   v-for="image in images" :key="image.id"  class="owl-dot">
                                            <img :src="image.image_tn"   @click.prevent="currentSlide(image.image)"  :alt="image.image_tn">
                                        </div> 
                                    </div>
                                </div>
                                
                            </div><!-- End .product-single-gallery -->
                        </div>
                    </div>
                </div>


               


                <div class="col-md-5 product-single-details mt-3 mt-sm-5  mt-xs-5">
                    <div class="p text-center ">
                        <div v-if="product.brand" class="tag mb-1 brand-name bold color--gray">{{ product.brand_name }}</div>

                        <p class="product-title  border-bottom pb-2">{{ product.product_name }}</p>

                        <div class="product-item-prices d-flex justify-content-center mt-2"  v-if="discounted_price">
                            <div class="product--price--amount ">
                                <span class="retail--title text-gold">SALE PRICE</span>
                                <span class="product--price text-danger">{{ product.currency }}{{ discounted_price | priceFormat }}</span>
                                <span class="retail--title">{{ percentage_off }}% off</span>
                            </div>
                            <div class="product--price--amount retail">
                                <span class="retail--title text-gold">PRICE</span>
                                <span class="product--price retail--price text-gold">{{ product.currency }}{{ price | priceFormat }}</span>
                                <span class="retail--title"></span>
                            </div>
                        </div>

                        <div class="product-item-prices  d-flex justify-content-center  mt-2" v-else>
                            <div class="product--price--amount">
                                <span class="retail--title text-gold">PRICE</span>
                                <span class="product--price">{{ product.currency }}{{ price | priceFormat }}</span>
                                <span class="retail--title"></span>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                   
                    <div class="">
                            <!--Product Variations Form-->
                        <div class="row">
                            <!--Select Size-->
                            <div v-if="Object.keys(attributes).length !== 0"  class="col-12 mt-2 text-center">
                                <div   v-for="map, key in attributes" :key="key" class="">
                                    <label class="d-block">{{ key }}:  <span v-if="key == 'Colors' ">{{ color }}</span></label>
                                    <div :id="'productV-' +key" class="d-flex mb-1 justify-content-center">
                                        <div  @click="getAttribute($event,key)" :data-name="key" @mouseenter="showColor(children)" @mouseleave="removeColor" :class="[ index== 0 ? 'active-attribute  ' : '', activeObject]" v-if="key == 'Colors' " :data-value="children" v-for="(children,index) in map" :key="children" :style="{ 'background-color': children }" style="height: 30px; width: 30px; border-radius: 50%; cursor: pointer;" class="mr-1 first-attribute"></div>
                                        <template v-if="attributesData.length">
                                            <div  @click="getAttribute($event,key)" :data-name="key" v-if="key != 'Colors' "     :class="[ index== 0 ? 'bold active-other-attribute' : 'border']" :data-value="children" v-for="(children,index) in attributesData" :key="children"  style="height: 35px; width: auto; border-radius: 5%; cursor: pointer;" class="mr-1 border pr-3  pl-3 o-a pt-1 other-attribute">{{ children }} </div>
                                        </template>
                                        <template v-else>
                                            <div  @click="getAttribute($event,key)"  :data-name="key"  :class="[ index== 0 ? 'bold active-other-attribute ' : '']" v-if="key != 'Colors' " :data-value="children" v-for="(children,index) in map" :key="children"  style="height: 35px; width: auto; border-radius: 5%; cursor: pointer;" class="mr-1  pr-3 pl-3 pt-1  border other-attribute">{{ children }} </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                           
                        </div>
                        <div class="row ml-1 mb-2 mt-2 no-gutters">

                            <div class="col-8 pr-1">
                                <button @click.prevent="addToCart"    type="button"  class="pt-4 pb-4  btn btn--primary  btn-lg btn-block">
                                    {{ cartText }}
                                    <span  v-if="loading"  class="spinner-border spinner-border-sm float-right ml-3" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="col-4">
                                <button v-if="$root.loggedIn"  @click.prevent="addToWishList"    type="button" name="add-to-cart" value="add_to_cart" class="l-f1  pt-4 pb-4  btn btn-outline  add-to-wishlist btn-lg btn-block">
                                    <span>Wishlist</span> 
                                    <span  v-if="wishlistText"  class="spinner-border spinner-border-sm float-right ml-3" role="status" aria-hidden="true"></span>
                                    <span class="float-right ">
                                        <svg v-if="is_wishlist" class="wishlist-icon-fillled mr-4">
                                            <use xlink:href="#iconStarFill">
                                               <symbol data-icon-id="starFill" id="iconStarFill"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2l2.868 6.922L22 9.844l-5.11 4.804L18.225 22 12 18.322 5.776 22l1.333-7.352L2 9.844l7.132-.922z"></path></svg></symbol>
                                            </use>
                                        </svg>
                                        <svg v-if="!is_wishlist" class="wishlist-icon mr-4 ">
                                            <use xlink:href="#iconStar">
                                            <symbol data-icon-id="star" data-icon-set="farfetch-2020" id="iconStar"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2l2.868 6.922L22 9.844l-5.11 4.804L18.225 22 12 18.322 5.776 22l1.333-7.352L2 9.844l7.132-.922L12 2zm-1.49 8.816l-3.976.513 2.733 2.57-.745 4.11L12 15.955l3.478 2.056-.745-4.111 2.733-2.57-3.975-.514L12 7.219l-1.49 3.598z"></path></svg></symbol>
                                            </use>
                                        </svg>
                                    </span>
                                </button>


                                <button v-else data-toggle="modal" data-target="#login-modal"  type="button" name="add-to-cart" value="add_to_cart" class="l-f1  pt-4 pb-4  btn btn-outline  add-to-wishlist btn-lg btn-block">
                                     <span>Wishlist</span> 
                                    <span  v-if="wishlistText"  class="spinner-border spinner-border-sm float-right ml-3" role="status" aria-hidden="true"></span>
                                    <span class="float-right ">
                                        
                                        <svg  class="wishlist-icon mr-4 ">
                                            <use xlink:href="#iconStar">
                                            <symbol data-icon-id="star" data-icon-set="farfetch-2020" id="iconStar"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2l2.868 6.922L22 9.844l-5.11 4.804L18.225 22 12 18.322 5.776 22l1.333-7.352L2 9.844l7.132-.922L12 2zm-1.49 8.816l-3.976.513 2.733 2.57-.745 4.11L12 15.955l3.478 2.056-.745-4.111 2.733-2.57-3.975-.514L12 7.219l-1.49 3.598z"></path></svg></symbol>
                                            </use>
                                        </svg>
                                    </span>
                                </button>




                            </div>
                            
                        </div>
                    </div><!-- End .product-filters-container -->   

                    <div class="col-12 mt-3 text-center">
                        <span class="bold color--gray">Estimated Delivery Time</span><br/>
                        <span>3 to 4 working days</span>
                    </div>
                    <div class="mt-2">
                        <div class="feature-boxes-container row no-gutters">
                        
                            <div class=" col-6">
                                <div class="feature-box px-sm-5 px-md-4 mx-sm-5 mx-md-3 feature-box-simple text-center">
                                   <i class="fas fa-2x fa-phone"></i> 

                                    <div class="feature-box-content">
                                        <h3 class="mb-0 pb-1">Order by phone</h3>
                                        <h5 class="m-b-3">Add us on +234 </h5>
                                        <p></p>
                                    </div><!-- End .feature-box-content -->
                                </div><!-- End .feature-box -->
                            </div><!-- End .col-md-4 -->

                            <div class="col-6">
                                <div class="feature-box px-sm-5 px-md-4 mx-sm-5 mx-md-3 feature-box-simple text-center">
                                    <i class="icon-action-undo"></i>

                                    <div class="feature-box-content">
                                        <h3 class="mb-0 pb-1">Money Back Guarantee</h3>
                                        <h5 class="m-b-3">Get your money back. Read return policy</h5>
                                        <p></p>
                                    </div><!-- End .feature-box-content -->
                                </div><!-- End .feature-box -->
                            </div><!-- End .col-md-4 -->
                        </div>

                    </div>
                </div><!-- End .product-single-details -->
            </div><!-- End .row -->

            <div class="product-single-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item pl-2">
                        <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Description</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" id="Warranty_Return" data-toggle="tab" href="#Warranty-Return" role="tab" aria-controls="Warranty-Return" aria-selected="false"> Warranty & Return</a>
                    </li>

                </ul>
                <div class="tab-content ">
                    <div class="tab-pane fade show active pl-2" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                        <div class="row">
                            <div class="col">
                                <div v-html="product.description" class="product-desc-content  pl-2 pb-2 color--primary"></div><!-- End .product-desc-content -->
                            </div>
                            <div class="col">
                                <images  :image="image" :images="images" />
                            </div>
                        </div>
                    </div><!-- End .tab-pane -->

    
                    <div class="tab-pane fade fade" id="Warranty-Return" role="tabpanel" aria-labelledby="Warranty-Return">
                        <div class="product-desc-content pl-4 pb-2 color--primary">
                            <h4>WARRANTY</h4> 
                            We offer a lifetime 100% authenticity guarantee for all of our items.</br>
                            In the improbable scenario of a sale of an inauthentic item, you will receive a 100% refund, including the cost of return.</br>
                            <h4 class="mt-2 pt-2 border-top">RETURNS</h4>
                            You can return a purchased item within 3 days of receipt.</br> 
                            No return fee is charged for returns within the Nigeria.</br>  
                            However, based on the destination country a shipping fees is charged for returns made outside of Nigeria.</br>
                            Customs duties and taxes are applicable and borne by the customer.</br>
                        </div><!-- End .product-desc-content -->
                    </div><!-- End .tab-pane -->

                    
                </div><!-- End .tab-content -->
            </div><!-- End .product-single-tabs -->

        </div><!-- End .product-single-container -->
        <login-modal :url="same" />
        <register-modal :url="same" />
    </div>
</template>
<script>

import  Images from './Images.vue'
import  LoginModal from '../auth/LoginModal.vue'
import  RegisterModal from '../auth/RegisterModal.vue'
import  { mapGetters,mapActions } from 'vuex'
import  Pagination from '../pagination/Pagination.vue'


export default {
    name: "Show",
    props:{
        product:Object,
        attributes:Object,

    },
    components:{
       Images,
       LoginModal,
       Pagination,
       RegisterModal,
       
    },
    data(){
        return {
            attributesData: [],
            color: '',
            isActive: false,
            canNotAddToCart: false,
            image:'',
            cText:   "Add To Cart",
            images:[],
            variant_images: [],
            noRating: false,
            user: Window.auth,
            file:null,
            quantity: '',
            useUrl: false,
            price:null,
            discounted_price: null,
            percentage_off: '',
            product_variation_id:'',
            product_variation:[],
            prodAttributes: null,
            category:'',
            cartSideBarOpen: false,
            loading: false,
            is_loggeIn:  false,
            is_wishlist:  null,
            image_m: '',
            image_tn: null,
            profile_photo: null,
            errorsBag:[],
            fadeIn: false,
            product_slug: this.product.slug,
            wishlistText: false,
            allowedFileTypes: ['image/jpeg','image/png','image/gif'],
            form:{
                description: null,
                rating: null,
                product_id:this.product.id ,
                image: null
            },
            submiting:false
        }
    },
    computed: {
        ...mapGetters({
            cart: 'cart' ,
            loggedIn:'loggedIn',
            wishlist:'wishlist',
            reviews: 'reviews',
            meta: 'reviewsMeta',
            errors:'errors',

        }),
        activeObject: function () {
            return {
               'active-attributes': this.isActive
            }
        },
        cartText: function() {
            return this.cText
        },
        canAddToCart: function() {
            return [this.canNotAddToCart ? 'disabled' : '' ];
        },
        loggedIn: function(){
            return [this.user ? true: false]
        },
       
        
    },
    mounted(){
        this.productReviews()
        this.image = this.product.image_to_show
        this.image_tn   =   this.product.image_to_show_tn
        this.images     =   this.product.add_images
        this.product_variation_id = this.product.default_variation_id
        this.percentage_off = this.product.default_percentage_off
        this.quantity = this.product.qty
        this.cText= this.product.qty  < 1 ? 'Out of Stock' :" Add To Cart"
        this.price =  this.product.converted_price
        this.discounted_price =  this.product.default_discounted_price
        this.is_wishlist =  this.product.is_wishlist
        this.variant_images = this.product.variants    
    },
    methods: {
        getStarRating(e,rating){
            this.form.rating = rating
            this.noRating = false
            let ratings = document.querySelectorAll('.rating')
                ratings.forEach(elm =>{
                    elm.classList.remove('active')
                })
            e.target.classList.add("active")
        },
        productReviews() {
            return axios.get('/reviews/'+ this.product_slug).then((response) => {
                this.loading = false;
                this.$store.commit('setReviews', response.data.data)
                this.$store.commit('setReviewsMeta', response.data.meta)
            }).catch((error) => {
                this.loading = false;
            }) 
        },
        getProduct() {
            axios.get('/api' + this.$route.path).then((response) => {
                let obj = response.data.data;
                this.product_variation = this.product.product_variation;
                window.Stock =  JSON.parse(obj.stock);
                window.Inventory =  JSON.parse(obj.inventory);
            })
        },
        currentSlide:  function(image) {
            this.fadeIn = !this.fadeIn;
            this.image = image 
            setTimeout(() =>{
                this.fadeIn = !this.fadeIn;
            }, 1000); // Will alert once, after a second.
           
        },
         
        getAttribute: function(evt, key) {
            this.cartError = null;
            let active_attribute = null,
                variation,
                first_attribute,
                active_other_attribute,
                other_attribute,
                oAv,
                ooA,
                iam,
                f = false,
                af = false,
                cA;
            let inventory = JSON.parse(this.product.inventory);
            let stock = JSON.parse(this.product.stock);
            first_attribute = document.querySelectorAll(".first-attribute");
            other_attribute = document.querySelectorAll(".other-attribute");
            /**
             * Toggle active statte
             */

            if (evt.target.classList.contains("first-attribute")) {
                first_attribute.forEach(function(elm, key) {
                elm.classList.remove("active-attribute");
                });
                evt.target.classList.add("active-attribute");
            }

            /**
             * Toggle active statte for other attributes
             */
            if (evt.target.classList.contains("other-attribute")) {
                other_attribute.forEach(function(elm, key) {
                elm.classList.remove("active-other-attribute");
                });
                evt.target.classList.add("active-other-attribute");
            }

            try {
                if (typeof inventory[0].length === "undefined") {
                let v = inventory[0][evt.target.dataset.value];
                for (let i in v) {
                    if (i !== evt.target.dataset.name) {
                    this.attributesData = Object.keys(v[i]);
                    }
                }
                }
                active_attribute = document.querySelector(".active-attribute");
                active_other_attribute = document.querySelector(
                ".active-other-attribute"
                );
                if (active_attribute && this.attributesData.length != 0) {
                variation =
                    active_attribute.dataset.value + "_" + this.attributesData[0];
                }
                if (active_attribute && this.attributesData.length == 0) {
                variation = active_attribute.dataset.value;
                }

                if (!active_attribute && active_other_attribute !== null) {
                variation = active_other_attribute.dataset.value;
                }

                if (
                active_attribute &&
                other_attribute.length !== 0 &&
                key != "Colors"
                ) {
                variation =
                    active_attribute.dataset.value + "_" + evt.target.dataset.value;
                }

                let vTs = stock[0][variation];
                if (key == "Colors") {
                this.image = vTs.image;
                this.image_m = vTs.image_m;
                this.images = vTs.images;
                }
                this.quantity = vTs.quantity;
                this.price = vTs.converted_price;
                this.percentage_off = vTs.percentage_off;
                this.discounted_price =
                vTs.discounted_price || vTs.default_discounted_price;
                this.product_variation_id = vTs.id;
                this.canNotAddToCart = false;
                this.cText = this.quantity >= 1 ? "Add To Cart" : "Item is sold out";
            } catch (error) {
                console.log(error);
                this.canNotAddToCart = true;
                this.cText = "Sold Out";
                this.quantity = 0;
            }
       },
        
        selectProductAttributes: function(){
            let values = [];
            let attributes = document.querySelectorAll('select.vs')
            attributes.forEach(function(elm,key){
                values.push(elm.value)
            }) 
            return values;
        },
        formatError(error){
            return Array.isArray(error) ? error[0] : error
        },
        removeError(e){
            let input = document.querySelectorAll('.rating_required');
            if (typeof input !== 'undefined'){
                this.clearErrors({  context:this, input:input })
            }
        },
        vInput(e){
            let input = document.querySelectorAll('.rating_required');
            if (typeof input !== 'undefined') {
                this.checkInput({ context: this, input:e })
            }
        }, 
        showColor(color){
           this.color = color
        },
        removeColor(color){
           this.color = ''
        },
        ...mapActions({
            addProductToCart:'addProductToCart',
            addProductToWishList: 'addProductToWishList',
            createReviews: 'createReviews',
            validateForm:  'validateForm',
            clearErrors:   'clearErrors',
            checkInput:    'checkInput',
            getReviews:    'getReviews'
        }),
        addToCart: function(){
            if (this.cText == 'Out of Stock') return;
            this.cText = "Adding...."
            this.loading = true;
            console.log(this.product_variation_id)
            this.addProductToCart({
                product_variation_id:this.product_variation_id,
                quantity: 1
            }).then(() =>{
                this.cText = "Add To Cart"
                this.loading = false;
            }).catch((error) =>{
                this.cText = "Add To Cart"
                this.loading = false
            })
        },
        addToWishList: function(){
            this.wishlistText = true
            this.addProductToWishList({
                product_variation_id:this.product_variation_id,
                context: this
            })
        }, 
        submit(){
            let input = document.querySelectorAll('.rating_required');
            this.validateForm({ context:this, input:input })
            if ( Object.keys(this.errors).length !== 0 ){ 
                if ( !this.form.rating ){
                   this.noRating = true
                }
                return false; 
            }
            this.submiting = true
            let form = new FormData();
            form.append('image',this.file)
            form.append('description',this.form.description)
            form.append('rating',this.form.rating)
            form.append('product_id',this.form.product_id)
            this.createReviews({ context: this ,form})
        }  
    }
}
</script>
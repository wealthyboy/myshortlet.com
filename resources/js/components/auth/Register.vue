<template>
    <form method="POST" @submit.prevent="submit" class="pl-4 pr-4 mt-3" action="/fashion/register">
        <span  v-if="errors.general">
            <small  class="text-danger">{{ formatError(errors.general) }}</small>
        </span>

        <div class="row ">

            
            <p class="form-group p-1 col-6">
                <label for="first_name">First Name</label>
                <input 
                    v-model="form.first_name"  
                    id="first_name" type="text" 
                    class="form-control  required"
                    name="first_name"
                    @input="removeError($event)"  
                    @blur="vInput($event)"  
                    :class="{'has-danger': errors.first_name}"
                    value="">
                    <span  v-if="errors.first_name">
                        <small  class="text-danger">{{ formatError(errors.first_name) }}</small>
                    </span>
            </p>
            <p class="form-group  p-1 col-6">
                <label for="last_name">Last Name</label>
                <input 
                    v-model="form.last_name"  
                    id="last_name" type="text" 
                    class="form-control required" 
                    name="last_name" 
                    @input="removeError($event)"  
                    @blur="vInput($event)"  
                    :class="{'has-danger': errors.last_name}"
                    value="" >
                    <span  v-if="errors.last_name">
                        <small  class="text-danger">{{ formatError(errors.last_name) }}</small>
                    </span>
            </p>
            <div class="clearfix"></div>

            <p class="form-group p-1 col-6">
                <label for="email">Email address</label>
                <input 
                    v-model="form.email" 
                    id="email" 
                    type="email"
                    class="form-control required" 
                    name="email" 
                    @input="removeError($event)"  
                    @blur="vInput($event)"  
                    :class="{'has-danger': errors.email}"
                    value="">
                    <span  v-if="errors.email">
                        <small  class="text-danger">{{ formatError(errors.email) }}</small>
                    </span>
            </p>
            <p class="form-field-wrapper  p-2  col-6">
                <label for="username">Phone number</label>
                <input 
                        v-model="form.phone_number"  
                        id="phone_number" 
                        type="text" 
                        class="form-control required" 
                        name="phone_number" 
                        @input="removeError($event)"  
                        @blur="vInput($event)"  
                        :class="{'has-danger': errors.phone_number}"
                        value="" >
                        <span  v-if="errors.phone_number">
                            <small  class="text-danger">{{ formatError(errors.phone_number) }}</small>
                        </span>
            </p>
            <div class="clearfix"></div>

            <p class="form-field-wrapper p-2 col-6">
                <label for="password">Password</label>
                <input 
                            v-model="form.password"  
                        id="password" 
                        type="password" 
                        class="form-control required" 
                        @input="removeError($event)"  
                        @blur="vInput($event)"  
                        :class="{'has-danger': errors.password}"
                        value="" >
                        <span  v-if="errors.password">
                            <small  class="text-danger">{{ formatError(errors.password) }}</small>
                        </span>
            </p>

            <p class="form-field-wrapper p-2 col-6">
                <label for="password_confirmation">Confirm Password</label>
                <input 
                        v-model="form.password_confirmation"  
                        id="password_confirmation" 
                        type="password"
                        class="form-control required"
                        name="password_confirmation" 
                        @input="removeError($event)"  
                        @blur="vInput($event)"  
                        :class="{'has-danger': errors.password_confirmation}"
                        value="" >
                        <span  v-if="errors.password_confirmation">
                            <small  class="text-danger">{{ formatError(errors.password_confirmation) }}</small>
                        </span>
            </p>
            <div class="clearfix"></div>
            <p class="form-group text-right col-12 mt-2">
                <button type="submit" :class="{ 'disabled': loading }" class="btn btn-lg btn-block btn--primary ml-1 bold" name="register" >
                    <span  v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Register
                </button>
            </p>
        
        </div>
        <p class="text-center border-top pt-5"> By registering your details, you agree with our <a class="color--primary bold" href="https://avenuemontaigne.ng/fashion/pages/terms-conditions">Terms & Conditions</a> , and <a class="color--primary bold" href="https://avenuemontaigne.ng/fashion/pages/privacy-policy">Privacy and Cookie Policy.</a> </p>

    </form>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'


export default {
    data(){
        return {
            loading:false,
            errorsBag:[],
            form: {
                email: '',
                password: '', 
                first_name: null,
                last_name: null,
                password_confirmation: null,
                phone_number: null
            }
        }
    },
    computed:{
        ...mapGetters({
            errors: 'errors'
        })
    },
    mounted(){
      // this.$store.commit('setFormErrors', null)
      console.log(true)
    },
    methods:{
        ...mapActions({
            register:'register',
            validateForm: 'validateForm',
            clearErrors: 'clearErrors',
            checkInput: 'checkInput'
        }),
        formatError(error){
            return Array.isArray(error) ? error[0] : error
        },
        removeError(e){
            let input = document.querySelectorAll('.required');
            if (typeof input !== 'undefined'){
                this.clearErrors({  context:this, input:input })
            }
        },
        vInput(e){
            let input = document.querySelectorAll('.required');
            if (typeof input !== 'undefined') {
                this.checkInput({ context: this, email: this.form.email, input:e })
            }
        },
        submit: function(){
            let input = document.querySelectorAll('.required');
            this.validateForm({ context:this, input:input })
            if ( Object.keys(this.errors).length !== 0 ){
                this.error = "Please check for errors"
                return false;
            }
            this.loading = true
            this.register({
                context:this,
            })
        }
    }
    
}
</script>

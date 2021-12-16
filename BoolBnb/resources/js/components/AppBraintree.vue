<template>
  <div id="braintree">
        <div class="row justify-content-center align-items-center">
            <SponsorshipCard v-for="sponsorship in sponsorships" :key="sponsorship.id" :sponsorship="sponsorship" @token="tokenized" />   
        </div>

        <div class="row justify-content-center p-3" v-if="payment">
            <v-braintree 
                :authorization="token"
                @success="onSuccess"
                @error="onError"
                locale="it_IT">

            </v-braintree>
        </div>     
  </div>
</template>

<script>
import Vue from 'vue';
import SponsorshipCard from './sponsorships/sponsorshipCard.vue';
import vuebraintree from 'vue-braintree';

Vue.use(vuebraintree);

export default {
    name: "appBraintree",
    data() {
        return {
            loading: true,
            sponsorships: [],
            token:'',
            payment:false,
            form:{
                token: '',
                sponsorship:''
            }
        };
    },
    mounted() {
        this.loading = true;
        axios.get("http://127.0.0.1:8000/api/api/apartments")
            .then((response) => {
            this.sponsorships = response.data.sponsorships;
            /* console.log(this.sponsorships); */
        })
            .catch((error) => {
            // handle error
            console.log(error);
        })
            .then(() => {
            this.loading = true;
        });
    },
    components: { 
        SponsorshipCard,
    },
    methods: {
        tokenized(number){
            axios.get("http://localhost:8000/api/orders")
            .then((response) => {
            this.token = response.data.token;
            /* console.log(this.token); */
            this.form.sponsorship = number;
            })
                .catch((error) => {
                // handle error
                console.log(error);
            })
                .then(() => {
                this.payment = true;
            });
        },
        onSuccess (payload) {
        let nonce = payload.nonce;
        this.form.token = nonce;

        console.log(nonce);
        this.beforeBuy();
        },
        onError (error) {
        let message = error.message;
            if (message === "no payment method is available"){
                this.error = "Seleziona un metodo di pagamento";
            }else{
                this.error = message;
            }
            this.$emit('onError', message);
        },
        beforeBuy(){
            this.buy();
        },
        buy(){
            axios.post("http://localhost:8000/api/make/payment", {...this.form})
            .then((response) => {
            let resp = response.data;
            console.log(resp);
            })
                .catch((error) => {
                // handle error
                console.log(error);
            })
                .then(() => {
                this.payment = true;
            });
        }
    },
}
</script>

<style>

</style>
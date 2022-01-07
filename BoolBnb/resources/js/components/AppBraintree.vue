<template>
  <div id="braintree">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 my-2">
                <h3 class="text-center">Sponsorizza il tuo appartamento</h3>
            </div>
            
            <SponsorshipCard v-for="sponsorship in sponsorships" :key="sponsorship.id" :sponsorship="sponsorship" @token="tokenized" @duration="duration" @price="price" /> 
            <div v-if="durations.length > 0 || prices.length > 0" class="col-12 text-center py-2 p-lg-3">
                <h5>hai scelto la sponsorizzazione da {{durations}} ore al costo di {{prices}} &euro;</h5>
            </div>
            <div v-else class="col-12 text-center py-2 p-lg-3">
                <h5>Non hai scelto la sponsorizzazione</h5>
            </div>  
        </div>
        <div class="row justify-content-center p-3" v-if="payment">
            <div class="col-12">
                <v-braintree 
                    :authorization="token"
                    @success="onSuccess"
                    @error="onError"
                    locale="it_IT"
                    btnText="Paga"
                    :vaultManager="vault"
                    @load="onLoad"
                    >
                        <template #button="slotProps">
                            <a @click="slotProps.submit" ref="paymentBtnRef"/>
                        </template>
                </v-braintree>
            </div>
            <button
                v-if="!disableBuyButton"
                class="btn _btn-color"
                @click.prevent="beforeBuy"
                >
                Procedi con l'acquisto 
            </button>
            <button
                v-else
                class="btn _btn-color-2"
                >
                {{
                    loading ? 'Caricamento...' : 'Procedi con l\'acquisto '
                }}
            </button>             
        </div>
        <div class="col-12 text-center py-2">
            <h3 class="text-danger">{{response}}</h3>
        </div>     
  </div>
</template>

<script>
import Vue from 'vue';
import SponsorshipCard from './sponsorships/sponsorshipCard.vue';
import vuebraintree from 'vue-braintree';

Vue.use(vuebraintree);

const apartmentIds = document.getElementById('apartment_id').value;

export default {
    name: "appBraintree",
    data() {
        return {
            vault: true,
            loading: false,
            sponsorships: [],
            disableBuyButton:false,
            token:'',
            payment:false,
            prices:'',
            durations:'',
            response:'',
            form:{
                token: '',
                sponsorship:'',
            }

        };
    },
    mounted() {
        axios.get("http://127.0.0.1:8000/api/api/apartments")
            .then((response) => {
            this.sponsorships = response.data.sponsorships;
            /* console.log(this.sponsorships); */
        })
            .catch((error) => {
            // handle error
            console.log(error);
        })
    },
    components: { 
        SponsorshipCard,
    },
    methods: {
        tokenized(number){
            this.loading = true;
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
                this.loading = false;
                this.payment = true;
            });
        },
        onSuccess (payload) {
        let nonce = payload.nonce;
        this.form.token = nonce;

        /* console.log(nonce); */
        this.buy()
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
             this.$refs.paymentBtnRef.click();
             this.disableBuyButton = false;
        },
        async buy(){
            this.disableBuyButton = true;
            this.loading = true;
            /* console.log(this.form); */
            axios.post("http://localhost:8000/api/make/payment", {...this.form})
            .then((response) => {
            let resp = response.data;
            this.response = resp.messagge;
            /* console.log(resp); */
            })
                .catch((error) => {
                // handle error
                console.log(error);
            })
                .then(() => {
                this.payment = false;

            });
            this.addSponsorships();
        },
        price(price){
            this.prices = price;
        },
        duration(duration){
            this.durations = duration;
        },
        onLoad(){
            this.disableBuyButton = false;
        },
        async addSponsorships(){
            try {
              let response = await axios.patch(`http://localhost:8000/api/api/apartments/${apartmentIds}`,{...this.form})
              /* console.log(response); */  
            } catch (error) {
                console.log(error);
            } 
        }
    },
}
</script>

<style lang="scss">
    @import '../../sass/_variables.scss';
    @import '../../sass/_show.scss';

</style>
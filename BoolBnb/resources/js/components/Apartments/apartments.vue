<template>
    <section id="apartment-list">
        <h1 class="text-center">Appartamenti</h1>
        <div class="row">
            <Apartment v-for="apartment in apartments" :key="apartment.id" :apartment="apartment"/>
        </div>
        
    </section>
</template>

<script>

import Apartment from './apartment';

    export default {
        name: 'Apartments',
        data() {
            return {
                apartments: [],
            }
        },
        components : {
            Apartment,
        },
        methods: {
           getApartments(){
               axios.get('http://127.0.0.1:8000/api/api/apartments')
               .then((res) => {
                   console.log(res.data.apartments)
                   this.apartments = res.data.apartments;
               })
               .catch((err)=>{
                   console.error(err);
               })
           }
        },

        mounted(){
            this.getApartments();
        }
    }
</script>
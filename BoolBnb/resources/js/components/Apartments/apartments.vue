<template>
    <section id="apartment-list">
        <h1 class="text-center">Appartamenti</h1>
            <div class="left-searchbar">
                <input id="contacts-filter" class="left-searchbar-input" type="text"
                placeholder="Cerca la città" name="search" v-model="search" >
                <button @click="searchApartment(search)" class="btn btn-primary">Cerca</button>
            </div>
        <div class="row">
            <Apartment v-for="apartment in apartments " :key="apartment.id" :apartment="apartment"/>
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
                searchCity: "",

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
           },

            searchApartment(search){
                axios.get("http://127.0.0.1:8000/api/api/apartments", {
                    params: {
                        query: search
                    }
                })
                .then( (response) => {
                    this.apartments = [];
                    response.data.apartments.forEach(element => {
                        if(element.city.toLowerCase().includes(search.toLowerCase())){
                            console.log(search);
                            if(!this.apartments.includes(element)){
                                this.apartments.push(element);
                                console.log(this.apartments);
                                this.search = "";
                            }
                        }
                    });
                }).catch( (error) =>{
                    console.log(error);
                }).then( () =>{
                    this.loading = false;
                });
            }
        },


        mounted(){
            this.getApartments();
        }
    }

</script>

<style scoped>
    .notVisible {
        display: none;
    }
</style>
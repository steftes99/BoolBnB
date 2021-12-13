<template>

    <div class="container">

        <div id="map" class='map'>

        </div>
        <section id="apartment-list">

            <h1 class="text-center">Appartamenti</h1>
                <div class="left-searchbar ">
                    <input id="contacts-filter" class="left-searchbar-input" type="text"
                    placeholder="Cerca per città" @keyup.enter="searchApartment(searchCity,searchRegion)" name="searchCity" v-model="searchCity" >
                    
                    <input id="contacts-filter" class="left-searchbar-input" type="text"
                    placeholder="Cerca per regione" @keyup.enter="searchApartment(searchCity,searchRegion)" name="searchRegion" v-model="searchRegion" >
                    
                    
                    <h3>Cerca per servizi</h3>
                    <div>
                        <div v-for="facility in facilities" :key="facility.id" class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" :id="'facility-'+facility.id" v-model="searchFacilities" name="searchFacilities[]" :value="facility.id">
                            <label class="form-check-label" :for="'facility-'+ facility.id + ''">{{facility.name}}</label>
                        </div>
                        <button @click="searchApartment(searchCity,searchRegion,searchFacilities)" class="btn btn-primary">Cerca</button>
                    </div>
                </div>
            
            <div class="row">
                <Apartment v-for="apartment in apartments " :key="apartment.id" :apartment="apartment"/>
            </div>
            
        </section>
    </div>
</template>

<script>

import Apartment from './apartment';

    export default {
        name: 'Apartments',
        data() {
            return {
                apartments: [],
                facilities:[],
                searchCity: "",
                searchRegion: "",
                searchFacilities: [],
                map:{},

            }
        },
        components : {
            Apartment,
        },

        methods: {
           getApartments(){
               axios.get('http://127.0.0.1:8000/api/api/apartments')
               .then((res) => {
                //    console.log(res.data.apartments)
                   this.apartments = res.data.apartments;
               })
               .catch((err)=>{
                   console.error(err);
               })
           },

           getFacilities(){
               axios.get('http://127.0.0.1:8000/api/api/apartments')
               .then((res) => {
                //    console.log(res.data.facilities)
                   this.facilities = res.data.facilities;
               })
               .catch((err)=>{
                   console.error(err);
               })
           },

            searchApartment(searchCity,searchRegion,searchFacilities){
                axios.get("http://127.0.0.1:8000/api/api/apartments", {
                    params: {
                        query: searchCity,
                        query: searchRegion,
                        array: searchFacilities,
                    }
                })
                .then( (response) => {
                    this.apartments = [];
                    console.log(searchFacilities);
                    response.data.apartments.forEach(apartment => {
                        if(apartment.city.toLowerCase().includes(searchCity.toLowerCase()) && 
                        apartment.region.toLowerCase().includes(searchRegion.toLowerCase())
                        // searchFacilities.filter(singleFacility => {
                            // console.log(singleFacility)
                            // apartment.facilities.filter(facility => facility.id.includes(singleFacility))
                        // })
                        
                        // searchFacilities.forEach(singleFacility =>{
                        //     // console.log(singleFacility);
                        //     apartment.facilities.forEach(facility => {
                        //         // console.log(facility);
                        //        if(singleFacility.id == facility.id ){

                        //        }
                        //     })
                        // })
                        ){
                            // console.log(searchCity);
                            // console.log(searchRegion);
                            if(!this.apartments.includes(apartment)){
                                this.apartments.push(apartment);
                                // console.log(this.apartments);
                                this.searchCity = "";
                                this.searchRegion = "";
                                this.searchFacilities = [];
                            }
                    
                        }
                    
                    });
                }).catch( (error) =>{
                    console.log(error);
                }).then( () =>{
                    this.loading = false;
                });
            },
            
        },


        mounted(){
            this.getApartments();
            this.getFacilities();

            this.map = tt.map({
                key: "CskONgb89uswo1PwlNDOtG4txMKrp1yQ",
                container:'map',
                center: [12.564874, 41.00000],
                zoom: 5,
                basePath: "/sdk"
    });
        this.map.addControl(new tt.FullscreenControl());
        this.map.addControl(new tt.NavigationControl());
        }
    }

</script>

<style scoped>
    .notVisible {
        display: none;
    }
    .map{
        width: 400px;
        height: 400px;
    }
</style>
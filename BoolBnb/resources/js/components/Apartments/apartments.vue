<template>
    <div class="container">
        <div id="map" class="map"></div>

        <section id="apartment-list">
            <h1 class="text-center">Appartamenti</h1>
                <div class="left-searchbar ">
                    <input id="contacts-filter" class="left-searchbar-input" type="text"
                    placeholder="Cerca per città o indirizzo" name="search" v-model="search" >

                    <h3>Cerca per servizi</h3>
                    <div>
                        <div v-for="facility in facilities" :key="facility.id" class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" :id="'facility-'+facility.id" v-model="searchFacilities" name="searchFacilities[]" :value="facility.id">
                            <label class="form-check-label" :for="'facility-'+ facility.id + ''">{{facility.name}}</label>
                        </div>
                        <button @click="searchApartment(search,searchFacilities)" class="btn btn-primary">Cerca</button>
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
                search:"",
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

           compareAmenities(arr1, arr2) {
                    let apartmentsAmenitiesId = [];
                    arr1.forEach((object) => {
                    apartmentsAmenitiesId.push(object.id)
                    
                    });
                    const filteredArray = arr2.filter(value => apartmentsAmenitiesId.includes(value));
                    if (filteredArray.length == arr2.length) {
                        return true;
                    }  else {
                        return false
                    }
                },
       

            searchApartment(search,searchFacilities){
                axios.get("http://127.0.0.1:8000/api/api/apartments", {
                    params: {
                        query: search,
                        array: searchFacilities,
                    }
                })
                .then( (response) => {
                    this.apartments = [];
                    // console.log(searchFacilities);
                    response.data.apartments.forEach(apartment => {
                        if((apartment.city.toLowerCase().includes(search.toLowerCase()) || 
                        apartment.address.toLowerCase().includes(search.toLowerCase())) &&
                        this.compareAmenities(apartment.facilities,searchFacilities)){
                            
                            if(!this.apartments.includes(apartment)){
                                this.apartments.push(apartment);
                                // console.log(this.apartments);
                                this.search = ""
                                this.searchFacilities = [];
                                
                            }

                        console.log(this.apartments)

                        this.apartments.forEach((element) =>{
                            var marker ;
                            marker = new tt.Marker()
                            .setLngLat([element.long, element.lat])
                            .addTo(this.map);
                        })
                    
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
                center: [12.564874, 42.000000 ],
                zoom: 2,
            });
            this.map.addControl(new tt.FullscreenControl());
            this.map.addControl(new tt.NavigationControl());

            this.apartments.forEach((element) =>{
               
            
            })
                

        
        
        },
        
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
<template>
    <div class="container">
        <div id="map" class="map"></div>

        <section id="apartment-list">
            <h1 class="text-center">Appartamenti</h1>
                <div class="left-searchbar ">
                    <input id="contacts-filter" class="form-control" type="text"
                    placeholder="Cerca per città o indirizzo" name="search" v-model="search" >

                    <h3>Cerca per servizi</h3>
                    <div class="d-flex justify-content-center flex-wrap">
                        <div v-for="facility in facilities" :key="facility.id" class="custom-control-inline custom-checkbox">
                            <input class="custom-control-input" type="checkbox" :id="'facility-'+facility.id" v-model="searchFacilities" name="searchFacilities[]" :value="facility.id">
                            <label class="custom-control-label" :for="'facility-'+ facility.id + ''">{{facility.name}}</label>
                        </div>
                        
                    </div>
                    <button @click="searchApartment(search,searchFacilities); " class="btn btn-primary">Cerca</button>
                </div>
                <div class="row">
                    <Apartment v-for="apartment in searchedApartment " :key="apartment.id" :apartment="apartment"/>
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
                searchedApartment:[],
                nearestApartments:[],
                my_lat:42.564525,
                my_long:12.03356,

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

           compareFacilities(arr1, arr2) {
                    let apartmentsFacilitiesId = [];
                    arr1.forEach((facility) => {
                    apartmentsFacilitiesId.push(facility.id)
                    
                    });
                    const filteredArray = arr2.filter(value => apartmentsFacilitiesId.includes(value));
                    if (filteredArray.length == arr2.length) {
                        return true;
                    }  else {
                        return false
                    }
                },


            

            deg2rad(deg) {
                return deg * (Math.PI/180)
                },


            getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
                var R = 6371; // Radius of the earth in km
                var dLat = this.deg2rad(lat2-lat1);  // deg2rad below
                var dLon = this.deg2rad(lon2-lon1); 
                var a = 
                    Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) * 
                    Math.sin(dLon/2) * Math.sin(dLon/2)
                    ; 
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                var d = R * c; // Distance in km
                return d;
                },

                newMarker(){
                console.log('new marker in console')
                this.searchedApartment.forEach((element) =>{

                    if(this.getDistanceFromLatLonInKm(this.my_lat,this.my_long,element.lat,element.long) <20){
                        
                        var marker ;
                        marker = new tt.Marker()

                    .setLngLat([element.long, element.lat])
                    .addTo(this.map);
                    }
                    
                    
                    })

                

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
                    this.searchedApartment=[];
                    response.data.apartments.forEach(apartment => {
                        if((apartment.city.toLowerCase().includes(search.toLowerCase()) || 
                        apartment.address.toLowerCase().includes(search.toLowerCase())) &&
                        this.compareFacilities(apartment.facilities,searchFacilities)){
                            
                            if(!this.searchedApartment.includes(apartment)){
                                this.searchedApartment.push(apartment);
                                this.search = ""
                                this.searchFacilities = [];

                            }

                            this.my_lat='';
                            this.my_long='';
                            this.my_long = this.searchedApartment[0].long;
                            this.my_lat = this.searchedApartment[0].lat;
                            

                            
                            this.map = tt.map({
                                key: "CskONgb89uswo1PwlNDOtG4txMKrp1yQ",
                                container:'map',
                                center: [this.my_long, this.my_lat ],
                                zoom: 12,
                            });
                            this.map.addControl(new tt.FullscreenControl());
                            this.map.addControl(new tt.NavigationControl());

                            
                            this.newMarker()

                            console.log(this.apartments)

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
                center: [this.my_long, this.my_lat ],
                zoom: 2,
            });
            this.map.addControl(new tt.FullscreenControl());
            this.map.addControl(new tt.NavigationControl());
                

        
        
        },
        
    }

</script>

<style scoped>
    .notVisible {
        display: none;
    }
    .map{
        width: 100%;
        height: 40vh;
    }
</style>

<style lang="scss">
    @import '../../../sass/_index.scss'
</style>
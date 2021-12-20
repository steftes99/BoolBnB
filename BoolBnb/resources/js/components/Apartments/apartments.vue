<template>
    <div class="container">
        <div class="row">
            <div class="col-12 my-5">
                <section id="apartment-list">
                <div class="left-searchbar ">
                    <input id="contacts-filter" class="form-control" type="text"
                    placeholder="Cerca per indirizzo" name="search" v-model="search" >

                    <h3 class="my-3">Servizi:</h3>
                    <div class="d-flex justify-content-center flex-wrap">
                        <div v-for="facility in facilities" :key="facility.id" class="custom-control-inline custom-checkbox">
                            <input class="custom-control-input" type="checkbox" :id="'facility-'+facility.id" v-model="searchFacilities" name="searchFacilities[]" :value="facility.id">
                            <label class="custom-control-label" :for="'facility-'+ facility.id + ''">{{facility.name}}</label>
                        </div>
                        
                    </div>
                    <div class="d-flex mt-3 justify-content-center align-items-center">
                        <button @click="searchApartment(search,searchFacilities); showMap() " class="btn btn-primary _btn-color">Cerca</button>
                    </div>
                    
                    <h3 class="mt-3">Appartamenti nelle vicinanze dell'indirizzo cercato:</h3>
                </div>

            
    
        </section>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-12 _scroll">
                        <Apartment v-for="apartment in searchedApartment " :key="apartment.id" :apartment="apartment"/>
                    </div>
                </div>
                
            </div>
            <div class="col-6 p-1">
                <div id="map" class="map"></div>
            </div>
        </div>
        

        
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
                my_lat:41.89056,
                my_long:12.49427,
                list:[],

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
                

                createMarker() {
                    this.apartments.forEach((element) =>{

                        if(this.getDistanceFromLatLonInKm(this.my_lat,this.my_long,element.lat,element.long) <20  && 
                         this.compareFacilities(element.facilities,this.searchFacilities) == true ){
            var markerElement = document.createElement('div');
            markerElement.className = 'marker';

            var markerContentElement = document.createElement('div');
            markerContentElement.className = 'marker-content';
            markerContentElement.style.backgroundColor = '#e7717d';
            markerElement.appendChild(markerContentElement);

            var iconElement = document.createElement('div');
            iconElement.className = 'marker-icon';
            iconElement.style.backgroundImage =
                'url(https://www.downloadclipart.net/large/60667-small-house-clipart.png)';
            markerContentElement.appendChild(iconElement);

            var popup = new tt.Popup({offset: 30})
            .setText(
                element.title + ' ' + element.address);
            // add marker to map
            new tt.Marker({element: markerElement, anchor: 'bottom'})
                .setLngLat([element.long, element.lat])
                .setPopup(popup)
                .addTo(this.map);

                         }})
        },

                newMarker(){
                    this.apartments.forEach((element) =>{

                        if(this.getDistanceFromLatLonInKm(this.my_lat,this.my_long,element.lat,element.long) <20  && 
                         this.compareFacilities(element.facilities,this.searchFacilities) == true ){

                            
                            var marker ;
                            marker = new tt.Marker()
                            .setLngLat([element.long, element.lat])
                            .addTo(this.map)
                            var popupOffsets = {
                                top: [0, 0],
                                bottom: [0, -70],
                                'bottom-right': [0, -70],
                                'bottom-left': [0, -70],
                                left: [25, -35],
                                right: [-25, -35]
                                }

                            var popup = new tt.Popup({offset: popupOffsets })
                            .setHTML(element.address)
                            marker.setPopup(popup).togglePopup();
                        }                                       
                    })                
                },

            showMap(){  
                let indirizzo = 'roma-' + this.search.split(' ').join('-');
                let ricercaIndirizzo = 'https://api.tomtom.com/search/2/geocode/'+ indirizzo + '.JSON?key=CskONgb89uswo1PwlNDOtG4txMKrp1yQ';
                $.getJSON(ricercaIndirizzo,function(task){
                          this.list = task;
                          console.log(this.list.results)
                          var addressLat = this.list.results[0].position.lat;
                          var addressLong = this.list.results[0].position.lon;
                          this.my_lat = addressLat;
                          this.my_long = addressLong;

                           this.map = tt.map({
                                key: "CskONgb89uswo1PwlNDOtG4txMKrp1yQ",
                                container:'map',
                                center: [this.my_long, this.my_lat ],
                                zoom: 13,
                            });
                            this.map.addControl(new tt.FullscreenControl());
                            this.map.addControl(new tt.NavigationControl());

                            this.createMarker();
                            /* this.newMarker() */

                        }.bind(this));
            }, 

            searchApartment(search,searchFacilities){
                axios.get("http://127.0.0.1:8000/api/api/apartments", {
                    params: {
                        query: search,
                        array: searchFacilities,
                    }
                })
                .then( (response) => {
                    this.searchedApartment=[];
                    response.data.apartments.forEach(apartment => {
                        if(this.getDistanceFromLatLonInKm(this.my_lat,this.my_long,apartment.lat,apartment.long) < 20 && 
                         this.compareFacilities(apartment.facilities,searchFacilities) == true ){
                            
                            if(!this.searchedApartment.includes(apartment)){
                                this.searchedApartment.push(apartment);
                                this.search = ""
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
                center: [this.my_long, this.my_lat ],
                zoom: 10,
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
        height: 60vh;
    }
</style>

<style lang="scss">
    @import '../../../sass/_index.scss'
</style>
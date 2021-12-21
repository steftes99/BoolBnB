<template>
    <div class="row bg-white mb-2 p-2 _border-apartment rounded-lg">
        <div class="col-12 col-md-4 p-md-2">
            <img class="img-fluid" :src=" apartment.image.startsWith('apartments/images') ? 'http://127.0.0.1:8000/storage/'+ apartment.image : apartment.image " 
        alt="Ciao"> 
        </div>
        <div class="col-md-8 col-12 wrapper_h">
            <h4 class="text-capitalize py-2">{{ apartment.title }}</h4> 
            <p class=""> <strong>Città: </strong> {{ apartment.city }}</p>
            <p class=""><strong>Regione: </strong>{{ apartment.region }}</p>
            <span v-for="facility in apartment.facilities" :key="facility.id" class="mr-1 text-capitalize">{{ facility.name }}</span>
            <div>
                <a :href="'http://127.0.0.1:8000/guest/apartments/' + apartment.id" class="btn btn-primary _btn-color my-3">Maggiori informazioni</a>
            </div>
            
        </div>
    

    </div>
</template>
<script>

    export default {
        name: 'Apartment',
        
        props : ['apartment'],

        mounted() {
            
        }
    }
</script>

<style lang="scss">
    @import '../../../sass/_apartment.scss'
</style>
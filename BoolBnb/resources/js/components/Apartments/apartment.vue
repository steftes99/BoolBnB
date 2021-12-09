<template>
    <div class="card col-3 m-3" style="width: 18rem;">
        <h5 class="card-title">{{ apartment.title }}</h5> 
        <img :src=" apartment.image.startsWith('apartments/images') ? 'http://127.0.0.1:8000/storage/'+ apartment.image : apartment.image " 
        alt="Ciao">                   
        <div class="card-body">
            
            <p class="card-text"> <strong>Città:</strong> {{ apartment.city }}</p>
            <p class="card-text"><strong>Regione:</strong>{{ apartment.region }}</p>
            <a :href="'http://127.0.0.1:8000/guest/apartments/' + apartment.id" class="btn btn-primary">Maggiori informazioni</a>
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
<template>
    <div class="card col-3 m-3" style="width: 18rem;">
            
        <img :src= "apartment.image" alt="">                   
        <div class="card-body">
            <h5 class="card-title">{{ apartment.title }}</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="" class="btn btn-primary">Go somewhere</a>
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
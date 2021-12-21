<template>
    <div class="col-12 text-center col-md-4 col-lg-2 py-2">
        <button class="btn btn-secondary _gray" @click="$emit('token',sponsorship.id),$emit('price',sponsorship.price),$emit('duration',sponsorship.hour_duration)"> {{sponsorship.hour_duration}} ore, {{sponsorship.price}} &euro;</button>   
    </div>  
</template>

<script>
export default {
    name:'sponsorshipCard',
    props:['sponsorship'],
    data(){
        return{

        }
    },
    methods:{

    },
}
</script>

<style lang="scss">
    @import '../../../sass/_variables.scss';
    @import '../../../sass/_show.scss';

</style>
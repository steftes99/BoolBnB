<template>
    <div class="col-12 col-md-4 col-lg-2">
        <button class="btn btn-secondary" @click="$emit('token',sponsorship.id)">sponsorizza per {{sponsorship.hour_duration}} ore al costo di {{sponsorship.price}} &euro;</button>   
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

    }
}
</script>

<style>

</style>
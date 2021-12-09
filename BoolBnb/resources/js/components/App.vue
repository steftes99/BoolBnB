<template>
    <div class="container">
        <Apartments />
    </div>
</template>

<script>
    import Apartments from "./Apartments/apartments.vue";

    export default {
        name: 'App',
        data() {
            return {

            }
        },
        components : {
            Apartments,
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

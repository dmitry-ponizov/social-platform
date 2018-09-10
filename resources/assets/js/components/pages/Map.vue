<template>
    <div>
        <div id="map"></div>
    </div>
</template>


<script>
    import {loadedGoogleMapsAPI} from './../../google_maps'

    export default {
        data() {
            return {
            };
        },
        props: {
            lat: {
                default: 49.9935,
                type: Number
            },
            lng:{
                default: 36.230383,
                type: Number
            }
        },
        mounted() {
            loadedGoogleMapsAPI.then(() => {
                this.initMap()
            });
        },
        methods: {
            initMap() {
                let uluru = {lat:this.lat , lng:this.lng };
                let map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 7,
                    center: uluru
                });
                let marker = new google.maps.Marker({
                    position: uluru,
                    map: map
                });
            }


        }
    };
</script>


<style >
    #map{
        /*width: 500px;*/
        height: 320px;
    }
</style>
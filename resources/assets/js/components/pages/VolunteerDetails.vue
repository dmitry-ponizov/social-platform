<template>
    <section>
        <slot v-if="lang.volunteers">
            <div class="organization parallax">
                <div class="organization-wrapper">
                    <h1>{{ lang.volunteers.volunteers_information }}</h1>
                </div>
            </div>
            <div class="ui centered grid">
                <div id="volunteer_details_wrap" class="ten wide computer sixteen wide mobile ten tablet column">
                    <div class="ui centered grid">
                        <div class="six wide column">
                            <div class="image_block">
                                <img :src="volunteer.avatar" alt="">
                            </div>
                        </div>
                        <div class="ten wide column">
                            <div class="description_block">
                                <h2 v-if="volunteer.surname && volunteer.name ">{{ volunteer.surname }} {{ volunteer.name }}</h2>
                                <h3 v-if="volunteer.organization">{{ volunteer.organization.name }}</h3>
                                <p v-if="volunteer.profiles_data.about_me ">{{ volunteer.profiles_data.about_me }}</p>
                                <ul>
                                    <li v-if="volunteer.profiles_data.facebook">
                                        <a :href="volunteer.profiles_data.facebook">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li v-if="volunteer.profiles_data.twitter">
                                        <a :href="volunteer.profiles_data.twitter">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li v-if="volunteer.profiles_data.skype">
                                        <a :href="volunteer.profiles_data.skype">
                                            <i class="fa fa-skype"></i>
                                        </a>
                                    </li>
                                    <li v-if="volunteer.profiles_data.google">
                                        <a :href="volunteer.profiles_data.google">
                                            <i class="fa fa-google-plus"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="ui centered grid about_block">
                        <div class="six wide column">
                            <h3>{{ lang.volunteers.about_me }}</h3>
                            <ul>
                                <li>
                                    <div class="contact_block" v-if="volunteer.profiles_data.city">
                                        <div>
                                            <i class="fa fa-map-marker"></i>
                                        </div>
                                        <div>
                                            <h5>{{ lang.volunteers.address }}:</h5>
                                            <p>{{ volunteer.profiles_data.region }} , {{ volunteer.profiles_data.city }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact_block">
                                        <i class="fa fa-phone"></i>
                                        <div>
                                            <h5>{{ lang.volunteers.contacts }}:</h5>
                                            <p v-if="volunteer.phone">{{ lang.volunteers.phone }}: {{ volunteer.phone }} </p>
                                            <p v-if="volunteer.profiles_data.email ">{{ lang.volunteers.email }}: {{ volunteer.profiles_data.email }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact_block rate_container">
                                        <div>
                                            <i class="fa fa-smile-o" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                            <h5>{{ lang.volunteers.rate }}:</h5>
                                            <div>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="five wide column">
                            <h3>{{ lang.volunteers.location }}</h3>
                            <Map :lat="lat" :lng="lng"></Map>
                        </div>
                        <div class="five wide column">
                            <h3>{{ lang.volunteers.reviews }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </slot>

    </section>
</template>

<script>

    import Map from './Map'

    export default {
        data() {
            return {
                lat: 0,
                lng: 0
            }
        },

        mounted() {
            axios.get('https://maps.googleapis.com/maps/api/geocode/json?address=' + this.volunteer.profiles_data.region + '+' + this.volunteer.profiles_data.city + '&key=AIzaSyDNLg-aR7ZONs41mb9DuBWRIG_ZiTd9SBo')
                .then(({results}) => {
                    console.log(results);
                    this.lat = data.results[0].geometry.location.lat;
                    this.lng = data.results[0].geometry.location.lng;
                })

        },
        components: {Map},
        props: ['volunteer', 'locale'],
        computed: {
            lang() {
                return this.$store.getters.lang
            },
        },


    }
</script>



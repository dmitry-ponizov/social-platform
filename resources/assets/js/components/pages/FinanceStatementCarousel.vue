<template>
    <div class="finance_slider_wrapper" v-if="settings.active === 'true'">
        <slick ref="slick" :options="slickOptions">
            <div v-for="(statement,index) in statementsDisplay" :key="index" class="item_wrap">
                <div class="item" :style="'min-height:'+ statement.height">
                    <div class="statement">
                        <div class="image" v-if="statement.image">
                            <img :src="statement.image" alt="">
                            <div class="hover-link">
                                <a :href="statement.uuid | donateLink">
                                    <span>{{settings.link_title}}</span>
                                </a>
                            </div>
                        </div>
                        <div class="details" :class="{full_height:!statement.image}" :style="getItemStyle(statement.image)">
                            <h4>
                                <a :href="statement.uuid | link">{{statement.title |short(35)}}</a>
                            </h4>
                            <div class="desc">{{statement.description | short(100) }}</div>
                            <div class="donate">
                                <a class="donate_btn" :href="statement.uuid | donateLink">
                                    <span>{{settings.link_title}}</span>
                                </a>
                            </div>
                            <ul>
                                <li class="target">
                                    <strong>{{settings.title_1 }}</strong>
                                    <div class="green">{{statement.sum | sum }}</div>
                                </li>
                                <li class="current">
                                    <strong class="red">{{settings.title_2 }}</strong>
                                    <div class="red">{{statement.raised | sum}}</div>
                                </li>
                                <li class="remaining_days">
                                    <strong>{{ settings.title_3 }}</strong>
                                    <div>{{ ago(statement.created_at) }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </slick>
    </div>
</template>

<script>
    import 'slick-carousel/slick/slick.css';
    import Slick from 'vue-slick';
    import moment from 'moment';
    export default {
        components: { Slick },

        data() {
            return {
                slickOptions: {
                    slidesToShow: this.settings.count_slides,
                    slidesToScroll: 1,
                    autoplay: false,
                    autoplaySpeed: 2000,
                    infinite: true,
                    dots: true,
                    arrows: false,
                    adaptiveHeight: true,
                    adaptiveWidth: true
                },
                minHeight:'auto',
            };
        },
        props:['statements','language','settings','locale'],

        computed:{
            statementsDisplay() {
                let statments = this.statements;
                for (let ind in statments) {
                    statments[ind].height = this.minHeight;
                }

                return statments;
            }
        },
        created(){
            if(screen.width <= 620){
                this.slickOptions.slidesToShow = 1;
                this.slickOptions.autoplay = false;
            }else if(screen.width >= 621 && screen.width <= 1378){
                this.slickOptions.slidesToShow = 2;
                this.slickOptions.autoplay = false;
            }

        },
        // All slick methods can be used too, example here
        methods: {

            getItemStyle(state) {
                if (state) {
                    return {};
                }
                return {
                    minHeight:this.minHeight
                }
            },
            next() {
                this.$refs.slick.next();
            },

            prev() {
                this.$refs.slick.prev();
            },

            reInit() {
                // Helpful if you have to deal with v-for to update dynamic lists
                this.$nextTick(() => {
                    this.$refs.slick.reSlick();
                });
            },
            ago(value) {
                let locale = this.locale;
                locale = (locale == 'ua') ? 'uk' : locale;
                moment.locale(locale);
                let dateFormat = moment(new Date(value)).format();
                return moment(dateFormat).startOf('day').fromNow();
            },
        },
        filters: {
            short: function (value,size) {
                if(value.length > size){
                   var str =  value.slice(0, size);

                    var a = str.split(' ');
                    a.splice(a.length-1,1);
                    str = a.join(' ');
                    return str+' ...';
                }

                return value;
            },
            short_letter(value,size){
                if(value.length > size){
                    var str =  value.slice(0, size);
                    return str+'.';
                }

                return value;
            },
            sum(value){
                if(value === null){
                    return 0 + ' UAH'
                }else{
                    return value + ' UAH'
                }
            },

            donateLink(value){
                return '/donate/' + value;
            },
            link(value){
                return '/statement/' + value;
            }
        }
    }
</script>
<template>
    <div class="donate_slider_wrapper">
        <h3>{{language.need}}</h3>
        <slick ref="slick" :options="slickOptions">
            <div v-for="(statement,index) in statements" :key="index" class="item_wrap">
                <div class="item" :class="{min_height: !statement.image}">
                    <slot v-if="statement.image">
                        <div class="img-block">
                            <img :src="statement.image" alt="">
                        </div>
                    </slot>
                    <h4>{{statement.title | short(40)}}</h4>
                    <p>{{statement.description | short(140)}}</p>
                    <div class="read_container">
                        <a :href="statement.uuid | link" class="btn_read">{{language.more}}</a>
                    </div>
                    <ul>
                        <li class="target">
                            <strong>{{language.raised | short_letter(5)}}</strong>
                            <div class="green">{{statement.sum | sum }}</div>
                        </li>
                        <li class="current">
                            <strong class="red">{{language.goal}}</strong>
                            <div class="red">{{statement.raised | sum}}</div>
                        </li>

                        <li class="remaining_days">
                            <strong>{{language.duration | short_letter(6)}}</strong>
                            <div>{{ ago(statement.created_at) }}</div>
                        </li>
                    </ul>

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

        components: {Slick},
        created(){
            if(screen.width <= 520 || (screen.width >= 621 && screen.width <= 768)) {
                this.slickOptions.slidesToShow = 1;

            }else{
                this.slickOptions.slidesToShow = 2;
            }
        },
        data() {
            return {
                slickOptions: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    infinite: true,
                    dots: false,
                    arrows: false,

                },
            };
        },
        props: ['statements', 'language','locale'],
        computed: {},
        // All slick methods can be used too, example here
        methods: {
            ago(value) {

                let locale = this.locale;
                locale = (locale == 'ua') ? 'uk' : locale;
                moment.locale(locale);
                let dateFormat = moment(new Date(value)).format();
                return moment(dateFormat).startOf('day').fromNow();
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


        },
        filters: {
            short: function (value,size) {
                if (value.length > size) {
                    var str = value.slice(0, size);

                    var a = str.split(' ');
                    a.splice(a.length - 1, 1);
                    str = a.join(' ');
                    return str + ' ...';
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
            sum(value) {
                if (value === null) {
                    return 0 + ' UAH'
                } else {
                    return value + ' UAH'
                }
            },
            date(value) {

                var day = value / 86400;

                return Math.ceil(day) + " дн.";

            },
            link(value) {
                return '/statement/' + value;
            },

        }
    }
</script>
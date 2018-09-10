<template>
    <div class="slider">
        <slick ref="slick" :options="slickOptions">
            <div v-for="(statement,index) in statements" :key="index" class="statement">
                <div class="blocks">
                    <div class="left_block" :class="{no_width:!statement.image}">
                        <img :src="statement.image" alt="">
                    </div>
                    <div class="right_block"  :class="{full_width:!statement.image}">
                        <div class="right_block-container">
                            <h4>
                                <a :href="statement.uuid | link">{{ statement.title }}</a>
                            </h4>
                            <p>
                               {{ statement.description | short(60) }}
                            </p>
                            <div class="sum_block" >
                                <ul>
                                    <li>
                                        <span>{{ lang.volunteers.need }}:</span>
                                        <span> {{ statement.sum | sum }}  </span>
                                    </li>
                                    <li>
                                        <span>{{ lang.volunteers.raised }}:</span>
                                        <span> {{ statement.raised | sum }}  </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="buttons_block" :class="{margin:!statement.image}">
                                <a :href="statement.uuid | link">{{ lang.volunteers.view }}</a>
                                <a :href="statement.uuid | donateLink" >{{ lang.volunteers.donate }}</a>
                            </div>
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

    export default {
        props: ['statements','lang'],
        components: {Slick},
        data() {
            return {
                slickOptions: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    autoplay: false,
                    autoplaySpeed: 2000,
                    infinite: true,
                    arrows: true,
                    nextArrow: '<div class="right"><i class="fa fa-angle-right"></i></div>',
                    prevArrow: '<div class="left"><i class="fa fa-angle-left"></i></div>',
                    vertical: true,
                },
            };
        },
        filters:{
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



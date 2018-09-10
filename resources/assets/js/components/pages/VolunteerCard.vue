<template>
    <div class="volunteer five wide computer six wide tablet ten wide mobile column">
        <a :href="'/volunteer/'+ volunteer.uuid">
            <div class="block">
                <div class="upper-block">
                    <div class="image_block">
                        <img :src="volunteer.avatar" alt="">
                    </div>
                    <h4>
                        {{ volunteer.user }}
                    </h4>
                </div>
                <div class="lower-block">
                    <slot v-if="volunteer.about_me">
                        <p>{{ volunteer.about_me | short(140)}}</p>
                    </slot>
                    <ul>
                        <slot v-if="volunteer.facebook">
                            <li>
                                <a :href="volunteer.facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                        </slot>
                        <slot v-if="volunteer.twitter">
                            <li>
                                <a :href="volunteer.twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                        </slot>
                        <slot v-if="volunteer.skype">
                            <li>
                                <a :href="volunteer.skype">
                                    <i class="fa fa-skype"></i>
                                </a>
                            </li>
                        </slot>
                        <slot v-if="volunteer.google">
                            <li>
                                <a :href="volunteer.google">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                        </slot>
                    </ul>
                </div>

            </div>
        </a>
    </div>
</template>


<script>

    export default {

        props: ['volunteer'],
        data() {
            return {
                fullWidth: true
            }
        },
        filters: {
            short: function (value, size) {
                if (value.length > size) {
                    var str = value.slice(0, size);

                    var a = str.split(' ');
                    a.splice(a.length - 1, 1);
                    str = a.join(' ');
                    return str + ' ...';
                }

                return value;
            },
        }

    }
</script>


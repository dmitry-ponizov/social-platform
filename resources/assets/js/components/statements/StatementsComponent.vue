<template>
    <div>
        <div v-for="statement in statements" class="statement">
            <div class="image_container" v-if="statement.images.length">
                <div>
                    <img :src="image(statement.images)" alt="">
                </div>
            </div>
            <div class="statement_desc" :class="{flex_grow_2 : !statement.images.length}">
                <h4> {{statement.title}}</h4>
                <p>{{statement.description | short }}</p>
                <div class="btn_container">
                    <a class="more_button" :href="statement.uuid | more ">
                        {{lang.details}}
                        <i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
            </div>
            <div class="details">
                <ul>
                    <li>
                        <strong>{{lang.name}}:</strong>
                        {{statement.user.surname}} {{statement.user.name}}
                    </li>
                    <li>
                        <strong>{{lang.location}}:</strong>
                        {{statement.region}}
                    </li>
                    <li>
                        <strong>{{lang.category}}:</strong>
                        {{statement.category_title}}
                    </li>
                    <li>
                        <strong>{{lang.created}}:</strong>
                        {{statement.date}}
                    </li>
                    <slot v-if="statement.sum">
                        <li class="green bold need_sum">
                            <strong>{{lang.need_sum}}:</strong>
                            {{statement.sum | sum}}
                        </li>
                        <li class="red bold need_sum">
                            <strong>{{lang.raised}}:</strong>
                            {{statement.raised | sum }}
                        </li>

                    </slot>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['statements', 'lang'],
        methods: {
            image(images) {
                for (var image of images) {
                    if (image.main) {
                        return '/uploads/statements/medium/' + image.name;
                    }
                }
            }
        },
        filters: {
            short: function (value) {
                var size = 140;

                if (value.length > size) {
                    var str = value.slice(0, size);

                    var a = str.split(' ');
                    a.splice(a.length - 1, 1);
                    str = a.join(' ');
                    return str + ' ...';
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
            more(stat) {
                return '/statement/' + stat;
            }
        }
    }
</script>


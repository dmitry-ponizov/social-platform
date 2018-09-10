<template>
    <div>
        <star-rating
                ref="rating"
                :uuid="uuid"
                :errors="errors"
                :editable="newEditable"
                :rate="rate">
        </star-rating>

        <div v-if="newEditable">
            <text-editor
                    :errors="errors"
                    v-model="newComment">
            </text-editor>
        </div>
        <div v-else class="description">
            <label for="">{{lang.statement.review}}:</label>
            <div class="comment" v-html="newComment"></div>
        </div>

        <div class="statement_create">
            <a href="" @click.prevent="cancel">{{ lang.statement.cancel }}</a>
            <button @click="onSubmit" v-if="editable" class="btn">
                {{lang.statement.save}}
            </button>
        </div>
    </div>
</template>

<script>
    import TextEditor from './TextEditor';
    import StarRating from './StarRating';

    export default {
        props: ['uuid', 'rate', 'comment','editable'],
        data() {
            return {
                newComment: this.comment,
                newEditable:this.editable,
                errors:[]
            }
        },
        components: {TextEditor, StarRating},
        computed: {
            lang() {
                return this.$store.getters.lang
            }
        },
        methods: {
            onSubmit() {
                axios.post('/statement/review', {
                    rate: this.$refs.rating.newRate,
                    uuid: this.uuid,
                    comment: this.newComment
                }).then(({data}) => {
                    this.getNoty('success', this.lang.messages.saved);
                    this.newEditable = false;
                    this.$store.commit('add_statements',data);
                    this.errors = [];
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })

            },
            cancel() {
                this.$parent.commentActive = false;
            }
        }
    }
</script>


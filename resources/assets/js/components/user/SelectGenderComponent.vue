<template>
    <div class="fixed_height">
        <slot v-if="currentState">
            <div class="info_block info_block-select">
                <select class="ui fluid dropdown" required v-model="newValue">
                    <option value="male" class="item"
                            v-for="(gender, index) in lang['gender']"
                            :key="index"
                            :value="index"
                    >
                        {{ lang['gender'][index] }}
                    </option>
                </select>
                <div class="active_elements">
                    <div v-if="active" class="save_user_info">
                        <i class="fa fa-floppy-o" aria-hidden="true" @click="save"></i>
                    </div>
                    <div @click="close" class="close_user_field">
                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </slot>
        <slot v-if="!currentState">
            <div class="info_block">
                <div>{{ lang['gender'][newValue] }}</div>
                <div @click="currentState = true" class="edit_user_info">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </div>
            </div>
        </slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                newValue: this.getUserData(),
                currentState: false,
                active: false
            }
        },

        props: ['data'],
        methods: {
            save() {
                this.$parent.saveField(this.data.rule_id, this.data.sub_id, this.newValue, this.changedAt);
                this.currentState = false;
                this.active = false
            },
            close() {
                this.currentState = false;
                this.active = false;
                this.newValue = this.getUserData();
            },
            getUserData() {
                return !!this.data.user_data ? this.data.user_data.value : 'not_specified';
            },
        },

        watch: {
            newValue() {
                this.active = true;
                this.$store.commit('change_save_btn', true);
                this.$parent.changeField(this.data.rule_id, this.data.sub_id, this.newValue, this.changedAt);

            },
            'data.user_data.value'(val){
                this.active = false;
                this.currentState = false;

            }
        },
        computed: {
            lang() {
                let lang = this.$store.getters.lang;
                if (lang) {
                    return lang;
                }
            }
        },

    }
</script>


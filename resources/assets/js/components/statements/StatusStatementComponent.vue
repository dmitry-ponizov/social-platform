    <template>
    <div class="edit_container fixed_height">
        <label>{{lang.status}}</label>
        <slot v-if="currentState">
            <div class="info_block">
                <div class="info_block-select">
                    <select v-model="status" class="ui fluid dropdown" @change="watch">
                        <option :value="key" v-for="(status,key) in lang.statuses">{{status}}</option>
                    </select>
                </div>
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
        <slot v-else>
            <div class="info_block">
                <div class="desc">{{lang.statuses[status]}}</div>
                <slot v-if="data !== 'closed' && type != 'destitute'">
                    <div @click="currentState = true" class="edit_user_info">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </div>
                </slot>
            </div>
        </slot>
    </div>
</template>

<script>
    export default {
        props: ['data','field','lang','errors','type'],
        data() {
            return {
                currentState: false,
                active: false,
                status:'',
            }
        },
        beforeMount () {
            this.status = this.data;
        },
        methods: {
            close() {
                this.status = this.data;
                this.currentState = false;
                this.active = false;
            },
            save() {
                this.$parent.saveField(this.field,this.status,'/statement/update-status');
                this.currentState = false;
                this.active = false;
            },
            watch(event){
                if(event.target.value!=this.data){
                    this.active = true;
                }else{
                    this.active = false;
                }

            }
        },

    }
</script>


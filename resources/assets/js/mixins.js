import Vue from 'vue';
Vue.mixin({
    methods: {
        getNoty(status, message) {
            return new Noty({
                layout: 'bottomRight',
                type: status,
                theme: 'metroui',
                timeout: 2000,
                text: message,
                progressBar: false,
            }).show();
        },
        limitSum(evt) {
            if (evt.target.value.length >= 9) {
                if (evt.keyCode >= 48 && evt.keyCode <= 90) {
                    evt.preventDefault();
                    return
                }
            }
        },

    }
});

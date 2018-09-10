<template>
    <div id="recaptcha" class="g-recaptcha" ></div>
</template>

<script>
    export default {
        data () {
            return {
               token:''
            }
        },
        methods: {
            initReCaptcha: function() {
                var self = this;
                setTimeout(function() {
                        window.addEventListener('load', () => {
                    if(typeof grecaptcha === 'undefined') {
                        self.initReCaptcha();

                    }
                    else {
                        grecaptcha.render('recaptcha', {
                            sitekey: '6LfKJ1YUAAAAACCeXmFqoyPVrrFVfx9Gs654xaEk',
                            size: 'visible',
                            badge: 'inline',
                            callback: self.submit
                        });
                        //
                    }
                }, 100);
                })
            },
            validate: function() {
                grecaptcha.execute();
            },
            submit: function(token) {
                grecaptcha.reset()
                this.$parent.token = token;
            },
        },
        mounted: function() {
            this.initReCaptcha();
        },
    }
</script>
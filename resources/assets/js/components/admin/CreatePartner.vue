<template>
    <div class="col-md-6">
        <div class="card mt-3">
            <div class="card-body">
                <form action="" enctype="multipart/form-data" class="createPartnerForm" v-if="!success" @submit.prevent="onSubmit">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="name">{{ lang.name }}</label>
                        <div class="col-sm-8">
                            <input id="name" name="name" v-model="name" class="form-control" />
                            <slot v-if="errors && errors.errors && errors.errors.name">
                                <small class="text-danger" v-for="error in errors.errors.name">
                                    {{ error }}
                                </small>
                            </slot>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="name">{{ lang.url }}</label>
                        <div class="col-sm-8">
                            <input id="url" name="url" v-model="url" class="form-control" />
                            <slot v-if="errors && errors.errors && errors.errors.url">
                                <small class="text-danger" v-for="error in errors.errors.url">
                                    {{ error }}
                                </small>
                            </slot>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{lang.photo }}:</label>
                        <div class="col-sm-8">
                                <img class="preview-circle" v-if="file" :src="file" style="width:120px; height: 100px; margin: 20px 0">
                                <input @change="onChange"  name="photo" accept=".jpg, .jpeg, .png,.gif"  type="file">
                            <div v-if="errors && errors.errors && errors.errors.photo">
                                <small class="text-danger" v-for="error in errors.errors.photo">
                                    {{ error }}
                                </small>
                            </div>
                            <p>
                                <small>{{lang.messages.types_files}} .jpg, .jpeg, .png,.gif </small>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="about">{{ lang.short_desc }}</label>
                        <div class="col-sm-8">
                            <textarea id="about" cols="30" rows="6" name="about" type="text" :maxlength="max"
                                      v-model="about" class="form-control"></textarea>
                            <slot v-if="errors && errors.errors && errors.errors.about">
                                <small class="text-danger" v-for="error in errors.errors.about">
                                    {{ error }}
                                </small>
                            </slot>
                            <p class="d-flex justify-content-end">
                                <small>{{lang.messages.characters_limit }}:</small>
                                <small v-text="(max - about.length)"></small>
                            </p>
                        </div>
                    </div>
                    <div class="back_block d-flex justify-content-end mt-2">
                        <p class="mr-3">
                            <a href="" class="btn btn-primary btn-sm" @click.prevent="$router.go(-1)">{{lang.messages.back}}</a>
                        </p>
                        <p>
                            <a href="#" @click.prevent="onSubmit" class="btn btn-success btn-sm">
                                {{lang.messages.save}}
                            </a>
                        </p>
                    </div>
                </form>
                <div class="user_fields" v-if="success">
                    <div class="alert alert-success" role="alert">
                        <h5 class="alert-heading">
                            {{lang.messages.success}}!
                        </h5>
                        <hr>
                        <p>
                            <a href="/admin/partners" class="alert-link">Перейти к списку партнеров</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		props: ['lang'],
		data() {
			return {
				about: '',
				max: 255,
				name: '',
				url: '',
				success: false,
				errors:[],
				file: false,

            }
        },
		methods: {
			onSubmit(){
				let myForm = document.getElementsByClassName('createPartnerForm');

				let formData = new FormData(myForm[0]);
                if(this.name && this.url && this.file && this.about){
	                axios.post('/admin/partners', formData, {headers: {'Content-Type': 'multipart/form-data'}})
		                .then(response => {
			                if (response.status === 200) {
				                this.success = true;
				                this.getNoty('success', this.lang.messages.success);
			                }
		                }).catch(error => {
		                if (error.response.status === 422) {
			                this.errors = error.response.data;
		                } else {
			                this.getNoty('error', error.response.data.message);
                        }
	                })
                } else {
                	this.getNoty('error', 'Необходимо заполнить все поля!')
                }

            },
			onChange(event){
				this.file = '';

				let input = event.target;

				if (input.files && input.files[0]) {

					self = this;

					let reader = new FileReader();

					reader.onload = function (e) {
						self.file = reader.result;
					};
					reader.readAsDataURL(input.files[0]);


				}

            }
        }
    }
</script>


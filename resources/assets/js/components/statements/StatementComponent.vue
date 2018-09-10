<template>
	<div class="statement_item" :class="{full_height:!statement.image}">
		<a :href="link">
			<div class="img_block" v-if="statement.image[0]">
				<img class="statement_img" :src="'/uploads/statements/small/'+ statement.image[0]['name']"  alt="">
			</div>
			<div class="statement_details" v-if="statement.image">
				<p>{{statement.description | short(60)}}</p>
				<h3>{{statement.title | short(20)}}</h3>
			</div>
			<div class="statement_details" v-else>
				<h3>{{statement.title |short(40)}}</h3>
				<p>{{statement.description | short(180)}}</p>
			</div>
		</a>
	</div>
</template>

<script>
	export default {
		data(){
			return{
				
				
			}
		},
		computed:{
		    link(){
                return '/statement/' + this.statement.uuid;
			}
		},
		props:['statement'],

		methods:{

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
		}
		
		
		
	}
</script>

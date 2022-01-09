<template>
    <view>
        <phone-search-list :phones="phones"></phone-search-list>
    </view>
</template>

<script>
	
    import phoneSearchList from './phone-search-list.vue';
	import _get from '../../common/_get';
	import _hook from '../../common/_hook';
	import _data from '../../common/_data';
	
    export default {
        components: {
            phoneSearchList
        },
        data() {
            return {
				phones: [],
            }
        },
		onShow(){
			_hook.routeSonHook();
		},
        onLoad (option) {
			let data = _data.localData('friend_list');
			console.log(data)
			if(data){
				this.phones = data;
			}
        },
		computed: {
			
		},
        methods: {
			
        }
    }
</script>

<style>

</style>
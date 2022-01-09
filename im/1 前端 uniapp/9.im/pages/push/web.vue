<template>
	
	<view>
        <web-view :src="url" v-if="url"/>
		<text style="text-align: center;color: red;" v-else>无效的地址</text>
	</view>
	
</template>

<script>
	
	import _hook from '../../common/_hook';
	
	export default {
		components: {
			
		},
		data() {
			return {
				url: false,
				agent_user_id:0
			}
		},
		onShow(){
			_hook.routeTabBarHook();
		},
		onLoad(option) {
			if('url' in option){
				option.url = decodeURIComponent(option.url);
				if(/^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\*\+,;=.]+$/.test(option.url)){
					if(!/^http/.test(option.url)){
						option.url = 'http://' + option.url;
					}
					this.url = option.url;
				}
			}
			if('title' in option){
				uni.setNavigationBarTitle({
					title: option.title,
				});
			}
			if('agent_user_id' in option){
				this.agent_user_id = option.agent_user_id;
			}
		},
		computed: {
			
		},
		methods: {
			
		},
		onNavigationBarButtonTap(e) {

			console.log(e.index)
			// #ifdef APP-PLUS
				let currentWebview = this.$mp.page.$getAppWebview().children()[0]; //获取当前页面的webview对象
			// #endif
			switch (e.index){
				case 0:
					//跳转客服
					//pages/details/index?user_id=271&is_type=0
					if(!this.agent_user_id)	uni.showToast({title: '改商户暂未设置客服',icon:'none'});
					uni.navigateTo({
						url: '/pages/details/index?is_type=0&user_id='+this.agent_user_id
					});
					break;
				case 1:
				
					// #ifdef APP-PLUS
						currentWebview.reload();
					// #endif
					
					// #ifdef H5
						location.reload();
					// #endif
					
					break;
				case 2:

					uni.switchTab({
						url: '../push/game',
					});
					
					break;
				case 3:
						uni.navigateBack();
					break;
				default:
					break;
			}
		},
	}
</script>

<style>
	
</style>

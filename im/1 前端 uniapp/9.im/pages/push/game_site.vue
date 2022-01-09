<template>

	<view>
		<web-view src="https://api.9idudu.com/sdkweb/?appId=LIU_DA"/>
	</view>

</template>

<script>

	import _hook from '../../common/_hook';

	export default {
		components: {

		},
		data() {
			return {
				url: 'https://api.9idudu.com/sdkweb/?appId=LIU_DA',
				agent_user_id:0
			}
		},
		
		onShow(){
			_hook.routeTabBarHook();
			
		},
		onReady() {
			setTimeout(function () {
				uni.hideLoading();
			},1000)
		},
		onLoad(option) {
			uni.showLoading({
				title:null,
			})
			if('url' in option){
				option.url = decodeURIComponent(option.url);
				if(/^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\*\+,;=.]+$/.test(option.url)){
					if(!/^http/.test(option.url)){
						option.url = 'http://' + option.url;
					}
					this.url = option.url;
				}
			}

			// if('title' in option){
			// 	uni.setNavigationBarTitle({
			// 		title: option.title,
			// 	});
			// }
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
					// #ifdef APP-PLUS
					currentWebview.reload();
					// #endif

					// #ifdef H5
					location.reload();
					// #endif
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

<template>
	<view class="page">
		
		<uni-list>
			<uni-list-item title="登录密码修改" 
						   :show-arrow="true"
						   :show-badge="true"
						   thumb="../../static/theme/default/my/password.png"
						   @click="goPath('../set/password')"
						   />
						   
		</uni-list>
		
		<view class="uni-padding-wrap uni-common-mt login_out">
			<button type="primary"  class="but-view" @tap="loginOut">退出登录</button>
		</view>
	</view>
</template>

<script>
	
	import uniList from '../../components/uni-ui/uni-list/uni-list.vue';
	import uniListItem from '../../components/uni-ui/uni-list-item/uni-list-item.vue';
	import _action from '../../common/_action';
	import _hook from '../../common/_hook';
	import _data from '../../common/_data';
	
	export default {
		components: {
			uniList,
			uniListItem
		},
		data() {
			return {
				my_data: {},
			}
		},
		onShow(){
			_hook.routeTabBarHook();
			let _this = this;
			/** 监听新的个人数据 */
			uni.$on('data_user_info',function(data){
				_this.my_data = data;
			});
		},
		onLoad() {
			let _this = this;
			_this.my_data = _data.data('user_info');
		},
		onUnload(){
			uni.$off('data_user_info');
		},
		computed: {
			
		},
		methods: {
			loginOut(){
				/** 跳转到登陆界面 */
				_action.checkFail()
				uni.reLaunch({
				  url: '/pages/in/login'
				});
			},
			goPath(path) {
				if(path){
					uni.navigateTo({
						url: path
					});
				}
			},
		},
		watch: {
			
		},
	}
</script>

<style>
	.login_out {
		margin-top: 100upx ;
	}
	.phto {
		width: 130upx;
		height: 130upx;
		margin-left: 30upx;
		margin-right: 30upx;
	}
	
	.my_padding {
		padding-bottom: 25px;
	}
	.but-view {
	  border-radius: 40upx;
	  height: 80upx;
	  text-align: center;
	  line-height: 80upx;
	  font-size: 16px;;
	}
	.my_padding:before {
		background-color:white;
	}
	
	.uni-list {
		margin-bottom: 30upx;
	}
	
</style>

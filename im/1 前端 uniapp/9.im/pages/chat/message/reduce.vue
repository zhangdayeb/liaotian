<template>
	<view class="page">
		
		<scroll-view class="scrollList" scroll-y>
			
			<view class="uni-list">
		
					<block v-for="(item, key) in list_data" :key="key">
						<view class="uni-list-cell"
						hover-class="none"
						>
							<checkbox-group @change="change(item.user_id + '')">
								<label class="uni-list-cell uni-list-cell-pd">
									<view>
										<checkbox color="#02b300"
										:value="item.user_id + ''"
										/>
									</view>
									<view class="uni-media-list">
										<view class="uni-media-list-logo">
											<image :src="staticPhoto + item.photo" :lazy-load="true"/>
										</view>
										<view class="uni-media-list-body">
											<view class="uni-list-cell-navigate">{{item.nickname}}</view>
										</view>
									</view>
								</label>
							</checkbox-group>
							
						</view>
						
					</block>
			</view>
		</scroll-view>
		
	</view>
</template>

<script>
	
	import _get from '../../../common/_get';
	import _hook from '../../../common/_hook';
	import _data from '../../../common/_data';
	
	export default {
		components: {
		},
		data() {
			return {
				list_data: [],				
				list_id: 0,
				add_user_ids: [],
			}
		},
		onShow(){
			_hook.routeTabBarHook();
		},
		onLoad(option) {
			let _this = this;
			_this.list_id = option.list_id;
			_this.$httpSend({
				path: '/im/message/groupMember',
				data: { list_id: _this.list_id },
				success(data) {
					_this.list_data = data;
				}
			});			
		},
		computed: {
			staticPhoto(){
				return _data.staticPhoto();
			}
		},
		methods: {
			change(user_id){
				if(user_id){
					let i = this.add_user_ids.indexOf(user_id);
					if(i > -1){
						this.add_user_ids.splice(i,1);
					}else{
						this.add_user_ids.push(user_id);
					}
				}
			},
		},
		watch: {
			
		},
		onNavigationBarButtonTap(e) {
			let _this = this;
			if(_this.add_user_ids.length){
				_this.$httpSend({
					path: '/im/message/removeChat',
					data: { users: JSON.stringify(_this.add_user_ids),list_id: _this.list_id, },
					success_action: true,
					success(res) {
						uni.showToast({
							title: res.msg,
							duration: 2000,
							icon: 'none',
						});
						setTimeout(() => {
							uni.redirectTo({
								url: './more?list_id=' + _this.list_id,
							});
						},2000);
					}
				});
			}else{
				uni.redirectTo({
					url: './more?list_id=' + _this.list_id,
				});
			}
		}
	}
</script>

<style>
	
	.page {
		display: flex;
		flex-direction:row;
	}
	
	.scrollList {
		flex: 1;
		height: 100vh;
	}

	.uni-indexed-list-bar {
		width: 40upx;
		height: 100vh;
		background-color: #e7e7e7;
		display: flex;
		flex-direction: column;
	}

	.uni-indexed-list-bar.active {
		/* background-color: rgb(200, 200, 200); */
	}

	.uni-indexed-list-text {
		font-size: 22upx;
		text-align: center;
	}

	.uni-indexed-list-bar.active .uni-indexed-list-text {
		color: #333;
	}

	.uni-indexed-list-text.active,
	.uni-indexed-list-bar.active .uni-indexed-list-text.active {
		color: #02b300;
	}

	.uni-indexed-list-alert {
		position: absolute;
		z-index: 20;
		width: 160upx;
		height: 160upx;
		left: 50%;
		top: 50%;
		margin-left: -80upx;
		margin-top: -80upx;
		border-radius: 80upx;
		text-align: center;
		line-height: 160upx;
		font-size: 70upx;
		color: #fff;
		background-color: rgba(0, 0, 0, 0.5);
	}
	
	.header {
		display: flex;
		flex-direction: row;
		padding: 10px 15px;
		align-items: center;
	}
	
	.input-view {
		display: flex;
		align-items: center;
		flex-direction: row;
		background-color: #e7e7e7;
		height: 30px;
		border-radius: 5px;
		padding: 0 10px;
		flex: 1;
	}
	
	.input {
		flex: 1;
		padding: 0 5px;
		height: 24px;
		line-height: 24px;
		font-size: 16px;
	}
	
	.uni-list-cell-navigate {
		padding: 0;
	}
	
	.uni-media-list-body {
		height: auto;
	}
</style>
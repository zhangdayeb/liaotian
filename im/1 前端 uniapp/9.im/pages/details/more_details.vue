<template>
	<view class="page">

		<navigator hover-class="none" :url="'/pages/friend/remarks?user_id=' + user_id" animation-type="slide-in-bottom">
			<view class="uni-list">
				<view class="uni-list-cell" hover-class="none">
					<view class="uni-list-cell-navigate uni-navigate-right">
							<view style="width:100%">
								设置备注和标签
							</view>
					</view>
				</view>
			</view>
		</navigator>
		
		<view class="switch_class" style="margin-top: 20upx;" v-if="0">
			<view class="uni-list">
				<view class="uni-list-cell uni-list-cell-pd">
					<view class="uni-list-cell-db">置顶聊天</view>
					<switch color="#02b300" :checked="false" />
				</view>
				<view class="uni-list-cell uni-list-cell-pd" v-if="0">
					<view class="uni-list-cell-db">消息免打扰</view>
					<switch color="#02b300" />
				</view>
				<view class="uni-list-cell uni-list-cell-pd" v-if="0">
					<view class="uni-list-cell-db">强提醒</view>
					<switch color="#02b300"/>
				</view>
			</view>
		</view>
		
		<view class="uni-list" style="margin-top: 20upx;" v-if="data.remove">
			<view class="uni-list-cell" hover-class="none">
				<view class="uni-list-cell-navigate" @tap="goDelete">
					<view class="tool">
						删除
					</view>
				</view>
			</view>
		</view>
		
	</view>
</template>

<script>
	
	import _hook from '../../common/_hook';
	import _get from '../../common/_get';
	import _data from '../../common/_data';
	
	export default {
		data() {
			return {
				user_id: 0,
				data: {
					remove: 0,
				},
			};
		},
		computed: {
			
		},
		onShow(){
			_hook.routeSonHook();
		},
		methods: {
			goDelete(){
				let _this = this;
				uni.showModal({
					title: '重要提示',
					content: '删除好友及相关的会话数据并且不能恢复，确认删除吗？',
					success: function (res) {
						if (res.confirm) {
							_this.$httpSend({
								path: '/im/remove/friend',
								data: { user_id: _this.user_id },
								success(list_id) {
									uni.showToast({
										title: '操作成功',
										duration: 1500
									});
									
									/** 删除会话列表数据 **/
									for(let i = 0,local_chat_list = _data.localData('chat_list'),j = local_chat_list.length;i < j;i ++){
										if(local_chat_list[i].list_id == list_id){											
											local_chat_list.splice(i,1);											
											_data.localData('chat_list',local_chat_list);
											uni.$emit('data_chat_list',local_chat_list);
											break;
										}
									}
									
									/** 删除对话数据 */
									_data.localData(list_id,null);
									
									/** 从我的好友列表里删除 */
									for(let i = 0,v = _data.localData('friend_list'),j = v.length;i < j;i ++){
										for(let k = 0,o = v[i].data,l = o.length;k < l;k ++){
											if(o[k].user_id == _this.user_id){
												v[i].data.splice(k,1);
												_data.localData('friend_list',v);
												uni.$emit('data_friend_list',v);
												break;
											}
										}
									}
									
									setTimeout(() => {
										uni.switchTab({
											url: '../friend/index',
										});
									},1600);
								}
								
							});
						}
					}
				});
			}
		},
		onLoad(option) {
			this.user_id = option.user_id;
			let _this = this;
			_this.$httpSend({
				path: '/im/friend/details',
				data: { user_id: _this.user_id },
				success(data) {
					_this.data = data;
				}
			});
			
		},
	}
	
</script>

<style>
	.tool {
		width:100%;
		text-align: center;
		color: red;
	}
</style>

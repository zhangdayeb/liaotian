<template>
	<view class="page">
		<view class="page-content">
			<view class="page-list">
				<view class="page-item">
					<view class="page-item-left">
						<view>全员禁言</view>
						<view class="page-item-info">开启后仅群主和管理员可以发言</view>
					</view>
					<view class="page-item-right">
						<switch   :checked="!!data.group.is_msg" @change="msgChange" />
					</view>
				</view>
				<view class="page-item">
					<view class="page-item-left">
						<view>允许群程序修改群名称和头像</view>
						<view class="page-item-info">关闭后紧群主和管理员可以修改群名称和头像</view>
					</view>
					<view class="page-item-right">
						<switch :checked="!!data.group.edit_photo" @change="editChange" />
					</view>
				</view>
				<view class="page-item">
					<view class="page-item-left">
						<view>允许群成员领取长时间未领取的红包</view>
						<view class="page-item-info">关闭后紧群主和管理员使用</view>
					</view>
					<view class="page-item-right">
						<switch  :checked="!!data.group.can_get_bigred" @change="getRedChange" />
					</view>
				</view>
				<view class="page-item">
					<view class="page-item-left">
						<view>允许群成员上麦</view>
						<view class="page-item-info">关闭后紧群主和管理员可以上麦</view>
					</view>
					<view class="page-item-right">
						<switch  :checked="!!data.group.can_shangmai" @change="shangmai" />
					</view>
				</view>
				<view class="page-item">
					<view class="page-item-left">
						<view>群内禁止好友</view>
						<view class="page-item-info">关闭后群成员直接可以加好友</view>
					</view>
					<view class="page-item-right">
						<switch checked="!data.group.can_add_friend" @change="switch1Change"/>
					</view>
				</view>
				<view class="page-item">
					<view class="page-item-left">
						<view>匿名聊天</view>
						<view class="page-item-info">开启后用户聊天不显示真实头像</view>
					</view>
					<view class="page-item-right">
						<switch :checked="data.group.can_niming == 1" @change="nimingChange" />
					</view>
				</view>
				<view class="page-item-footer" @tap="goSetAdmin(4)">
					<view class="page-item-left">
						<view>一键复制新群</view>
					</view>
					<view class="page-item-right">
						<view class="iconfont-im icon-jiantou font-jiantou"></view>
					</view>
				</view>

				<view class="footer-list">
					<view class="page-item-footer" @tap="goSetAdmin(1)">
						<view class="page-item-left">
							<view>设置管理员</view>
						</view>
						<view class="page-item-right">
							<view class="iconfont-im icon-jiantou font-jiantou"></view>
						</view>
					</view>
					<view class="footer-hr"></view>
					<view class="page-item-footer" @tap="goSetAdmin(3)">
						<view class="page-item-left">
							<view>群主管理权转让</view>
						</view>
						<view class="page-item-right">
							<view class="iconfont-im icon-jiantou font-jiantou"></view>
						</view>
					</view>
					<view class="footer-hr"></view>
					<view class="page-item-footer" @tap="reduce">
						<view class="page-item-left">
							<view>踢出群成员</view>
						</view>
						<view class="page-item-right">
							<view class="iconfont-im icon-jiantou font-jiantou"></view>
						</view>
					</view>
					<view class="footer-hr"></view>
					<view class="page-item-footer" @tap="goSetAdmin(2)">
						<view class="page-item-left">
							<view>禁言设置</view>
						</view>
						<view class="page-item-right">
							<view class="iconfont-im icon-jiantou font-jiantou"></view>
						</view>
					</view>
					<view class="footer-hr"></view>
					<view class="doButton"  v-show="data.is_action == 2" >
						<button class="group-button" type="button" @tap="removeGroup">解散该群</button>
					</view>
				</view>

			</view>
		</view>
	</view>
</template>

<script>
	import _hook from '../../../common/_hook';
	import _data from '../../../common/_data';
	import _page from '../../../common/common';

	export default {
		data() {
			return {
				data: {
					member: [],
					group: {
						is_photo: 'default_group_photo/90.jpg',
					},
					is_action: 0,
					type: 1,
				},
				list_id: 0,
			};
		},
		computed: {
			staticPhoto(){
				return _data.staticPhoto();
			},
			isAction(){
				if(this.data.group.main_id == _data.data('user_info').id){
					return true;
				}
				return false;
			}
		},
		onShow(){
			_hook.routeSonHook();
			let _this = this;
			_this.$httpSend({
				path: '/im/message/getChatDetails',
				data: { list_id: _this.list_id, },
				success(data) {
					_this.data = data;
					if(data.type == 1){
						uni.setNavigationBarTitle({
							title: data.group.name,
						});
					}
					let cache_data = _data.data('cache');
					if(data.type == 1 && !('group_photo_' + _this.list_id in cache_data)){
						uni.downloadFile({
							url: _data.staticPhoto() + data.group.is_photo,
							success: (res) => {
								if (res.statusCode === 200) {
									cache_data['group_photo_' + _this.list_id] = res.tempFilePath;
									_data.data('cache',cache_data);
								}
							}
						});
					}

				}
			});
		},
		methods: {
			shangmai(e){
				//消息免打扰
				let value = e.detail.value ? 1 : 0;
				let _this = this;
				this.$httpSend({
					path: '/im/vendor/setShangmai',
					data: {list_id: this.list_id, value: value},
					success(data) {
						_data.localData('DISTURB:'+_this.list_id,value)
					}
				});
			},
			groupNickname(val){
				console.log(val)
				uni.navigateTo({
					url:'group_nickname?'+_page.pageParam({list_id:this.list_id,nickname:val})
				})
			},
			disturb(e){
				//消息免打扰
				let value = e.detail.value ? 1 : 0;
				let _this = this;
				this.$httpSend({
					path: '/im/message/msgDisturb',
					data: {list_id: this.list_id, value: value},
					success(data) {
						_data.localData('DISTURB:'+_this.list_id,value)
					}
				});
			},
			liveGroup(){
				//离开群聊
				let _this = this;
				uni.showModal({
					title: '重要提示',
					content: '确定要离开群聊吗?',
					confirmText: '离开',
					cancelText: '再看看',
					confirmColor: 'red',
					cancelColor: '#353535',
					success: function (res) {
						if (res.confirm) {
							_this.$httpSend({
								path: '/im/message/liveGroup',
								data: { list_id: _this.list_id },
								success(data) {
									console.log(data)
									uni.switchTab({
										url: '../index'
									});
								}
							});
						}
					}
				});
			},
			imageError(e){
				console.log("图片加载失败!",e.detail);
				let index = e.currentTarget.dataset.index
				console.log(e.currentTarget.dataset.index)
				//替换index对应的图片
				console.log(this.data.member[index].photo)
				this.data.member[index].photo = '/default_photo_path.png';
			},
			removeGroup(){
				let _this = this;
				uni.showModal({
					title: '重要提示',
					content: '此操作数据不可恢复,确定要解散该群吗?',
					confirmText: '不解散',
					cancelText: '解散',
					confirmColor: '#353535',
					cancelColor: 'red',
					success: function (res) {
						if (!res.confirm) {
							_this.$httpSend({
								path: '/im/message/removeGroup',
								data: { list_id: _this.list_id, },
								success(data) {
									uni.switchTab({
										url: '../index'
									});
								}
							});
						}
					}
				});
			},
			photo(path){
				return this.staticPhoto + path + '?_=' + Math.random();
			},
			msgChange(e){
				let value = e.detail.value ? 1 : 0;
				if(this.data.is_action != 2){
					uni.showModal({
						content: '没有权限设置',
						showCancel: false,
					});
					return;
				}
				this.$httpSend({
					path: '/im/message/groupIsMsg',
					data: { list_id: this.list_id,value, },
					success(data) {
						return;
						uni.showToast({
							title: '设置成功',
							duration: 1500
						});
					}
				});
			},
			nimingChange(e){
				let value = e.detail.value ? 1 : 0;
				if(!this.data.is_action && this.data.is_action != 2){
					uni.showModal({
						content: '没有权限设置',
						showCancel: false,
					});
					return;
				}
				this.$httpSend({
					path: '/im/message/nimingChange',
					data: { list_id: this.list_id,value, },
					success(data) {
						return;
						uni.showToast({
							title: '设置成功',
							duration: 1500
						});
					}
				});
			},
			msgTop(e){
				let _this = this,
						value = e.detail.value ? 1 : 0;
				this.$httpSend({
					path: '/im/message/chatTop',
					data: { list_id: this.list_id,value, },
					success(data) {
						/** 更新对话列表数据 */
						for(let i = 0,local_chat_list = _data.localData('chat_list'),j = local_chat_list.length;i < j;i ++){
							if(local_chat_list[i].list_id == _this.list_id){
								let action_list_data = local_chat_list[i];
								local_chat_list.splice(i,1);
								local_chat_list.unshift(action_list_data);
								_data.localData('chat_list',local_chat_list);
								uni.$emit('data_chat_list',local_chat_list);
								break;
							}
						}

						return;
						uni.showToast({
							title: '设置成功',
							duration: 1500
						});
					}
				});
			},
			switch1Change(e){
				let _this = this, value = e.detail.value ? 1 : 0;
				this.$httpSend({
					path: '/im/message/speekChecked',
					data: { list_id: this.list_id,value:value,},
					success(data) {
						/** 更新对话列表数据 */
						for(let i = 0,local_chat_list = _data.localData('chat_list'),j = local_chat_list.length;i < j;i ++){
							if(local_chat_list[i].list_id == _this.list_id){
								let action_list_data = local_chat_list[i];
								local_chat_list.splice(i,1);
								local_chat_list.unshift(action_list_data);
								_data.localData('chat_list',local_chat_list);
								uni.$emit('data_chat_list',local_chat_list);
								break;
							}
						}
					}
				});
			},
			editChange(e){
				let _this = this, value = e.detail.value ? 1 : 0;
				this.$httpSend({
					path: '/im/vendor/editChange',
					data: { list_id: this.list_id,value:value,},
					success(data) {

					}
				});
			},
			goGroupQrcode(){
				uni.navigateTo({
					url: ('./group_qrcode?list_id=' + this.list_id),
					animationType: 'slide-in-bottom',
				});
			},
			goSetGroupPhoto(){
				if(this.data.is_action != 2 && !this.data.group.edit_photo){
					uni.showToast({
						title: '没有权限设置',
						icon: 'none',
						duration: 1000
					});
					return;
				}
				uni.navigateTo({
					url: ('../../set/group_photo?list_id=' + this.list_id),
					animationType: 'slide-in-bottom',
				});
			},
			goSetAdmin(type){
				switch (type){
					case 1:
						if(this.data.is_action != 2){
							console.log("this.data.is_action",this.data.is_action)
							uni.showToast({
								title: '群主才能设置',
								icon: 'none',
								duration: 1000
							});
							return;
						}
						break;
					case 2:
						if(this.data.is_action != 2){
							uni.showModal({
								content: '没有权限设置',
								showCancel: false,
							});
							return;
						}
						break;
					case 3:
						if(this.data.is_action != 2){
							uni.showModal({
								content: '没有权限设置',
								showCancel: false,
							});
							return;
						}
						break;
					case 4:
						if(this.data.is_action != 2){
							uni.showModal({
								content: '没有权限设置',
								showCancel: false,
							});
							return;
						}
						break;
					default:
						return;
						break;
				}
				let url = '../../set/group_admin?list_id=' + this.list_id + '&type=' + type;
				if(type == 3)url = '../../set/group_trans?list_id=' + this.list_id + '&type=' + type;
				if(type == 4)url = '../../set/copy_group?list_id=' + this.list_id + '&type=' + type;
				uni.navigateTo({
					url: url,
					animationType: 'slide-in-bottom',
				});
			},
			goSet(type){
				if(this.data.is_action != 2 && !this.data.group.edit_photo){
					uni.showToast({
						title: '没有权限设置',
						icon: 'none',
						duration: 1000
					});
					return;
				}
				uni.navigateTo({
					url: ('../../set/message_more?list_id=' + this.list_id + '&type=' + type),
					animationType: 'slide-in-bottom',
				});
			},
			goDetails(user_id){
				if(this.data.type&& this.data.is_action != 2){
					uni.showToast({
						title: '没有权限查看',
						icon: 'none',
						duration: 1000
					});
					return;
				}
				uni.navigateTo({
					url: ('../../details/index?user_id=' + user_id+'&type='+this.data.type+'&list_id='+this.list_id+"&is_action="+this.data.is_action),
				});
			},
			add(){
				uni.navigateTo({
					url: ('../../friend/index_list?list_id=' + this.list_id),
					animationType: 'slide-in-bottom',
				});
			},
			reduce(){
				uni.navigateTo({
					url: ('./reduce?list_id=' + this.list_id),
					animationType: 'slide-in-bottom',
				});
			},
			groupCopy(value) {
				_page.uniCopy({
					content:this.data.group.id,
					success:function () {
						uni.showToast({'title':'复制成功',duration:2000})
					}
				})
			},
			replaceStr(str){
				console.log(str)
				return str.substr(10)
			},
			getRedChange(e){
				let _this = this, value = e.detail.value ? 1 : 0;
				this.$httpSend({
					path: '/im/vendor/getRedChange',
					data: { list_id: this.list_id,value:value,},
					success(data) {

					}
				});
			},
			goBigRedList(){ //todo 长时间未领取红包列表
				uni.navigateTo({url:"../message/red_list?list_id="+this.list_id})
			},
			manarger(){
				uni.navigateTo({url:'../message/qun_manage?list_id='+this.list_id})
			}
		},
		onLoad(option) {
			this.list_id = option.list_id;
			this.data.type = option.type;
		},
	}
</script>

<style>
page{
	background-color: #e5e5e5;
}
.page{
	height: 100%;
}
.page-content{
	display:flex;
	justify-content: space-between;
	flex-direction: column;
}
.page-list{
	display: flex;
	flex-direction: column;
	justify-content: space-between;
}
.page-item{
	display: flex;
	justify-content: space-between;
	align-items: center;
	background-color: #ffffff;
	margin-bottom: 10px;
	padding: 10px 20px;
}
.page-item-footer{
	display: flex;
	justify-content: space-between;
	align-items: center;
	background-color: #ffffff;
	padding: 10px 20px;
}
.footer-hr{
	height: 1upx;
	width: 90%;
	background-color: #e1e1e1;
	margin: 0 auto;
}
.page-list:first-child{
	border-top: 1upx solid #e1e1e1;
}
.page-item-left{
	display: flex;
	justify-content: center;
	flex-direction: column;
}
.footer-list{
	background-color: #ffffff;
	padding-bottom: 20px;
}
.page-item-info{
	color: #bababa;
	font-size: 12px;
}
.font-jiantou{
	font-size: 12px;
}
.page-item-footer .page-item-right{
	margin-right: 20px;
}
.page-item-footer{
	margin-bottom: 10px;
}
.doButton{
	padding: 10px;
}
.group-button{
	width: 92%;
	background-color: #5693ee;
	color: white;
	height: 70upx;
	line-height:  70upx !important;
	border-radius: 40upx;
	font-size: 36upx;
	cursor: pointer;
	margin-top: 20upx;
}
</style>

<template>
	<view id="moments"
		  class="page">
		<view  v-if="showVedio"  class="showVedio"  :style="{height:screenHeight+'px',width:'100%'}">
			<!-- <video :src="videoPath"
                   style="height: 100%;width: 100%"
                   id="myVideo"
                   object-fit="fill"
                   airplay="allow" /> -->
			<video autoplay="true"
				   page-gesture="true"
				   controls="false"
				   @fullscreenchange="fullscreenchange"
				   :style="{height:'100%',width:'100%'}"
				   id="myVideo"
				   class="showVedio-video"
				   :src="videoPath">
				<cover-image @tap="showVedio = false"
							 src="/static/theme/default/my/close.png"
							 class="cloneBut">
				</cover-image>

				<!-- </cover-view> -->
			</video>
		</view>

		<view class="home-pic">
			<image
					:src="circleImg"
					style="width: 750upx; height: 500upx; border-radius: 0upx;"
			/>
			</image>
			<view class="home-pic-base">
				<view class="top-pic">
					<image class="header"
						   :src="myPhoto"
						   @tap.stop="goDetails(my_data.id)"
						   :lazy-load="true" />
				</view>
				<view class="top-name"
					  style="color: #FFFFFF;margin-bottom: 10px;">{{ my_data.nickname }}</view>
			</view>
		</view>

		<view class="new_msg"
			  @tap="goCircleChat"
			  v-if="no_reader_msg">你有新的消息</view>

		<view class="moments__post"
			  v-for="(post,index) in posts"
			  :key="index"
			  :id="'post-'+index" >
			<view class="post-left">
				<image class="post_header"
					   :src="staticPhoto + post.header_image + '?_=' + imgRan"
					   @tap="goDetails(post.uid)"
					   :lazy-load="true" />
			</view>

			<view class="post_right">
				<text class="post-username"
					  @tap="goDetails(post.uid)">{{post.username}}</text>
				<view>
					<view id="paragraph"
						  class="paragraph"
						  @tap="init_input()">{{post.content.text}}</view>

					<!-- 相册 -->
					<view class="thumbnails"
						  v-if="post.type == 0"
						  @tap="init_input()">
						<view :class="post.content.value.length === 1 ? 'my-gallery' : 'thumbnail' "
							  v-for="(image, index_images) in post.content.value"
							  :key="index_images">
							<image class="gallery_img"
								   :lazy-load="true"
								   mode="aspectFill"
								   :src="staticPath + post.post_id +'/' + image"
								   :data-src="image"
								   @tap="previewImage(index,index_images)"/>
							<image v-if="post.content.video_path"  @tap="previewImage(index,index_images)"  class="bofang-button" style="width: 30px;height: 30px;position: absolute;top: 315rpx;left:220rpx"   mode="aspectFill" src="/static/theme/default/my/bofang.png"></image>
						</view>
					</view>
				</view>
				<view class="pay_view"
					  v-if="post.can_pay == 1"> <button :disabled="post.can_pay_times == 0"
														:style="{'background-color':post.can_pay_times == 1?'#4591ff':'#A9A9A9'}"
														size="mini"
														@tap="open(index)"
														type="primary">{{post.can_pay_times == 0 ? '已售出' : '￥'+post.pay_amount + '元'}}</button></view>

				<!-- 资料条 -->
				<view class="toolbar">
					<view class="timestamp">{{ post.timestamp }}</view>
					<view class="like"
						  @tap="like(index)">
						<image :src="post.islike === 0 ? '../../static/theme/default/push/circle/islike.png' : '../../static/theme/default/push/circle/like.png'"
							   :lazy-load="true" />
					</view>
					<view class="comment"
						  @tap="comment(index)">
						<image src="../../static/theme/default/push/circle/comment.png"
							   :lazy-load="true"></image>
					</view>
				</view>
				<!-- 赞／评论区 -->
				<view class="post-footer">
					<view class="footer_content"
						  v-if="post.like.length">
						<image class="liked"
							   src="../../static/theme/default/push/circle/liked.png"
							   :lazy-load="true"></image>
						<text class="nickname"
							  v-for="(user,index_like) in post.like"
							  :key="index_like"
							  @tap="goDetails(user.uid)">
							{{(index_like ? ',' : '' ) + user.username}}
						</text>
					</view>
					<view class="footer_content"
						  v-for="(comment,comment_index) in post.comments"
						  :key="comment_index"
						  @tap="reply(index,comment_index)">

						<text class="comment-nickname"
							  style="word-break:break-all;">
							{{comment.username + comment.reply + ': '}}
							<text class="comment-content">
								{{comment.content}}
							</text>
						</text>

					</view>
				</view>
			</view>
			<!-- 结束 post -->
		</view>

		<view class="foot"
			  v-show="showInput">
			<chat-input @send-message="send_comment"
						@blur="blur"
						:focus="focus"
						:placeholder="input_placeholder"></chat-input>
			<!-- <chat-input @send-message="send_comment" @blur="blur" :placeholder="input_placeholder"></chat-input> -->
		</view>
		<view class="uni-loadmore"
			  v-if="showLoadMore">{{loadMoreText}}</view>
		<view :class="['action_main animated faster',(action_menu ? 'bounceInDown' : 'bounceOutUp')]"
			  v-show="showActionMenu"
			  @tap="actionMain">
			<view class="action_base">

				<view class="sj"></view>

				<view class="action_item"
					  @tap="goAction(0)">
					<text class="action_item_text">发送图文</text>
				</view>

				<view class="action_item"
					  @tap="goAction(1)">
					<text class="action_item_text">发送视频</text>
				</view>
			</view>
		</view>
		<uni-popup ref="popup" type="address">
			<uni-popup-address :userAddress="userAddress" :amount="amount" :goods_name="goods_name" :small_pic="small_pic" @confirm="goBuy"></uni-popup-address>
		</uni-popup>
		<pay-keyboard   :showCose="showCose" :set_info = "set_info" :show_key="show_key" ref="payKeyboard" :set_msg="set_msg" @hideFun="hideFun" @getPassword="getPassword"></pay-keyboard>
	</view>


</template>
<script>
	import chatInput from './circle/chat_input.vue'; //输入消息框
	import _get from '../../common/_get';
	import _hook from '../../common/_hook';
	import avatar from "../../components/yq-avatar/yq-avatar.vue";
	import _data from '../../common/_data';
	import UniPopupAddress from "../../components/uni-popup/uni-popup-address";
	import UniPopup from "../../components/uni-popup/uni-popup";
	import payKeyboard from "../../components/uni-keyword/uni-keyword";
	export default {
		components: {
			UniPopup,
			UniPopupAddress,
			chatInput,
			avatar,
			payKeyboard
		},
		data () {
			return {
				showPage:true,
				my_data: {
					id: 0,
					nickname: '',
					photo: 'default_man/90.jpg',
					circle_img: 'default_circle_img.jpg',
				},
				showCose:true,
				set_info:'请输入交易密码，以确认身份',
				show_key:false,
				set_msg:'请输入交易密码',
				user_id: 0,
				action_menu: false,
				posts: [],// 模拟数据
				index: '',
				comment_index: '',
				input_placeholder: '评论', //占位内容
				focus: false, //是否自动聚焦输入框
				is_reply: false, //回复还是评论
				showInput: false, //评论输入框
				screenHeight: '', //屏幕高度(系统)
				platform: '',
				windowHeight: '',//可用窗口高度(不计入软键盘)
				loadMoreText: "加载中...",
				showLoadMore: false,
				is_more: false,
				no_reader_msg: 0,
				doubleClick: false,
				showVedio:false,
				videoPath:'',
				post_id:'',
				post_index_id:0,
				userAddress:{
					regionStr: '',
					username: '',
					mobile: '',
					address: '',
					regionCode:'440113'
				},
				small_pic:'',
				amount:'',
				goods_name: '',
			}
		},
		computed: {
			regionName(){
				return this.region.map(item=>item.name).join(' ')
			},
			showActionMenu () {
				return this.action_menu;
			},
			myPhoto () {
				return _data.staticPhoto() + this.my_data.photo + '?_=' + this.imgRan;
			},
			circleImg () {
				return _data.staticPhoto() + this.my_data.circle_img;
			},
			staticPath () {
				return _data.staticCircle();
			},
			staticPhoto () {
				return _data.staticPhoto();
			},
			imgRan () {
				return Math.random();
			},
		},
		onLoad (option) {
			let _this = this;
			_this.user_id = option.user_id;
			uni.getSystemInfo({ //获取设备信息
				success: (res) => {
					_this.screenHeight = res.screenHeight;
					_this.platform = res.platform;
				}
			});
		},
		onShow () {
			_hook.routeSonHook();
			let _this = this;
			uni.onWindowResize((res) => { //监听窗口尺寸变化,窗口尺寸不包括底部导航栏
				if(this.platform === 'ios'){
					this.windowHeight = res.size.windowHeight;
					this.adjust();
				}else{
					if (this.screenHeight - res.size.windowHeight > 60 && this.windowHeight <= res.size.windowHeight) {
						this.windowHeight = res.size.windowHeight;
						this.adjust();
					}
				}
			});
			this.pullDownRefresh();
			/** 监听新的个人数据 */
			uni.$on('data_user_info',function(data){
				_this.my_data = data;
			});
		},
		onNavigationBarButtonTap (e) {
			this.action_menu = !this.action_menu;
		},
		onUnload () {
			uni.$off('data_circle_tips');
			uni.$off('data_user_info');
			uni.$off('data_circle_data_user');
			uni.offWindowResize(() => {
			});
			this.max = 0,
					this.data = [],
					this.loadMoreText = "加载更多",
					this.showLoadMore = false;
		},
		onReachBottom () { //监听上拉触底事件
			let _this = this;
			_this.showLoadMore = true;
			if (_this.is_more) {
				return;
			}
			let time = 0,
					is_length = _this.posts.length;
			if (is_length) {
				time = _this.posts[is_length - 1].time;
			}
			this.getCircleList({
				time,
				type: 1,
				user_id: this.user_id,
			},(data) => {
				_this.my_data = data.user_info;
			});
		},
		onPullDownRefresh () { //监听下拉刷新动作
			if (_data.data('no_reader_circle') || _data.data('no_reader_circle_chat_num')) {
				this.posts = [];
				_data.data('circle_data', []);
			}
			this.pullDownRefresh();
		},
		onNavigationBarButtonTap (e) {//监听标题栏点击事件
			let _this = this;
			if (e.index == 0) {
				// this.navigateTo('./circle/send');
				// this.action_menu = !this.action_menu
				let list = [{
					name: "图文",
					key: "image"
				},{
					name: "短视频",
					key: "video"
				},{
					name: "取消",
					key: "cancle"
				}]
				uni.showActionSheet({
					itemList: list.map(v => v.name),
					success: res => {
						if(res.tapIndex == 2)return false;
						uni.navigateTo({
							url: './circle/send?type=' + list[res.tapIndex].key+'&user_id='+_this.user_id,
						});
					},
				});
			}
		},
		methods: {
			getCircleList(send_data){
				let _this = this;
				this.$httpSend({
					path: '/im/get/circleData',
					data: send_data,
					success(data) {
						if(data.data.length){
							let circle_data = [];
							if(send_data.type){
								_this.posts.push(...data.data);
							}else{
								_this.posts.unshift(...data.data);
							}
						} else {
							_this.loadMoreText = '没有更多数据了';
							_this.is_more = true;
						}
						_this.my_data = data.user_info;
					}
				});
			},
			goAction (index) {
				if (index === 0) {
					this.navigateTo('./circle/send?user_id='+this.user_id);
				}
			},
			actionMain () {
				this.action_menu = !this.action_menu;
			},
			upload (e) {
				let _this = this;
				_this.$httpSendFile({
					local_url: e.path,
					type: 3,
					success (data) {
						_this.$httpSend({
							path: '/im/action/upCircleImg',
							success (data) {
								_get.base();
								uni.showToast({
									title: '更换成功',
									duration: 2000
								});
							}
						});
					},
				});
			},
			goCircleChat () {
				_data.data('no_reader_circle_chat_num', 0);
				this.navigateTo('./circle_chat_details');
			},
			pullDownRefresh () {
				//初始化数据
				let time = 0;
				if(this.posts.length){
					time = this.posts[0].time;
				}
				this.getCircleList({
					time,
					type: 0,
					user_id: this.user_id,
				},(data) => {
					_this.my_data = data.user_info;
				});
				uni.stopPullDownRefresh(); //停止下拉刷新
			},
			goDetails (user_id) {
				this.navigateTo('../details/index?user_id=' + user_id);
			},
			navigateTo (url) {
				uni.navigateTo({
					url: url
				});
			},
			like (index) {
				let _this = this,
						is_like = (_this.posts[index].islike ? 0 : 1);
				console.log(is_like)
				_this.$httpSend({
					path: '/im/circle/likeAction',
					data: {
						is_like: is_like,
						id: _this.posts[index].post_id,
					},
					success (data) {
						// _this.posts[index].islike = data.action;

					}
				});
			},
			comment (index) {
				if (this.showInput) {
					this.showInput = false;
					this.focus = false;
					this.index = '';
				} else {
					this.showInput = true; //调起input框
					this.focus = true;
					this.index = index;
				}
			},
			adjust () { //当弹出软键盘发生评论动作时,调整页面位置pageScrollTo

				uni.createSelectorQuery().selectViewport().scrollOffset(res => {
					var scrollTop = res.scrollTop;
					let view = uni.createSelectorQuery().select("#post-" + this.index);
					view.boundingClientRect(data => {

						// console.log("data:" + JSON.stringify(data));
						// console.log("手机屏幕高度:" + this.screenHeight);
						// console.log("竖直滚动位置" + scrollTop);
						// console.log("节点离页面顶部的距离为" + data.top);
						// console.log("节点高度为" + data.height);
						// console.log("窗口高度为" + this.windowHeight);

						// uni.pageScrollTo({
						// 	scrollTop: scrollTop - (this.windowHeight - (data.height + data.top + 45)), //一顿乱算
						// 	// scrollTop: 50,
						// 	duration: 300
						// });
					}).exec();
				}).exec();
			},
			reply (index, comment_index) {
				this.is_reply = true; //回复中
				this.showInput = true; //调起input框
				let replyTo = this.posts[index].comments[comment_index].username;
				this.input_placeholder = '回复' + replyTo;
				this.index = index; //post索引
				this.comment_index = comment_index; //评论索引
				this.focus = true;
			},
			blur: function () {
				//this.init_input();
			},
			send_comment: function (message) {
				let _this = this,
						is_posts_obj = this.posts[this.index],
						chat_user_id = is_posts_obj.uid,
						reply = '';
				if (this.is_reply) {
					let is_reply_obj = is_posts_obj.comments[this.comment_index];
					chat_user_id = is_reply_obj.uid;
					if (is_posts_obj.uid != chat_user_id) {
						reply = '回复' + is_reply_obj.username;
					}
				}
				_this.$httpSend({
					path: '/im/circle/comment',
					data: {
						message,
						id: is_posts_obj.post_id,
						chat_user_id,
					},
					success (data) {
						is_posts_obj.comments.push({
							"uid": _this.my_data.id,
							'reply': reply,
							"username": _this.my_data.nickname,
							"content": message
						});
						_this.init_input();
					}
				});
			},
			init_input () {
				this.showInput = false;
				this.focus = false;
				this.input_placeholder = '评论';
				this.is_reply = false;
			},

			createVideoPlayer(video_path){
				// #ifdef APP-PLUS
				let player = null;
				player = plus.video.createVideoPlayer('videoplayer', {
					src:'rtmp://'+video_path,
					top:'50px',
					left:'0px',
					width: '100%',
					height: '100%',
					position: 'fix'
				});
				var pages = getCurrentPages();
				var page = pages[pages.length - 1];
				var currentWebview = page.$getAppWebview();
				currentWebview.append(player)
				// #endif
			},
			previewImage (index, image_index) {
				let data = this.posts[index],
						_this = this,
						images_all = [];
				console.log(111)
				if(data.content.video_path){
					let video_path = this.staticPath + data.post_id + '/' + data.content.video_path;
					_this.videoPath = video_path;
					_this.showVedio = true;
					//设置屏幕高度
					return true;
				}
				for (let i = 0, j = data.content.value.length; i < j; i++) {
					images_all.push(this.staticPath + data.post_id + '/' + data.content.value[i].replace('_thumb', ''));
				}
				var current = images_all[image_index];
				uni.previewImage({
					current: current,
					urls: images_all
				});
			},
			goPublish () {
				uni.navigateTo({
					url: './circle/send',
					success: res => { },
					fail: () => { },
					complete: () => { }
				});
			},
			// 获取选择的地区
			goBuy(address){
				//弹出交易密码界面
				// this.show_key = true;
				this.userAddress = address;
				_data.localData('data_user_address',address);
				//去支付
				let _this = this;
				let params =this.userAddress;
				params.post_id = this.post_id;
				let circle_data =  _data.localData('circle_data');
				let data = _this.posts[_this.post_index_id];
				let small_pic = this.staticPath + params.post_id + '/' + data.content.value[0].replace('_thumb', '');
				params.small_pic = small_pic;
				_get.payCicleOrder(params,function (ret) {
					//更新本地朋友圈信息
					data.can_pay_times = ret.can_pay_times;
					circle_data[_this.post_index_id] = data;
					_data.localData('circle_data',circle_data)
					uni.$emit('data_circle_data',circle_data);
					uni.showToast({
						title:'购买成功',
						icon:'none',
					});
					_this.$refs.popup.close();

				},function (ret) {
					uni.showToast({
						title:ret.msg,
						icon:'none',
					});
					_this.show_key = false;
				})
			},
			hideFun(){
				this.show_key = false;
			},
			getPassword(e){
				//去支付
				let _this = this;
				e.post_id = this.post_id;
				let params = Object.assign(e,this.userAddress);
				let circle_data =  _data.localData('circle_data');
				let data = circle_data[_this.post_index_id];
				let small_pic = this.staticPath + data.post_id + '/' + data.content.value[0].replace('_thumb', '');
				e.small_pic = small_pic;
				_get.payCicleOrder(params,function (ret) {
					//更新本地朋友圈信息
					data.can_pay_times = ret.can_pay_times;
					circle_data[_this.post_index_id] = data;
					_data.localData('circle_data',circle_data)
					uni.$emit('data_circle_data',circle_data);
					uni.showToast({
						title:'购买成功',
						icon:'none',
					});
					_this.show_key = false;
					_this.$refs.payKeyboard.cleanNum();
					_this.$refs.popup.close();

				},function (ret) {
					uni.showToast({
						title:ret.msg,
						icon:'none',
					});
					_this.show_key = false;
					_this.$refs.payKeyboard.cleanNum();
				})
			},
			open(index){
				let data = this.posts[index];
				console.log(this.my_data);

				console.log(this.userAddress)
				this.goods_name = data.content.text;
				this.small_pic =  this.staticPath + data.post_id + '/' + data.content.value[0].replace('_thumb', '');
				this.amount = data.pay_amount;
				this.post_id = data.post_id;
				this.post_index_id = index;
				this.$refs.popup.open();

			},
			fullscreenchange(){
				console.log(1111111111111)
			}
		},
		watch: {

		},
	}
</script>

<style scoped>
	@import url("../../static/css/push/circle.css");
	.page {
		position: relative;
	}
	.pay_view {
		margin: 15upx 0;
		text-align: right;
	}
	.new_msg {
		text-align: center;
		color: #36648b;
		font-weight: bold;
	}
	.action_main {
		position: fixed;
		top: 120upx;
		/* #ifndef H5 */
		top: 15px;
		/* #endif */
		width: 750upx;
		height: 1080upx;
		z-index: 10000;
	}
	.action_base {
		position: absolute;
		right: 15upx;
		width: 300upx;
		top: 120upx;
		background: #36363d;
		border-radius: 10upx;
	}

	.sj {
		position: fixed;
		top: -28upx;
		right: 26upx;

		/* #ifdef APP-PLUS */
		top: 3upx;
		right: 20upx;
		/* #endif */

		width: 0;
		height: 0;
		border-left: 20upx solid transparent;
		border-right: 20upx solid transparent;
		border-bottom: 20upx solid #36363d;
	}

	.action_item {
		color: #e5e5e5;
		height: 100upx;
		line-height: 100upx;
		margin-left: 45upx;
		border-bottom: 1px solid #3e3e3e;
	}

	.action_icon {
		width: 45upx;
		height: 45upx;
		display: inline-block;
		vertical-align: middle;
	}

	.action_item:last-child {
		border: none;
	}

	.action_item_text {
		font-size: 30upx;
	}
	.showVedio {
		position: fixed;
		z-index: 999;
	}
	.cloneBut {
		position: relative;
		font-size: 24px;
		color: red;
		margin-left: 30px;
		margin-top: 80px;
		height: 30px;
		width: 30px;
	}
	.paragraph{
		word-break: break-all;
	}

</style>
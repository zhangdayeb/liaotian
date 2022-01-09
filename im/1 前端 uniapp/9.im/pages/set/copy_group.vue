<template>
	<view class="page">
		
		<scroll-view class="scrollList" scroll-y :scroll-into-view="scrollViewId" :style="{height:winHeight + 'px'}">
			
			<view class="uni-list">
		
					<block v-for="(list, key) in list_data" :key="key">
						<view class="uni-list-cell-divider" :id="list.letter">
							{{list.letter}}
						</view>						
						
						<view class="uni-list-cell" 
						hover-class="none" 
						v-for="(item,index) of list.data"
						:class="list.data.length -1 == index ? 'uni-list-cell-last' : ''"
						:key="isKey(key,index)"
						>
						
							<checkbox-group @change="change">
								<label class="uni-list-cell uni-list-cell-pd">
									<view>
										<checkbox color="#02b300"
										:checked="current == item.user_id"
										:value="item.user_id + ''"
										/>
									</view>
									<view class="uni-media-list">
										<view class="uni-media-list-logo">
											<image :src="staticPhoto + item.photo" :lazy-load="true"/>
										</view>
										<view class="uni-media-list-body">
											<view class="uni-list-cell-navigate">{{item.name}}</view>
										</view>
									</view>
								</label>
							</checkbox-group>
							
						</view>
						
					</block>
			</view>
		</scroll-view>
		
		<view class="uni-indexed-list-bar" :class="touchmove ? 'active' : ''" @touchstart="touchStart" @touchmove="touchMove"
		 @touchend="touchEnd" @touchcancel="touchCancel" :style="{height:winHeight + 'px'}">
			<text v-for="(list,key) in list_data" :key="key" class="uni-indexed-list-text" :class="touchmoveIndex == key ? 'active' : ''"
			 :style="{height:itemHeight + 'px',lineHeight:itemHeight + 'px'}">
			 {{list.letter}}
			 </text>
		</view>
		
		<view class="uni-indexed-list-alert" v-if="touchmove"> 
			{{list_data[touchmoveIndex].letter}}
		</view>
		
	</view>
</template>

<script>
	
	import uniIcon from '../../components/uni-ui/uni-icon/uni-icon.vue';
	import uniList from '../../components/uni-ui/uni-list/uni-list.vue';
	import uniListItem from '../../components/uni-ui/uni-list-item/uni-list-item.vue';
	import _get from '../../common/_get';
	import _hook from '../../common/_hook';
	import _data from '../../common/_data';
	
	export default {
		components: {
			uniIcon,
			uniList,
			uniListItem,
		},
		data() {
			return {
				list_data: [],
				title: 'grid',
				touchmove: false,
				touchmoveIndex: -1,
				itemHeight: 0,
				winHeight: 0,
				scrollViewId: "A",
				titleHeight: 0,
				
				list_id: 0,
				add_user_ids: [],
				type: 0,
				current:0
			}
		},
		onShow(){
			_hook.routeTabBarHook();
		},
		onLoad(option) {
			let _this = this;
			_this.list_id = option.list_id;
			_this.type = option.type;
			if(_this.type == 2){
				uni.setNavigationBarTitle({
					title: '禁言设置',
				});
			}
			_this.$httpSend({
				path: '/im/vendor/getMemberData',
				data: { list_id: this.list_id,type: 1, },
				success(data) {
					_this.list_data = data.list;
					_this.add_user_ids = data.user_ids;
				}
			});
				
			let winHeight = uni.getSystemInfoSync().windowHeight;
			_this.itemHeight = winHeight / 26;
			_this.winHeight = winHeight;
		},
		computed: {
			staticPhoto(){
				return _data.staticPhoto();
			}
		},
		methods: {
			change(event){
				let indexObject = {};
				for (let i = 0; i < this.list_data.length; i++) {
					for (let j= 0 ;j <this.list_data[i].data.length;j++){
						console.log(this.list_data[i].data[j])
						if(this.list_data[i].data[j].user_id == event.target.value){
								this.current = event.target.value;
								break;
						}
					}
					// if (this.list_data[i].data[i].user_id === event.target.value) {

					// }
				}
			},
			isKey(key,index){
				return key + '' + index;
			},
			touchStart(e) {
				this.touchmove = true;
				let pageY = e.touches[0].pageY;
				let index = Math.floor((pageY - this.titleHeight) / this.itemHeight);
				let item = this.list_data[index];
				if (item) {
					this.scrollViewId = item.letter;
					this.touchmoveIndex = index;
				}
			},
			touchMove(e) {				
				let pageY = e.touches[0].pageY;
				let index = Math.floor((pageY - this.titleHeight) / this.itemHeight);
				let item = this.list_data[index];
				if (item) {
					this.scrollViewId = item.letter;
					this.touchmoveIndex = index;
				}
			},
			touchEnd() {
				this.touchmove = false;
				//this.touchmoveIndex = -1;
			},
			touchCancel() {
				this.touchmove = false;
				//this.touchmoveIndex = -1;
			},
		},
		watch: {
			
		},
		onNavigationBarButtonTap(e) {
			let _this = this;
			let trans_user_id = _this.current[0];
			//转让群
			if(!trans_user_id){
				return uni.showToast({
					title:'请选择群主',
					icon:'none',
					duration:2000,
				})
			}
			uni.navigateTo({url:'../set/copy_tips?main_id='+trans_user_id+'&list_id='+_this.list_id})
			// _this.$httpSend({
			// 	path: '/im/vendor/copyNewQun',
			// 	data: { trans_user_id: trans_user_id,list_id: _this.list_id },
			// 	success_action: true,
			// 	success(res) {
			// 		uni.showToast({
			// 			title: res.msg,
			// 			duration: 2000
			// 		});
			// 		setTimeout(() => {
			// 			uni.redirectTo({
			// 				url: '../chat/message/more?list_id=' + _this.list_id,
			// 			});
			// 		},2000);
			// 	}
			// });
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
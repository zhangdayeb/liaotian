<template>
	<view class="page">
		<uni-search-bar placeholder="搜索"  :show="false"  @confirm="search"></uni-search-bar>
		<view class="content">
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

							<checkbox-group @change="change(item.user_id + '')" >
								<label class="uni-list-cell uni-list-cell-pd">
									<view>
										<checkbox color="#02b300"
												  :checked="item.other"
												  :disabled="item.other"
												  :value="item.user_id + ''"
										/>
									</view>
									<view class="uni-media-list">
										<view class="uni-media-list-logo">
											<image  :data-index="index" :src="staticPhoto + item.photo" :lazy-load="true" style="border-radius: 10px;" @error="imageError"  />
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

			<view class="uni-indexed-list-bar" :class="touchmove ? 'active' : ''"
			@touchstart="touchStart"
			@touchmove.stop.prevent="touchMove"
			@touchend="touchEnd"
			@touchcancel="touchCancel"
			:style="{height:winHeight + 'px'}">
			<text v-for="(list,key) in list_data" :key="key" class="uni-indexed-list-text" :class="touchmoveIndex == key ? 'active' : ''"
			:style="{height:itemHeight + 'px',lineHeight:itemHeight + 'px'}">
			{{list.letter}}
			</text>
			</view>

			<view class="uni-indexed-list-alert" v-if="touchmove">
			{{list_data[touchmoveIndex].letter}}
			</view>
		</view>

		
	</view>
</template>

<script>
	
	import uniIcon from '../../../components/uni-ui/uni-icon/uni-icon.vue';
	import uniList from '../../../components/uni-ui/uni-list/uni-list.vue';
	import uniListItem from '../../../components/uni-ui/uni-list-item/uni-list-item.vue';
	import _get from '../../../common/_get';
	import _hook from '../../../common/_hook';
	import _data from '../../../common/_data';
	import uniSearchBar from '@/components/mehaotian-search/mehaotian-search.vue'

	export default {
		components: {
			uniIcon,
			uniList,
			uniListItem,
			uniSearchBar
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
			}
		},
		onShow(){
			_hook.routeTabBarHook();
		},
		onLoad(option) {
			let _this = this,
			friend_list = _data.localData('friend_list'),		
			send_data = { list_id: option.list_id,friend: 1 };
			_this.list_id = option.list_id;
			
			/** 这里初始化好友列表 */
			if(!friend_list){
				send_data.friend = 1;
			}
			
			_get.getFriendList(send_data,(data) => {
				let data_list = _data.localData('friend_list');
				let len = data_list.length || Object.keys(data_list).length;
				console.log(data_list)
				for(let i in data_list ){
					for(let k = 0,o = data_list[i].data,l = o.length;k < l;k ++){
						o[k].other = false;
					}
					_this.list_data.push(data_list[i]);
				}
			});
				
			let winHeight = uni.getSystemInfoSync().windowHeight;
			_this.itemHeight = winHeight / 26;
			_this.winHeight = winHeight;
		},
		computed: {
			staticPhoto(){
				return _data.staticPhoto();
			},
			imgRan(){
				return Math.random();
			},
		},
		methods: {
			imageError(e){
				console.log("图片加载失败!",e.detail);
				let index = e.currentTarget.dataset.index
				console.log(e.currentTarget.dataset.index)
				//替换index对应的图片
				console.log(this.list[index].photo_path)
				this.list[index].photo_path = '/default_photo_path.png';
			},
			change(user_id){
				if(user_id){
					let i = this.add_user_ids.indexOf(user_id);
					if(i > -1){
						this.add_user_ids.splice(i,1);
						this.list_data
					}else{
						this.add_user_ids.push(user_id);
					}
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
			if(_this.add_user_ids.length){
				let path =  '/im/message/sendCard';
				_get.sendCard({ users: JSON.stringify(_this.add_user_ids),list_id: _this.list_id},function () {
					uni.redirectTo({
						url: '../message?list_id=' + _this.list_id,
					});
				})
			}else{
				uni.redirectTo({
					url: '../message?list_id=' + _this.list_id,
				});
			}
		}
	}
</script>

<style>
	.page .content{
		display: flex;
		flex-direction:row;
	}
	.page {
		/*display: flex;*/
		/*flex-direction:row;*/
		background-color: white;
	}
	
	.scrollList {
		flex: 1;
		height: 100vh;
		margin-top: 20upx;
		width: 100%;
	}

	.uni-indexed-list-bar {
		width: 40upx;
		height: 100vh;
		background-color: white;
		display: flex;
		flex-direction: column;
		z-index: 20;
	}
	.uni-list-cell-divider{
		background-color: #e5e5e5;
		padding: 4upx 18px !important;
	}
	.uni-indexed-list-bar.active {
		/* background-color: rgb(200, 200, 200); */
	}
	.uni-list-cell-pd{
		padding: 0 12px !important;
	}
	.uni-media-list{
		padding: 4px 8px !important;
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
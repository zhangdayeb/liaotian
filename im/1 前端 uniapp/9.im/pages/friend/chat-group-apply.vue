<template>
	<view class="page">
		
		<uni-list v-if="friend_apply_list.length">
			<view v-for="(value,key) in friend_apply_list" :key="key">
				<view class="uni-media-list btm_border">
					<view class="uni-media-list-logo">
				    	<image :src="staticPhoto + value.photo" class="img-icon" />
				    	
				    </view>
				    <view class="uni-media-list-body">
				    	<view class="uni-list-cell-navigate">{{value.nickname}}</view>
						<view class="uni-list-cell-navigate content">{{value.content}}</view>
				    </view>
					<view style="position: relative;">
						<block v-if="value.status == 0">
							<view class="badge-text" 
							style="background-color:#09BB07;color:#FFFFFF;position:absolute;top: 20upx;right: 0;width:50upx;text-align: center;"
							@tap="groupAdd(value.id + '')"
							>
								<text>接受</text>
							</view>
						</block>
						<block v-else>
							<view class="badge-text" 
							style="background-color:#f1f1f1;color:#333;position:absolute;top: 20upx;right: 0;width:80upx;text-align: center;"
							>
								<text>{{value.text}}</text>
							</view>
						</block>
						
					</view>
				</view>	
			</view>
		</uni-list>		
		<uni-load-more status="noMore" v-if="noMore"/>
	</view>
</template>

<script>
	
	import uniList from '../../components/uni-ui/uni-list/uni-list.vue';
	import uniListItem from '../../components/uni-ui/uni-list-item/uni-list-item.vue';
	import uniLoadMore from "../../components/uni-ui/uni-load-more/uni-load-more.vue";
	import _get from '../../common/_get';
	import _hook from '../../common/_hook';
	import _data from '../../common/_data';
	
	export default {
		components: {
			uniList,
			uniListItem,
			uniLoadMore,
		},
		data() {
			return {
				noMore: 0,
				friend_apply_list: [],
			}
		},
		onShow(){
			_hook.routeSonHook();
			
			let friend_apply_list = _data.localData('group_apply_list'),
				_this = this;
				
			/** 监听最新数据 */
			uni.$on('data_group_apply_data',function(data){
				_this.friend_apply_list = data;
			});

			/** 加载本地缓存数据,如果有新的朋友申请,更新本地数据 */
			if(friend_apply_list && _this.action == 0){
				_this.friend_apply_list = friend_apply_list;
			}else{
				_get.getGroupApplyList((data) => {
					if(data.length < 1){
						_this.noMore = 1;
					}
				});
			}
		},
		onLoad() {
			
		},
		onUnload(){
			uni.$off('data_group_apply_list');
		},
		computed: {
			staticPhoto(){
				return _data.staticPhoto();
			},
		},
		methods: {
			groupAdd(id){
				let _this = this;
				if(id){
					_this.$httpSend({
						path: '/im/message/addGroupAllow',
						data: { id },
					});
				}
			}
		},
		watch: {
			
		},
	}
</script>

<style>
	.img-icon{
		width:90upx;
		height: 90upx;
		border-radius: 10upx;
	}
	.uni-list-cell-navigate {
		padding: 0;
	}
	.content{
		color:#7D7D72;
		font-size: 28upx;
	}
	.badge-text{
		background-color: #EEEEEE;
		padding: 3upx  10upx 0 10upx;
		border-radius: 15upx;
		font-size: 22upx;
	}
	.btm_border{
		border-bottom: solid 1upx #E7E7E7 ;
	}
</style>
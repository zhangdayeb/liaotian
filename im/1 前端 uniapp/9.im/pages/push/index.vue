<template>
	<view class="page">
		
		<uni-list>
			<uni-list-item title="朋友圈" 
						   :show-arrow="true"
						   :show-badge="true"
						   badge-type="error"
						   :badge-text="show_tips"
						   thumb="../../static/theme/default/push/circle.png"
						   @click="goPath('circle')"
						   />
						   
		</uni-list>
		
		<uni-list>
			<uni-list-item title="游戏" 
						   :show-arrow="true"
						   thumb="../../static/theme/default/push/game.png"
						   @click="goPath('game')"
						   />
						   
		</uni-list>
		
		<uni-list v-if="1">
			<uni-list-item title="扫一扫" 
						   :show-arrow="true"
						   thumb="../../static/theme/default/push/scan.png"
						   />						   
		</uni-list>
		
		<uni-list v-if="1">
			<uni-list-item title="看一看" 
						   :show-arrow="true"
						   thumb="../../static/theme/default/push/see.png"
						   />
			<uni-list-item title="搜一搜" 
						   :show-arrow="true"
						   thumb="../../static/theme/default/push/search.png"
						   />		
		</uni-list>
		
		<uni-list v-if="1">
			<uni-list-item title="小程序" 
						   :show-arrow="true"
						   thumb="../../static/theme/default/push/program.png"
						   />
		</uni-list>
		
	</view>
</template>

<script>
	
	import uniList from '../../components/uni-ui/uni-list/uni-list.vue';
	import uniListItem from '../../components/uni-ui/uni-list-item/uni-list-item.vue';
	import _get from '../../common/_get';
	import _hook from '../../common/_hook';
	import _data from '../../common/_data';
	
	export default {
		components: {
			uniList,
			uniListItem,
		},
		data() {
			return {
				show_tips: '',
			}
		},
		onShow(){
			_hook.routeTabBarHook();
			let num = _data.data('no_reader_circle_chat_num'),
			_this = this;
			if(num){
				this.show_tips = num;
			}
			else if(_data.data('no_reader_circle')){
				this.show_tips = '好友动态';
			}
			else {
				this.show_tips = '';
			}
			/** 监听朋友圈动态提示 */
			uni.$on('data_circle_tips',function(data){
				_this.show_tips = data;
			});
		},
		onLoad() {
			
		},
		onUnload(){
			uni.$off('data_circle_tips');
		},
		computed: {
			
		},
		methods: {
			goPath(path){
				if(path){
					uni.navigateTo({
						url: path
					});
				}
			},
		},
	}
</script>

<style>
	
	.uni-list {
		margin-bottom: 30upx;
	}
	
</style>

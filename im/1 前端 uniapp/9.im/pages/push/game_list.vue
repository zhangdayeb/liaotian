<template>
	
	<view class="page">
		<view class="uni-list">
				
		    <block>	
				<uni-list>
					<view class="header">
						 <text>我的游戏</text>
					</view>
				</uni-list>
			
				<uni-list>
					<uni-list-item title="博彩"
								   :show-arrow="false"
								   :show-badge="true"
								   :badge-text="newFriend"
								   badge-type="error"
								   thumb="../../static/theme/default/friend/new.png"
								   @click="goPath('game_site')"
								   />
					<uni-list-item title="棋牌"
								   :show-arrow="false"
								   :show-badge="true"
								   :badge-text="newFriend"
								   badge-type="error"
								   thumb="../../static/theme/default/friend/new.png"
								   @click="goPath('game_site')"
								   />			   
				</uni-list>	
		   </block>	
		 </view>
	</view>
</template>

<script>
	
	import uniList from '../../components/uni-ui/uni-list/uni-list.vue';
	import uniListItem from '../../components/uni-ui/uni-list-item/uni-list-item.vue';
	import _get from '../../common/_get';
	import _hook from '../../common/_hook';
	
	export default {
		components: {
			uniList,
			uniListItem
		},
		data() {
			return {
			}
		},
		onShow(){
			_hook.routeTabBarHook();
		},
		onLoad() {
			
		},
		computed: {
			showTips(){
				if(this.$store.state.no_reader_circle_chat_num){
					return this.$store.state.no_reader_circle_chat_num;
				}
				if(this.$store.state.no_reader_circle){
					return ' ';
				}
				return '';
			},
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

<style scoped>
	html,body,#iframe{
            padding:0;
            margin:0;
            width:100%;
            height:100%
    }
	uni-page-body, uni-page-refresh {
    display: block;
    box-sizing: border-box;
    width: 100%;
    height: 100%;
   }
   .page {
   	display: flex;
   	flex-direction:row;
   }
	#iframe{
	        border:0;
	}
	.uni-list {
		margin-bottom: 30upx;
	}
	.header {
		display: flex;
		flex-direction: row;
		padding: 10px 15px;
		align-items: center;
	}
</style>

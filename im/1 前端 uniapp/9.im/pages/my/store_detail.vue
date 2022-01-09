<template>
	<view class="page">
		<view class="page-header">
			<cmd-circle cid="circle10" width="100" class="page-header-circle" type="circle" :percent="percent" stroke-color="#ff5722" stroke-background="#d6d6d6"></cmd-circle>
			<view class="page-header-info" v-if="type==1">
				<view>已收藏数据：{{info.user_storge}}</view>
				<view>剩余收藏空间：{{info.splus_storge}}</view>
			</view>
			<view class="page-header-info" v-else>
				<view>已收藏个数：{{info.user_storge_count}}个</view>
				<view>剩余收藏个数：{{info.splus_count}}个</view>
			</view>
		</view>
		<view class="page-content">
			<view class="page-list" v-if="type == 1">
				<view class="page-item">
					<view>视频</view>
					<view>{{list.s4}}</view>
				</view>
				<view class="footer-hr"></view>
				<view class="page-item">
					<view>语音</view>
					<view>{{list.s3}}</view>
				</view>
				<view class="footer-hr"></view>
				<view class="page-item">
					<view>图片</view>
					<view>{{list.s2}}</view>
				</view>
				<view class="footer-hr"></view>
				<view class="page-item">
					<view>文字</view>
					<view>{{list.s1}}</view>
				</view>
				<view class="footer-hr"></view>
			</view>
			<view class="page-list" v-if="type == 2">
				<view class="page-item">
					<view>视频</view>
					<view>{{list.c4}}个</view>
				</view>
				<view class="footer-hr"></view>
				<view class="page-item">
					<view>语音</view>
					<view>{{list.c3}}个</view>
				</view>
				<view class="footer-hr"></view>
				<view class="page-item">
					<view>图片</view>
					<view>{{list.c2}}个</view>
				</view>
				<view class="footer-hr"></view>
				<view class="page-item">
					<view>文字</view>
					<view>{{list.c1}}个</view>
				</view>
				<view class="footer-hr"></view>
			</view>
		</view>
		<view class="page-footer">
			<view class="page-footer-item" :class="type == 1 ? 'active' : ''" @tap="getItem(1)">
				<view  class="item">
					<image src="/static/theme/default/liuyan.png"></image>
					<view>收藏空间</view>
				</view>

			</view>
			<view class="page-footer-item" :class="type == 2 ? 'active' : ''" @tap="getItem(2)">
				<view class="item">
					<image src="/static/theme/default/tongxunlu.png"></image>
					<view>收藏个数</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import cmdCircle from "@/components/cmd-circle/cmd-circle.vue";
    import _get from "../../common/_get";
	export default {
		data() {
			return {
				type:1,
                info:   {
                    splus_count: 0,
                    splus_storge: 0,
                    rate_1: 0,
                    rate_2: 0,
                    user_storge: 0,
                    user_storge_count: 8,
                },
                list:{
				    c1:0,
				    c2:0,
				    c3:0,
				    c4:0,
				    s1:0,
				    s2:0,
				    s3:0,
				    s4:0,
                }
			}
		},
		components: {cmdCircle},
        onShow(){
            let _this = this;
            _get.getStoreStatics({},function (ret) {
                _this.info = ret.info;
                _this.list = ret.list
            });
        },
        onLoad(){

        },
        computed:{
            percent(){
               return this.type == 1 ? this.info.rate_1 : this.info.rate_2;
            }
        },
		methods: {
			getItem(type){
				return this.type = type
			}
		}
	}
</script>

<style>
page{
	background-color: #efefef;
}
.page-header{
	display: flex;
	justify-content:center;
	padding: 10px 10px 30px;
}

.page-header-info{
	display: flex;
	flex-direction: column;
	justify-content: center;
	text-align: left;
	margin-left: 5px;
	color: #a2a2a2;
}
.page-list{
	display: flex;
	flex-direction: column;
}
.page-item{
	display: flex;
	justify-content: space-between;
	padding: 30px 40px;
}
.footer-hr{
	height: 1upx;
	width: 90%;
	background-color: #e1e1e1;
	margin: 0 auto;
}
.page-footer{
	height: 150upx;
	border-top: 1px solid #d3cdcd;
	position: fixed;
	display: flex;
	justify-content: space-between;
	bottom: 0;
	left: 0;
	right: 0;
	background: #ffffff;
}
.page-footer-item{
	width: 50%;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
}
.page-footer-item image{
	height: 30px;
	width: 30px;
}
.page-footer .active .item{
	border-top: 2px solid red;
}
.item{
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	height: 100%;
}
</style>

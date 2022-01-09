<template>
	<view class="page">
		<rich-text :nodes="info.content ? getHtml(info.content) : ''"  space="true" selectable="true"/>
	</view>
</template>

<script>
	import htmlParser from '../../common/html-parser';
	import _get from '../../common/_get';
	export default {
		components: {

		},
		data() {
			return {
				id:0,
				info: {
					content:''
				}, // 页面数据
				noData: '<p style="text-align:center;color:#666">详情加载中...</p>',
			}
		},
		onLoad(options) {
			// 初始化页面数据
			if('id' in options){
				this.id = options.id
			}
			this.getDetail();
		},
		methods: {
			/**
			 * 请求页面数据
			 */
			getDetail(){
				let _this = this;
				_get.getArticleDetail({article_id:this.id},function (ret) {
					_this.info = ret;
					uni.setNavigationBarTitle({
						title: ret.article_name,
					});

				});
			},
			getHtml(content){
				return htmlParser(content);
			},
		}
	}
</script>

<style>
.page image{
	max-width: 100%;
}
</style>

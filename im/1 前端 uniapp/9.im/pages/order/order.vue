<template>
	<view class="aui-flexView">
		<view class="aui-scrollView">
			<view class="aui-tab">
				<ul class="tab-nav">
					<block v-for="(menuTab,index) in menuTabs" :key="index">
						<li v-bind:id="'tabNum'+index" @click="swichMenu(index)" :class="[currentTab==index ? 'tab-nav-item tab-active' : 'tab-nav-item']">
							{{menuTab.name}}
						</li>
					</block>
				</ul>
				<view class="viewHeight"></view>
				<view class="tab-panel">
						<view :class="[currentTab==0 ? 'tab-panel-item tab-active' : 'tab-panel-item']">
                            <block v-for="(menuList2,index3) in menuLists" :key="index3">
								<view class="viewHeight"></view>
								<view class="tab-item">
									<view  class="aui-well-item aui-well-item-clear">
                                      <view class="aui-well-info">
                                          <view class="aui-well-item-hd">
                                              <image :src="staticPhoto + menuList2.seller_face" alt=""></image>
                                          </view>
                                          <view class="aui-well-item-bd">
                                              <view style="font-size: 16px;font-weight: 400">{{menuList2.seller_username}}</view>
                                          </view>
                                      </view>
                                        <view class="aui-well-title">
                                            <text class="aui-well-item-fr">{{menuList2.status_msg}}</text>
                                        </view>
									</view>
									<view class="aui-mail-product">
										<view class="aui-mail-product-item">
											<view class="aui-mail-product-item-hd">
                                                <image :src="menuList2.small_pic" alt=""></image>
											</view>
											<view class="aui-mail-product-item-bd">
												<view class="aui-mail-product-item-text">{{menuList2.goods_name}}</view>
											</view>
										</view>
									</view>
									<view  class="aui-mail-payment">
										<view>
												{{menuList2.is_buyer == 1 ? '买入单：' : '卖出单：'}}实付款: ￥{{menuList2.amount}}
										</view>
									</view>
									<view class="aui-mail-button">
										<!--<text  :class="[menuList2.but_ddshouhuo==0 ? 'hd' : menuList2.but_ddshouhuo==2 ? '' :'aui-df-color']">等待收货</text>-->
										<!--<text  :class="[menuList2.but_wuliu==0 ? 'hd' : menuList2.but_wuliu==2 ? '' :'aui-df-color']">查看物流</text>-->
										<text  @tap="goPath(menuList2)" class="aui-df-color">{{menuList2.is_buyer == 1  || menuList2.logistics_status != 1? '查看详情' : '去发货'}}</text>
										<!--<text  :class="[menuList2.but_pingjia==0 ? 'hd' : menuList2.but_pingjia==2 ? '' :'aui-df-color']">评价晒单</text>-->
										<!--<text :class="[menuList2.but_fapiao==0 ? 'hd' : menuList2.but_fapiao==2 ? '' :'aui-df-color']">查看发票</text>-->
										<!--<text  :class="[menuList2.but_zhifu==0 ? 'hd' : menuList2.but_zhifu==2 ? '' :'aui-df-color']">去支付</text>-->
									</view>
								</view>
								<view class="viewHeight"></view>
							</block>
						</view>
						<view :class="[currentTab==1 ? 'tab-panel-item tab-active' : 'tab-panel-item']">
                            <block v-for="(menuList2,index3) in menuLists" :key="index3">
								<view class="viewHeight"></view>
								<view class="tab-item">
									<view  class="aui-well-item aui-well-item-clear">
                                      <view class="aui-well-info">
                                          <view class="aui-well-item-hd">
                                              <image :src="staticPhoto + menuList2.seller_face" alt=""></image>
                                          </view>
                                          <view class="aui-well-item-bd">
                                              <view style="font-size: 16px;font-weight: 400">{{menuList2.seller_username}}</view>
                                          </view>
                                      </view>
                                        <view class="aui-well-title">
                                            <text class="aui-well-item-fr">{{menuList2.status_msg}}</text>
                                        </view>
									</view>
									<view class="aui-mail-product">
										<view class="aui-mail-product-item">
											<view class="aui-mail-product-item-hd">
                                                <image :src="menuList2.small_pic" alt=""></image>
											</view>
											<view class="aui-mail-product-item-bd">
												<view class="aui-mail-product-item-text">{{menuList2.goods_name}}</view>
											</view>
										</view>
									</view>
									<view  class="aui-mail-payment">
										<view>
												{{menuList2.is_buyer == 1 ? '买入单：' : '卖出单：'}}实付款: ￥{{menuList2.amount}}
										</view>
									</view>
									<view class="aui-mail-button">
										<!--<text  :class="[menuList2.but_ddshouhuo==0 ? 'hd' : menuList2.but_ddshouhuo==2 ? '' :'aui-df-color']">等待收货</text>-->
										<!--<text  :class="[menuList2.but_wuliu==0 ? 'hd' : menuList2.but_wuliu==2 ? '' :'aui-df-color']">查看物流</text>-->
										<text  @tap="goPath(menuList2)" class="aui-df-color">{{menuList2.is_buyer == 1  || menuList2.logistics_status != 1? '查看详情' : '去发货'}}</text>
										<!--<text  :class="[menuList2.but_pingjia==0 ? 'hd' : menuList2.but_pingjia==2 ? '' :'aui-df-color']">评价晒单</text>-->
										<!--<text :class="[menuList2.but_fapiao==0 ? 'hd' : menuList2.but_fapiao==2 ? '' :'aui-df-color']">查看发票</text>-->
										<!--<text  :class="[menuList2.but_zhifu==0 ? 'hd' : menuList2.but_zhifu==2 ? '' :'aui-df-color']">去支付</text>-->
									</view>
								</view>
								<view class="viewHeight"></view>
							</block>
						</view>
						<view :class="[currentTab==2 ? 'tab-panel-item tab-active' : 'tab-panel-item']">
                            <block v-for="(menuList2,index3) in menuLists" :key="index3">
								<view class="viewHeight"></view>
								<view class="tab-item">
									<view  class="aui-well-item aui-well-item-clear">
                                      <view class="aui-well-info">
                                          <view class="aui-well-item-hd">
                                              <image :src="staticPhoto + menuList2.seller_face" alt=""></image>
                                          </view>
                                          <view class="aui-well-item-bd">
                                              <view style="font-size: 16px;font-weight: 400">{{menuList2.seller_username}}</view>
                                          </view>
                                      </view>
                                        <view class="aui-well-title">
                                            <text class="aui-well-item-fr">{{menuList2.status_msg}}</text>
                                        </view>
									</view>
									<view class="aui-mail-product">
										<view class="aui-mail-product-item">
											<view class="aui-mail-product-item-hd">
                                                <image :src="menuList2.small_pic" alt=""></image>
											</view>
											<view class="aui-mail-product-item-bd">
												<view class="aui-mail-product-item-text">{{menuList2.goods_name}}</view>
											</view>
										</view>
									</view>
									<view  class="aui-mail-payment">
										<view>
												{{menuList2.is_buyer == 1 ? '买入单：' : '卖出单：'}}实付款: ￥{{menuList2.amount}}
										</view>
									</view>
									<view class="aui-mail-button">
										<!--<text  :class="[menuList2.but_ddshouhuo==0 ? 'hd' : menuList2.but_ddshouhuo==2 ? '' :'aui-df-color']">等待收货</text>-->
										<!--<text  :class="[menuList2.but_wuliu==0 ? 'hd' : menuList2.but_wuliu==2 ? '' :'aui-df-color']">查看物流</text>-->
										<text  @tap="goPath(menuList2)" class="aui-df-color">{{menuList2.is_buyer == 1  || menuList2.logistics_status != 1? '查看详情' : '去发货'}}</text>
										<!--<text  :class="[menuList2.but_pingjia==0 ? 'hd' : menuList2.but_pingjia==2 ? '' :'aui-df-color']">评价晒单</text>-->
										<!--<text :class="[menuList2.but_fapiao==0 ? 'hd' : menuList2.but_fapiao==2 ? '' :'aui-df-color']">查看发票</text>-->
										<!--<text  :class="[menuList2.but_zhifu==0 ? 'hd' : menuList2.but_zhifu==2 ? '' :'aui-df-color']">去支付</text>-->
									</view>
								</view>
								<view class="viewHeight"></view>
							</block>
						</view>

				</view>
			</view>
		</view>
	</view>
</template>

<script>
    import _get from '../../common/_get';
    import _hook from '../../common/_hook';
    import _data from '../../common/_data';
    import _page from '../../common/common';
	export default {
		data() {
			return {
				scrollLeft: 0,
				isClickChange: false,
				currentTab: 0,
                requestIndex:0,
				menuTabs: [
					{
						name: '全部',
						status:-1
					}, {
						name: '买入',
						status:1
					}, {
						name: '卖出',
						status:2
					}
				],
				menuLists: []
			}
		},
		onLoad() {
			// for (var i = 0; i < this.menuLists.length; i++) {
			// 	this.getDateList(i);
			// }
		},
        onShow(){
            _hook.routeSonHook();
            this.getUserOrderList();
        },
		computed:{
			staticPhoto(){
				return _data.staticPhoto();
			}
		},
		methods: {
			goPath(data){
				uni.navigateTo({
					url:"detail?"+_page.pageParam(data)
				})
			},
		    getUserOrderList(){
		    	let _this = this;
                _get.getUserOrderList({page:1,status:this.menuTabs[this.requestIndex].status},function (ret) {
                    let is_page = ret.is_page;
                    if(is_page)_this.menuLists = ret.data.data
						else _this.menuLists = ret.data;
                })
            },
			swichMenu: async function(current) { //点击其中一个选项
				if (this.currentTab == current) {
					return false;
				} else {
					this.currentTab = current;
					this.requestIndex = current
					this.getUserOrderList(this.requestIndex)
					this.setScrollLeft(current);
				}
			},
			swiperChange: async function(e) {
				let index = e.target.current;
				this.setScrollLeft(index);
				this.currentTab = index;
			},
			setScrollLeft: async function(tabIndex) {
				let leftWidthSum = 0;
				for (var i = 0; i <= tabIndex; i++) {
					let nowElement = await this.getWidth('tabNum' + i);
					leftWidthSum = leftWidthSum + nowElement.width;
				}
				let winWidth = uni.getSystemInfoSync().windowWidth;
				this.scrollLeft = leftWidthSum > winWidth ? (leftWidthSum - winWidth) : 0
			},
			getWidth: function(id) { //得到元素的宽高
				return new Promise((res, rej) => {
					uni.createSelectorQuery().select("#" + id).fields({
						size: true,
						scrollOffset: true
					}, (data) => {
						res(data);
					}).exec();
				})
			},
			getDateList: function(tabIndex) {
				// var entity = this.menuTabs[tabIndex].name;
				// this.menuLists[tabIndex].push(entity);
			},
		}
	}
</script>

<style>
	@import '/static/css/order/style.css';
</style>

<template>
    <view class="page">

        <view class=" my_padding">
            <!--<navigator url="/pages/my/details"-->
                       <!--hover-class="navigator-hover">-->
					   <div style="display: flex;" @tap="goPath('/pages/my/details')">
						   <view class="uni-media-list-logo phto">
						       <image :src="myPhoto"
						              :lazy-load="true"
						              style="border-radius: 10px;"/>
						   </view>
						   <view class="header-msg">
						       <view class="header-msg-bottom" style="font-weight: 400;font-size: 24px;color: black">{{my_data.nickname}}</view>
						       <view class="header-msg-top" style="font-weight: 400;font-size: 20px;">{{my_data.phone}}</view>
						   </view>
					   </div>
						<image class="header-erw" src="/static/theme/default/my/qrcode.png" :lazy-load="true" @tap="goPath('/pages/my/qrcode')"/>
							
           </view>
            <!--</navigator>-->

        

        <uni-list class="list" style="margin-top: 14px;">
            <uni-list-item title="我的零钱"
                           :showArrow="true"
                           :show-arrow="true"
						    badge-type="error"
                           thumb="../../static/theme/default/my/lingqian.png"
                           @click="goPath('./wallet/index')"/>
            <uni-list-item title="我的收藏"
                           :show-arrow="true"
                           :showArrow="true"
                           thumb="/static/theme/default/my_store.png"
                           @click="goPath('store')"/>
            <!--<uni-list-item title="插件中心"-->
                           <!--:showArrow="true"-->
                           <!--:show-arrow="true"-->
                           <!--:show-badge="true"-->
                           <!--badge-type="error"-->
                           <!--:badge-text="show_pay_tips"-->
                           <!--thumb="../../static/theme/default/my/chajian.png"-->
                           <!--@click="goPath('/pages/my/vendor')"/>-->
            <!--<uni-list-item title="扫一扫"-->
                           <!--:show-badge="true"-->
                           <!--:showArrow="true"-->
                           <!--badge-type="error"-->
                           <!--thumb="/static/theme/default/push/scan.png"-->
                           <!--@click="goScanCode"/>-->
            <uni-list-item title="联系客服"
                           :showArrow="true"
                           :show-arrow="true"
                           badge-type="error"
                           thumb="../../static/theme/default/kefu.png"
                           @click="goKefu" v-if="showKefu"/>
            <!-- <uni-list-item title="生活圈"
                           :show-badge="true"
                           :showArrow="true"
                           badge-type="error"
                           :badge-text="show_tips"
                           thumb="/static/theme/default/push/circle.png"
                           @click="goPath('../push/circle')"/> -->
            <uni-list-item title="我的动态"
                           :show-badge="true"
                           :showArrow="true"
                           badge-type="error"
                           :badge-text="show_tips"
                           thumb="../../static/theme/default/my/dongtai.png"
                           @click="goPath('../push/circle_user?user_id='+my_data.id)"/>

            <uni-list-item title="收款码"
                           :showArrow="true"
                           thumb="../../static/theme/default/my/qrcode.png"
                           @click="goPath('../my/pay/pay')" v-if="0"/>
		   <uni-list-item title="帮助中心"
						  :showArrow="true"
						  thumb="../../static/theme/default/help.png"
						  @click="goPath('../article/article')"/>

        </uni-list>


        <uni-list class="list" v-if="0">
            <uni-list-item title="小程序"
                           :show-arrow="true"
                           :showArrow="true"
                           thumb="../../static/theme/default/push/program.png"/>

            <uni-list-item title="相册"
                           :show-arrow="true"
                           :showArrow="true"
                           thumb="../../static/theme/default/my/images.png"
                           @click="goPath()"/>
            <uni-list-item title="实名"
                           :show-arrow="true"
                           :showArrow="true"
                           thumb="../../static/theme/default/my/real.png"
                           @click="goPath()"/>
            <uni-list-item title="表情"
                           :showArrow="true"
                           :show-arrow="true"
                           thumb="../../static/theme/default/my/emoji.png"
                           @click="goPath()"
            />
        </uni-list>

        <uni-list class="list" style="margin-bottom: 20px;margin-top: 14px;">

            <uni-list-item title="设置"
                           :show-arrow="true"
                           :showArrow="true"
                           thumb="../../static/theme/default/my/set.png"
                           @click="goPath('../set/index')"/>
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
            uniListItem
        },
        data() {
            return {
                my_data: {id: 0},
                show_tips: '',
				show_pay_tips:''
            }
        },
        onShow() {
            _hook.routeTabBarHook();
            let num = _data.data('no_reader_circle_chat_num'),
                _this = this;
            _this.my_data = _data.data('user_info');

            /** 监听新的个人数据 */
            uni.$on('data_user_info', function (data) {
                _this.my_data = data;
                console.log(_this.my_data)
            });
            /** 监听朋友圈动态提示 */
            // uni.$on('data_circle_tips', function (data) {
            //     _this.show_tips = data;
            // });
            // uni.$on('data_pay_tips',function (data) {
            //     _this.show_pay_tips = data;
            // })
            // if (num) {
            //     this.show_tips = num;
            // } else if (_data.data('no_reader_circle')) {
            //     this.show_tips = '好友动态';
            // } else {
            //     this.show_tips = '';
            // }
        },
        onLoad() {
			
        },
        onHide() {
            //uni.$off('data_user_info');
            uni.$off('data_circle_tips');
        },
        computed: {
            myPhoto() {
                return _data.staticPhoto() + this.my_data.photo;
            },
            showKefu(){
                return  this.my_data.id != 5880
            }
        },
        methods: {
            goPath(path) {
                console.log(1111)
                if (path) {
                    uni.navigateTo({
                        url: path,
                    });
                }
            },
            goKefu(){
              uni.navigateTo({'url':'/pages/chat/message?list_id='+_data.data('kefu_list_id')})
            },
            goScanCode () {
                // uni.navigateTo({
                //   url: '../chat/videoCall'
                // });
                let _this = this;
                uni.scanCode({
                    success: function (res) {
                        /** 验证必须是一个地址 */
                        if (/^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\*\+,;=.]+$/.test(res.result)) {
                            /** 本应用页面 */
                            console.log(res.result);
                            if (new RegExp(_data.data('http_url')).test(res.result)) {
                                if (res.result.match(/\/([a-z]+_[a-z]+)\/(.+)$/) && RegExp.$1 && RegExp.$2) {
                                    switch (RegExp.$1) {
                                        case 'chat_add':
                                            uni.navigateTo({
                                                url: '/page/details/index?user_id=' + RegExp.$2 + '&is_type=3',
                                            });
                                            break;
                                        case 'group_add':
                                            let option = (RegExp.$2 + '').split('&');
                                            _this.$httpSend({
                                                path: '/im/message/addChat',
                                                data: { users: option[1], list_id: option[0], type: 1, },
                                                success_action: true,
                                                success (res) {
                                                    let tips = res.err ? res.msg : '已经申请加入群聊,请耐心等待群管理审核';
                                                    uni.showModal({
                                                        content: tips,
                                                        showCancel: false,
                                                    });
                                                }
                                            });
                                            break;
                                        default:
                                            uni.showModal({
                                                content: '二维码内容：' + res.result,
                                                showCancel: false,
                                            });
                                            break;
                                    }
                                }
                                else {
                                    uni.showModal({
                                        content: '二维码内容：' + res.result,
                                        showCancel: false,
                                    });
                                }
                            }  /** 打开新地址 */
                            else {
                                uni.navigateTo({
                                    url: '../push/web?url=' + encodeURIComponent(res.result),
                                });
                            }
                        }
                        else {
                            uni.showModal({
                                content: '二维码内容：' + res.result,
                                showCancel: false,
                            });
                        }
                    },
                    fail (e) {
                        console.log(e);
                        return false;
                        return;
                        uni.showToast({
                            title: '扫码错误：' + JSON.stringify(e),
                            duration: 2000,
                        });
                    },
                });
            },
        },
        watch: {},
    }
</script>

<style>
    .iconfonts{
        position: absolute;
        right: 160rpx;
        bottom: 0px;
        font-size: 16px;
    }
    .header-msg{
		padding-left:10px;
    }
    .phto {
        width: 106upx;
        height: 106upx;
        margin-left: 30 upx;
        margin-right: 30 upx;
    }

    .list{
        margin-top: 10upx;
    }
    .qrcode {
        width: 50 upx;
        height: 50 upx;
        margin-right: -20 upx;
    }

    .my_padding {
		padding: 50px 15px 16px 15px;
		display: flex;
		background-color: #fff;
    }
    .uni-media-list-logo{
        padding: 2px;
        border-radius: 10px;
        height: 70px !important;
        width: 70px !important;
        margin-right: 0upx !important;
        margin-left: 0upx !important;
    }

    .my_padding:after {
		font-family: uniicons;
		content: '\e583';
		position: absolute;
		right: 15px;
		top: 15%;
		font-size: 24px;
		color: #bbb;
		-webkit-transform: translateY(-50%);
		transform: translateY(-50%);
	}
	.header-erw{
		position: absolute;
		right: 45px;
		top: 13%;
		font-size: 24px;
		width: 24px;
		height: 24px;
		z-index: 9999;
	}

    .uni-list {
        margin-bottom: 30 upx;
    }

    .uni-list-cell-navigate.uni-navigate-right:after{
        font-size: 20px !important;
    }
</style>

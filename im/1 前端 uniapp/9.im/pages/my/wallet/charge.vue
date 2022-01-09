<template>
    <view class="page">
        <view class="content">
            <view class="charge-head">
                <view class="charge-msg">
                    <text>充值金额</text>
                </view>
                <view class="charge-show">
                    <text>￥</text>
                </view>
                <view class="charge">
                    <input class="uni-input" type="number" placeholder-class="placeholder" :value="amount" focus placeholder="请输入充值金额" @input="doAmount"/>
                </view>
                <view class="charge-cell-list">
                    <view class="charge-item">
                        <view><text data-index="0" :class="setIndex == 0 ?  'active' : ''" @tap="selectTab">{{amount_arr[0]}}</text></view>
                        <view><text data-index="1" :class="setIndex == 1 ?  'active' : ''" @tap="selectTab">{{amount_arr[1]}}</text></view>
                        <view><text data-index="2" :class="setIndex == 2 ?  'active' : ''" @tap="selectTab">{{amount_arr[2]}}</text></view>
                    </view>
                    <view class="charge-item">
                        <view><text data-index="3" :class="setIndex == 3 ?  'active' : ''" @tap="selectTab">{{amount_arr[3]}}</text></view>
                        <view><text data-index="4" :class="setIndex == 4 ?  'active' : ''" @tap="selectTab">{{amount_arr[4]}}</text></view>
                        <view><text data-index="5" :class="setIndex == 5 ?  'active' : ''" @tap="selectTab">{{amount_arr[5]}}</text></view>
                    </view>
                </view>
            </view>
            <view class="charge-footer">
                <view class="msg">
                    <text>选择支付方式</text>
                </view>
                <view class="charge-channel">
                    <view class="chanel-img">
                        <view class="check-img">

                                <!--<label class="radio"  data-index="6" @tap="selectTab">-->
                                    <!--<radio value="6" :checked="(checked == 6) ? true : false"></radio>-->
                                    <!--<image src="../../../static/theme/default/my/weixin.png"></image>-->
                                    <!--<text>微信</text>-->
                                <!--</label>-->
                                <label class="radio" data-index="7" @tap="selectTab">
                                    <radio value="7" :checked="checked == 7 ? true : false"></radio>
                                    <image src="../../../static/theme/default/my/alipay.png"></image>
                                    <text>支付宝</text>
                                </label>
                        </view>
                    </view>
                    <button class="charge" type="button" @tap="charge">确认充值</button>
                </view>
            </view>
        </view>
    </view>
</template>

<script>
    import _get from '../../../common/_get';
    import _hook from '../../../common/_hook';
    import _data from '../../../common/_data';
    export default {
        data() {
            return {
                setIndex:1,
                checked :7,
                amount : 100,
                amount_arr:[100,200,300,400,500,600]
            }
        },
        onShow(){
            _hook.routeSonHook();
        },
        methods: {
            selectTab(e){
                let index = e.currentTarget.dataset.index;
                if(index == 6)return   uni.showToast({
                    title: '该支付通道暂未开放',
                    duration: 1000,
                    icon:"none"
                });
                if(index > 5)this.checked = index;
                    else {
                    this.setIndex = index;
                    this.amount = this.amount_arr[index];
                }
            },
            doAmount(e){
               this.amount = e.detail.value;
               console.log(this.amount)
            },
            charge(){
                //1支付宝 2微信
				console.log(this.amount)
                _get.charge({amount:this.amount,charge_type:1},function (ret) {
                    uni.requestPayment({
                        provider: 'alipay',
                        orderInfo: ret.orderInfo, //微信、支付宝订单数据
                        success: function (res) {
                            uni.showToast({
                                title: '支付成功',
                                duration: 1000,
                                icon:"none"
                            });
                        },
                        fail: function (err) {
                            console.log('fail:' + JSON.stringify(err));
                        }
                    });
                },function(ret){
					uni.showToast({
						title:ret.msg,
						duration:1000,
						icon:'none'
					})
				});
                //微信和支付宝待
                //#ifdef APP-PLUS
                if(this.amount <= 0){
                    uni.showToast({
                        title: '请输入金额',
                        duration: 1000,
                        icon:"none"
                    });
                }
                //1支付宝 2微信
                // uni.request({
                //     url:_data.data('http_url') + '/im/pay/userCharge',
                //     data:{amount:this.amount,charge_type:1},
                //     header:{
                //         /** 这里设置为简单跨域，只会请求一次 */
                //         'Content-Type': 'application/x-www-form-urlencoded',
                //     },
                //     method:'POST',
                //     success:function (res) {
                //        console.log(res)
                //     }
                // })
                // _get.charge({amount:this.amount,charge_type:1},function (ret) {
				// 	console.log(ret);
                //     uni.requestPayment({
                //         provider: 'alipay',
                //         orderInfo: ret, //微信、支付宝订单数据
                //         success: function (res) {
                //             console.log('success:' + JSON.stringify(res));
                //         },
                //         fail: function (err) {
                //             console.log('fail:' + JSON.stringify(err));
                //         }
                //     });
                // });
                //#endif

            }
        }
    }
</script>

<style>
    .radio{
        position: relative;
    }
    .radio image{
        position: absolute;
        top: -4px;
    }
    .radio text{
        margin-left: 50px;
    }
    .content {
        display: flex;
        flex-direction: column;
        height: 100%;
		max-width: 100%;
    }
    .check-img{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 34px 37px;
		
    }
    .check-img image{
        width: 80upx;
        height: 80upx;
    }
    .charge-footer .msg{
        height: 100upx;
        line-height: 100upx;
        width: 100%;
        color: #aeaeb0;
        margin-left: 10%;
        font-size: 14px;
    }
    .charge-footer{
        padding-bottom: 80upx;
    }
    .charge-footer .charge-channel{
        background-color: white;
        padding-bottom: 180upx;
    }
    .charge-footer .charge{
        width: 90%;
        background-color: #5693ee;
        color: white;
        height: 80upx;
        line-height: 80upx;
        border-radius: 50upx;
        font-size: 16px;
    }
    .charge-footer{
        background-color: #eeeef0;
    }
    .content .charge-head{
        padding: 15upx 60upx;
        background-color: white;
    }
    .content  .charge-show{
        margin-top: 20upx;
    }
    .content .charge-head .charge input{
        padding-left: 0px !important;
        font-size: 20px;
    }
    .content .charge-head .charge{
        margin: 10upx 0;
    }
    .content .charge-msg {
        color: #a8a8a8;
    }
    .content .charge-head .charge-cell-list{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .content .charge-head .charge-cell-list .charge-item{
        display: flex;
        flex-direction: row;
    }
    .charge-cell-list .charge-item view{
        display: flex;
        flex: 1;
        padding: 10upx;
    }
    .charge-cell-list .charge-item view text{
        border: 1px solid #6f6f6f;
        border-radius: 6px;
        padding: 7upx;
        width: 77px;
        height: 32px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
    }
    .placeholder{
        font-size: 20px;
    }
    .charge-item .active{
        background-color: #5693ee;
        color: white;
    }

</style>

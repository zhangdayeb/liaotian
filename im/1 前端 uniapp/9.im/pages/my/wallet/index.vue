<template>
    <view class="page">
        <view class="content">
            <view class="img">
                <image src="../../../static/theme/default/my/wallet.png" :lazy-load="true"/>
                <text class="msg">￥{{my_data.money?my_data.money:0.00}}</text>
            </view>
            <button class="withdraw" type="button" @tap="goPath('charge')">充值</button>
            <button class="withdraw charge" type="button" @tap="goPath('withdraw')">提现</button>
            <uni-list class="list">
                <uni-list-item title="我的账单"
                               :show-arrow="true"
                               :showArrow="true"
                               thumb="../../../static/theme/default/my/capital.png"
                               @click="goPath('capital2')"/>
                <uni-list-item title="我的红包记录"
                               :show-arrow="true"
                               :showArrow="true"
                               thumb="../../../static/theme/default/my/hongbao2.png"
                               @click="goPath('capital?type=hongbao')"/>
                <uni-list-item title="提现渠道设置"
                               :show-arrow="true"
                               :showArrow="true"
                               thumb="../../../static/theme/default/my/alipay.png"
                               @click="goPath('alipay_set')"/>
                <uni-list-item title="支付密码管理"
                               :show-arrow="true"
                               :showArrow="true"
                               thumb="../../../static/theme/default/my/pay_password.png"
                               @click="goPath('trade_password')"/>
            </uni-list>
        </view>
    </view>
</template>
<style>
    .content{
        display: flex;
        flex-direction: column;
    }
    .img{
        display: flex;;
        height: 440upx;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #5693ee;
        width: 100%;
    }
    .img image{
        width: 140upx;
        height: 150upx;
    }
    .img text{
        color: white;
        font-size: 20px;
    }
    .content .withdraw{
        width: 95%;
        background-color: #5693ee;
        color: white;
        margin-top: 10upx;
        height: 80upx;
        line-height:  80upx !important;
        font-size: 36upx;
        cursor: pointer;
    }
    .content .charge{
        background-color: white;
        color: #5693ee;
        border: 1px solid #5693ee;
    }
    .content .list{
        margin-top: 20upx;
    }
    .uni-page-head{
        box-sizing: content-box !important;
    }
</style>
<script>
    import uniList from '../../../components/uni-ui/uni-list/uni-list.vue';
    import uniListItem from '../../../components/uni-ui/uni-list-item/uni-list-item.vue';
    import _hook from '../../../common/_hook';
    import _data from '../../../common/_data';
    import _get from '../../../common/_get';

    export default {
        components: {
            uniList,
            uniListItem,
        },
        data() {
            return {
                my_data:{},
            }
        },
        onShow(){
            _hook.routeTabBarHook();
            let _this = this;
            /** 监听新的个人数据 */
            _get.getUserInfo({});
            uni.$on('data_user_info',function(data){
                _this.my_data = data;
                console.log('更新用户数据....')
                _data.data('user_info',data)
            });
            _this.my_data = _data.data('user_info');
            console.log(_this.my_data)
        },
        onLoad() {

        },
        onUnload(){
        },
        computed: {
        },
        methods: {
            goPath(path){
                if (path) {
                    uni.navigateTo({
                        url: path,
                    });
                }
            },
        },
        watch: {

        },
    }
</script>
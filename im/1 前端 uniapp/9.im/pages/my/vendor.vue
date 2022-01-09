<template>
    <view class="page">
        <view class="grid">
            <view class="grid-title">
                <text>安装插件</text>
            </view>
            <view class="grid-title-hr"></view>
        <view class="grid-content">
            <view class="grid-item" v-for="(item, index) in gridList" :key="index" @click="gridClick(item, index)">
                <image :src="item.imgUrl" class="grid-item-img"></image>
                <view style="text-align: center">
                    <view v-text="item.name" class="grid-item-text"></view>
                </view>
                <view>
                    <button type="primary" @tap="installApp" class="button-buy" plain="true">安装</button>
                </view>
            </view>
        </view>

        </view>
        <view class="grid">
            <view class="grid-title">
                <text>我的插件</text>
            </view>
            <view class="grid-title-hr"></view>
                <view class="warp">
                    <view class="box">
                        <!--<view class="title">我的插件群聊</view>-->
                        <t-table border="2" border-color="#95b99e" :is-check="false" @change="change">
                            <t-tr font-size="center" color="#95b99e" align="left">
                                <t-th align="center">群昵称</t-th>
                                <t-th align="center">机器人数</t-th>
                                <t-th align="center">到期时间</t-th>
                                <t-th align="center">操作</t-th>
                            </t-tr>
                            <t-tr font-size="12" color="#5d6f61" align="right" v-for="item in tableList" :key="item.id">
                                <t-td align="center">{{ item.group_name }}</t-td>
                                <t-td align="center">{{ item.robot_count }}<button @click="robotList(item)" class="edit-but-robot">详情</button></t-td>
                                <t-td align="center">{{ item.expire_time }}</t-td>
                                <t-td align="left">
                                    <button @click="goPath(item)" class="edit-but">设置</button>
                                </t-td>
                            </t-tr>
                        </t-table>
                    </view>
                </view>
            <!--<view class="grid-content" v-if="myGridList.length">-->
                <!--<view class="grid-item" v-for="(item, index) in myGridList" :key="index">-->
                    <!--<image :src="imgUrl" class="grid-item-img"></image>-->
                    <!--<view style="text-align: center">-->
                        <!--<view v-text="item.group_name" class="grid-item-text"></view>-->
                    <!--</view>-->
                    <!--<view>-->
                        <!--<button type="primary"  class="button-buy" plain="true" @tap="goPath(item)">插件设置</button>-->
                    <!--</view>-->
                <!--</view>-->
            <!--</view>-->

        </view>
        <uni-popup ref="popup" type="confirm">
            <uni-popup-confirm title="温馨提示" :content="popuMsg" @confirm = "confirm"> </uni-popup-confirm>
        </uni-popup>
    </view>

</template>

<script>
    import uniPopup from '../../components/uni-popup/uni-popup.vue';
    import uniPopupConfirm from '../../components/uni-popup/uni-popup-confirm.vue';
    import _get from '../../common/_get';
    import tTable from '@/components/t-table/t-table.vue';
    import tTh from '@/components/t-table/t-th.vue';
    import tTr from '@/components/t-table/t-tr.vue';
    import tTd from '@/components/t-table/t-td.vue';
    export default {
        data() {
            return {
                col: 3,
                showTip: false,
                gridList: [
                    {
                        name: "多雷红包",
                        imgUrl: "/static/theme/default//my/hongbao.png",
                    }
                ],
                myGridList: [
                    {
                    }
                ],
                popuMsg:'请联系客服,后台开通插件',
                imgUrl:'/static/theme/default//my/hongbao.png',
                url:"/pages/my/hongbao_setting",
                tableList: [
                ]
            };
        },
        components:{
            uniPopup,
            uniPopupConfirm,
            tTable,
            tTh,
            tTr,
            tTd
        },
        onShow(){
            let _this = this;
            _get.getUserVendor({},function (ret) {
                _this.tableList = ret
            });
        },
        methods: {
            gridClick(item, index) {	//格子菜单点击事件
                console.log(item);
                console.log(index);
            },
            goPath(item){
                let url = '/pages/my/hongbao_setting';
                uni.navigateTo({
                    url:url+'?id='+item.id
                });
            },
            installApp(){
                this.$refs.popup.open();
            },
            confirm(){
                this.$refs.popup.close();
            },
            robotList(item){
                let url = '/pages/vendor/robot_list';
                uni.navigateTo({
                    url:url+'?id='+item.id
                });
            }
        }
    }
</script>

<style>
    .page{
        padding-top: 60rpx;
    }
    .warp{
        margin-top: 20px;
    }
    .grid-title{
        padding-left: 15px;
        padding: 15px;
        font-size: 16px;
        font-weight: 400;
    }
    .grid-title-hr{
        display: flex;
        width: 90%;
        justify-content: center;
        align-items: center;
        text-align: center;
        border:1upx solid #bfbaba;
        margin-left: 15px;
        margin-top: 5px;
    }
    .edit-but-robot{
        background: #7c76f1;
        border-radius: 5px;
        color: white;
        font-size: 10px;
        line-height: 2 !important;
    }
    .edit-but{
        background: #7c76f1;
        border-radius: 5px;
        color: white;
        font-size: 12px;
    }
    .grid {
        display: flex;
        flex-direction: column;
    }
    .grid-item-img{
        width: 150rpx;
        height: 150rpx;
    }
    .grid-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 30%;
        padding: 30rpx 0rpx 20rpx 60rpx;
    }
    .grid-item-text{
        font-size: 16px;
        margin-top: 10rpx;
        width: 100%;
    }
    .grid-content{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;

    }
    .button-buy{
        height: 30px !important;
        line-height: unset !important;
        line-height: 30px !important;
        background-color: #5693ee !important;
        color: white !important;
        margin-top: 10rpx;
    }
</style>

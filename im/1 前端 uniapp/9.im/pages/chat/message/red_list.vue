<template>
  <view class="page">
    <view class="whb-list" v-if="dataList.length">
      <view class="whb-item"  v-for="item in dataList" :key="item.id">
        <view class="whb-item-header">
          <image class="user-img" :src="staticPhoto + item.user_info.face"/>
        </view>
        <view class="whb-item-center">
          <view class="name">{{item.user_info.nickname}}</view>
          <view class="title">{{item.msg}}</view>
          <view class="whb-kai1" @tap="openRedEnvelope(item)">
            开
          </view>
        </view>
      </view>
    </view>
    <view v-else class="whb-none">
      <image src="/static/theme/default/no-get.png"></image>
      <view>暂时没有未领红包</view>
      <view>超过10分钟未领完的红包在此展示</view>
    </view>

    <!-- 红包弹窗 -->
    <view class="windows" :class="windowsState">
      <!-- 遮罩层 -->
      <view class="mask" @touchmove.stop.prevent="discard" @tap="closeRedEnvelope"></view>
      <view class="layer" @touchmove.stop.prevent="discard">
        <view class="open-redenvelope">
          <view class="top">
            <view class="close-btn">
              <view class="icon close" @tap="closeRedEnvelope"></view>
            </view>
            <image :src="staticPhoto+redenvelopeData.user_info.face" :lazy-load="true"></image>
          </view>
          <view class="from">来自{{redenvelopeData.user_info.nickname}}的红包</view>
          <view class="blessing">{{redenvelopeData.msg}}</view>
          <view class="money" @tap="getHongBao(redenvelopeData)">

            <image :class="luckbtn" src="/static/theme/default/my/red_2.png" style="width: 180upx; height: 180upx;"></image>
          </view>
          <view class="showDetails" @tap="toDetails(redenvelopeData.id)">
            查看领取详情
            <view class="icon to"></view>
          </view>
        </view>
      </view>
    </view>

  </view>
</template>

<script>
import _hook from '../../../common/_hook';
import _data from '../../../common/_data';
import _get from '../../../common/_get';
export default {
  data () {
    return {
      list_id: '',
      dataList: [
        ],
      redenvelopeData: {
        user_info:{

        }
      },
      luckbtn: '',
      windowsState:''
    }
  },
  onShow () {
    let _this = this;
    _hook.routeSonHook();
   _this.getRedList();
  },
  computed:{
    staticPhoto(){
      return _data.staticPhoto();
    }
  },
  onLoad (options) {
    if ('list_id' in options) {
      this.list_id = options.list_id
    }
  },
  methods: {
    getRedList(){
      let _this = this;
      _get.getExpireBigRed({ list_id: this.list_id }, function (res) {
        _this.dataList = res
      })
    },
    discard () {
      return;
    },
    myPhoto(info) {
      return  info.user_info.photo;
    },
    getHongBao(params){
      params.rid = params.id;
      let _this = this;
      _this.luckbtn = "luckbtn";
      uni.showLoading({
        title: '加载中...'
      });
      _get.getHongBao(params, function (ret) {
        uni.$emit('data_user_info', ret);
        _data.data('user_info', ret);
        setTimeout(function () {
          uni.hideLoading();
          _this.luckbtn = "";
          _this.closeRedEnvelope();
          _this.toDetails(params.rid);
        }, 1000)
      }, function (ret) {
        setTimeout(function () {
          uni.hideLoading();
          _this.luckbtn = "";
          _this.closeRedEnvelope();
          _this.toDetails(params.rid);
        }, 1000);
      });
    },
    // 打开红包
    openRedEnvelope (bigRed) {
      //判断有无领取
      // if (this.receive_list.indexOf(msg.content.rid) >= 0) {
      //   this.toDetails(msg.content.rid);
      //   return true;
      // }
      this.windowsState = 'show';
      this.redenvelopeData = bigRed
      return true;
    },
    //领取详情
    toDetails (rid) {
      uni.navigateTo({
        url: '../message/details?rid=' + rid + '&list_id=' + this.list_id
      })
    },
    // 关闭红包弹窗
    closeRedEnvelope () {
      this.windowsState = 'hide';
      setTimeout(() => {
        this.windowsState = '';
      }, 200)
    },
  }
}
</script>

<style lang="scss">
  @import "@/static/css/chat/style.scss";
  .luckbtn {
    -webkit-transform: rotateY(360deg);
    animation: rotation 0.4s linear infinite;
    -moz-animation: rotation 0.4s linear infinite;
    -webkit-animation: rotation 0.4s linear infinite;
    -o-animation: rotation 0.4s linear infinite;
  }

  @-webkit-keyframes rotation {
    from {
      -webkit-transform: rotateY(0deg);
    }
    to {
      -webkit-transform: rotateY(360deg);
    }
  }
.whb-list {
  display: flex;
  justify-content: space-between;
  padding: 40upx;
  flex-wrap: wrap;
}
.whb-list .whb-item {
  width: 48%;
  height: 440upx;
  margin: 20upx 0;
  display: flex;
  flex-direction: column;
  background: #c40b00;
  border-radius: 30upx 30upx 40upx 40upx;
  overflow: hidden;
}
.user-img{
  width: 100upx;
  height: 100upx;
  border-radius: 10px;
  position: absolute;
  bottom: 0;
  transform: translateY(50%);
  border: 8upx solid #000;
  background: chartreuse;
}
.whb-item-header {
  display: flex;
  justify-content: center;
  height: 30%;
  background: navajowhite;
position: relative;
   border-radius: 0 0 120upx 120upx;
}
.whb-item-center {
  display: flex;
  height: 70%;
  flex-direction: column;
  align-items: center;
  background: #c40b00;
  padding-top: 50upx;
  border-radius: 0 0 40upx 40upx;
}
.whb-item-center .name{
  font-size: 36upx;
  font-weight: bold;
  color:#ffffff;

}
.whb-item-center .title{
  font-size: 26upx;
  color:#ffffff;
}
.whb-kai1{
  background: coral;
  border: 6upx solid cornflowerblue;
  width: 100upx;
  height: 100upx;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 10upx;
   font-size: 32upx;
  color:#ffffff;
  font-weight: bold;
}
 .whb-none{
   display: flex;
   justify-content: center;
   align-items: center;
   flex-direction: column;
   height: 1000rpx;
 }
 .whb-none image{
   width: 50px;
   height: 60px;
   padding: 20px;
 }
  .page{
    height: 100%;
  }
</style>

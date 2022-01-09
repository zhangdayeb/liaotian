
<template>
  <view class="page hongbao-page">
    <view class="content">
      <view class="hongbao-header">
        <view class="hongbao-header-view">
          <view class="header-top">
            <view class="top-left">
              <image :src="myPhoto" class="top-left-left"></image>
              <view class="top-left-right">
                <text class="hb-name">{{my_data.nickname}}</text>
                <view>
                  <text style="font-size: 24upx;color:#bebebe;margin-right:7px" @click="showTimeList">{{timeName}}</text>
                  <text style="font-size: 10upx;color:#bebebe" class="iconfont-im icon-sanjiao"></text>
                </view>

              </view>
            </view>
            <view class="top-right" v-if="get == 1">
              <view><text>收到红包</text><text class="top-right-num">{{info.get_count}} 个</text></view>
              <view><text>手气最佳</text><text class="top-right-num">{{info.best_count}} 次</text></view>
            </view>
            <view class="top-right" v-else  >
              <view><text>发出红包</text><text class="top-right-num">{{info.send_count}} 个</text></view>
            </view>
          </view>
          <view class="header-bottom">
            <text> {{get == 1 ? '共收到：':'共发出：'}}</text><text class="hongbao-num">￥{{info.amount}}</text>
          </view>
        </view>
      </view>
      <view class="capital-list"
            v-if="list.length">
        <view class="capital-item"
              v-for="(item) in list"
              :key="item.id">
          <view class="item-left">
            <text class="time-msg">{{item.explain}}</text>
            <text class="time">{{timestampFormat(item.create_time + '')}}</text>
          </view>
          <view class="item-right">
            <text class="add-money"
                  :style="{color:item.record_type == 0 ? '#e6b141' : 'black'}">{{item.record_type == 0 ? -item.money : '+'+item.money}}</text>
            <text class="yue">
              <text style="margin-right: 8rpx;">余额</text>
              {{item.user_money}}
            </text>
          </view>
        </view>
        <uni-load-more :status="status"></uni-load-more>
      </view>
    </view>
    <view class="hongbao-footer">
      <view @click="getHb(1)" :class="get==1?'active':''"><text>收到的红包</text></view>
      <view  @click="getHb(2)" :class="get==2?'active':''"><text>发出的红包</text></view>
    </view>
    <uni-popup ref="popup2"
               type="bottom">
      <view class="but-view">
        <view  class="but-top-view">
          <view v-for="item in timeList" :key="item.id" @click="getTimeHb(item.id,item.name)">{{item.name}}</view>
        </view>
        <view class="clone-but" @click="clonePopup">取消</view>
      </view>
    </uni-popup>
  </view>
</template>

<script>
import uniLoadMore from "../../../components/uni-ui/uni-load-more/uni-load-more.vue";
import _get from '../../../common/_get';
import uniPopup from '../../../components/uni-popup/uni-popup.vue';
import _action from '../../../common/_action';
import _hook from '../../../common/_hook';
import _data from '../../../common/_data';

export default {
  computed: {
    status () {
      return this.pullUp == 0 ? 'more' : (this.pullUp == 1 ? 'loading' : '')
    },
    myPhoto(){
      return _data.staticPhoto() + this.my_data.photo;
    }
  },
  data () {
    return {
      info:{
        amount:'0.00',
        best_count:'0',
        get_count:'0',
        send_count:0
      },
      my_data:{},
      videPoup: false,
      get: 1,// 代表我发出还是收到
      time:4,
      pullUp: 0, //0加载更多 1 加载中 -1 加载完成
      page: 1,
      totallPage: 1,
      list: [
      ],
      timeName:'近三个月',
      type: '',
      timeList:[{id:4,name:'近三个月'},{id:1,name:'本月'},{id:2,name:'上个月'},{id:3,name:'上上个月'}]
    }
  },
  onLoad (options) {
    if ('type' in options) {
      this.type = options.type;
      uni.setNavigationBarTitle({
        title: '我的红包记录'
      })
    }
  },
  onShow () {
    let _this = this;
    _hook.routeSonHook();
    this.getCapital('down');
    _get.getUserInfo({});
    uni.$on('data_user_info',function(data){
      _this.my_data = data;
      _data.data('user_info',data)
    });
  },
  components: {
    uniLoadMore,
    uniPopup
  },
  onReachBottom () {
    let _this = this;
    if (_this.pullUp == 0) {
      _this.page++;
      _this.pullUp = 1;
      this.getCapital('up');
    }
  },
  onPullDownRefresh () {
    this.pullUp = 0; //重置下拉
    this.page = 1;
    uni.startPullDownRefresh();
    this.getCapital('down', function () {
      uni.stopPullDownRefresh();
    });
  },
  methods: {
    // 发出和收到切换
    getHb(type){
      this.get= type
      this.page = 1;
      this.getCapital('down', function () {
        uni.stopPullDownRefresh();
      });
    },
    // 时间切换
    getTimeHb(time,name){
      this.timeName = name
      console.log(time)
      this.time = time;
      this.page = 1;
      let _this = this;
      this.getCapital('down', function () {
        _this.$refs.popup2.close();
      });
    },
    clonePopup(){
      this.$refs.popup2.close()
    },
    showTimeList () {
      console.log(55555)
      this.$refs.popup2.open()
    },
    getCapital (type, cb) {
      let _this = this;
      _get.getUserCapitalList({ page: this.page, type: _this.type,get:_this.get,time:_this.time }, function (res) {
        _this.totallPage = res.last_page;
        if (type == 'down') {
          _this.list = res.data;
          if (cb != undefined) cb();
        } else {
          if (_this.page > _this.totallPage) {
            _this.pullUp = -1;
          } else {
            _this.list = _this.list.concat(res.data)
            _this.pullUp = 0;
          }
        }
        if(_this.type){
          if(_this.get == 1){
            _this.info.best_count = res.info.best_count
            _this.info.get_count = res.info.count
            _this.info.amount = res.info.amount
          }else {
            _this.info.send_count = res.info.send_count
            _this.info.amount = res.info.amount
          }
        }
        _this.clonePopup()
      })
    },
    timestampFormat (time) {
      return _action.timestampFormat(time);
    },

  }
}
</script>

<style>
/*757575*/
page {
  background-color: white;
}
.hongbao-header {
  padding: 40upx;
}
.hb-name{
  font-weight: bold;
}
.hongbao-page {
  display: flex;
  flex-direction: column;
}
.hongbao-page .content {
  padding-bottom: 100upx;
}
.hongbao-footer {
  height: 100upx;
  border-top: 1px solid #d3cdcd;
  position: fixed;
  display: flex;
  justify-content: space-between;
  bottom: 0;
  left: 0;
  right: 0;
  background: #ffffff;
}
.but-view {
  display: flex;
  flex-direction: column;
  padding: 40upx;
}
.but-top-view {
  display: flex;
  flex-direction: column;
   border-radius: 12upx;
   overflow: hidden;
}
.but-top-view view {
  width: 100%;
  background: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80upx;
 border-top: 1px solid #d3cdcd;
}
.clone-but{
   width: 100%;
  background: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80upx;
   border-radius: 12upx;
   margin-top: 30upx;
}

.hongbao-footer view {
  width: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.hongbao-footer text {
  height: 100%;
  display: flex;
  align-items: center;
}
.hongbao-footer .active text {
  border-top: 2px solid red;
  color: red;
}
.header-top {
  display: flex;
  height: 100upx;

  justify-content: space-between;
}
.top-left {
  display: flex;
}
.top-left-left {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100upx;
  background: chartreuse;
  border-radius: 10upx;
  height: 100%;
  margin-right: 20upx;
}
.top-left-right {
  display: flex;
  flex-direction: column;
}
.top-right-num {
  color: rebeccapurple;
  margin-left: 10upx;
}
.hongbao-header-view {
  height: 300upx;
  background: #f1edec;
  width: 100%;
  border-radius: 8upx;
  display: flex;
  justify-content: space-between;
  flex-direction: column;
  padding: 40upx;
  box-sizing: border-box;
}
.header-bottom {
  display: flex;
  align-items: center;
}
.hongbao-num {
  font-size: 46upx;
  font-weight: bold;
}

.item-left,
.item-right {
  padding-bottom: 25upx;
  padding-top: 30upx;
}

.time,
.yue {
  color: #757575;
}

.content .capital-list {
  display: flex;
  flex-direction: column;
  padding: 0upx 0upx 120upx 40upx;
}

.capital-list .capital-item {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #f2f2f2;
}

.item-right .add-money {
  margin-bottom: 15upx;
  font-size: 14px;
  font-weight: 500;
}
.sub-mone {
  margin-bottom: 15upx;
  font-size: 14px;
  font-weight: 500;
  color: #e6b141;
}
.item-left .time-msg {
  margin-bottom: 15upx;
  font-size: 14px;
  font-weight: 400;
}

.capital-list .capital-item .item-left {
  display: flex;
  flex-direction: column;
}

.capital-list .capital-item .item-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  padding-right: 40upx;
}
</style>

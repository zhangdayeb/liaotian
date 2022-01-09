<template>
  <view class="page">
    <scroll-view class="scrollList"
                 scroll-y
                 :scroll-into-view="scrollViewId"
                 :style="{height:winHeight + 'px'}">
      <uni-search-bar ref="searchBar2"
                      placeholder="搜索好友"
                      :show="false"
                      @confirm="search"
                      @search="search"></uni-search-bar>

      <view class="uni-list">

        <block>

          <view class="header"
                v-if="0">
            <navigator :url="'phone-search'"
                       hover-class="none"
                       class="input-view">
              <uni-icon type="search"
                        size="22"
                        color="#666666"></uni-icon>
              <input class="input"
                     type="text"
                     placeholder="搜索我的朋友"
                     :disabled="true" />
            </navigator>
          </view>

          <uni-list>

            <view class="uni-media-list btm_border"
                  @click="goPath('../friend/apply-list',0)">
              <view class="uni-media-list-logo">
                <image src="../../static/theme/default/friend/new.png"
                       class="img-icon" />

              </view>
              <view class="uni-media-list-body">
                <view class="uni-list-cell-navigate">新的朋友</view>
              </view>
              <view v-if="new_friend_tips > 0">
                <view class="red_num"><text>{{new_friend_tips}}</text></view>
                <view><text>&nbsp;</text></view>
              </view>
            </view>

            <view class="uni-media-list btm_border"
                  @click="goPath('./group_chat')">
              <view class="uni-media-list-logo">
                <image src="../../static/theme/default/friend/group.png"
                       class="img-icon" />

              </view>
              <view class="uni-media-list-body">
                <view class="uni-list-cell-navigate">群聊</view>
              </view>
              <view>
                <view class=""><text></text></view>
                <view><text>&nbsp;</text></view>
              </view>
            </view>

            <view class="uni-media-list"
                  @tap="goPath('./chat-group-apply',1)">
              <view class="uni-media-list-logo">
                <image src="../../static/theme/default/friend/group-auth.png"
                       class="img-icon" />
              </view>
              <view class="uni-media-list-body">
                <view class="uni-list-cell-navigate">群认证</view>
              </view>
              <view v-if="new_group_tips > 0">
                <view class="red_num"><text>{{new_group_tips}}</text></view>
                <view><text>&nbsp;</text></view>
              </view>
            </view>

            <uni-list-item title="标签"
                           :show-arrow="false"
                           thumb="../../static/theme/default/friend/label.png"
                           @click="goPath('')"
                           v-if="0" />
            <uni-list-item title="小程序"
                           :show-arrow="false"
                           thumb="../../static/theme/default/friend/program.png"
                           @click="goPath('')"
                           v-if="0" />

          </uni-list>
        </block>

        <block v-for="(list, key) in list_data"
               :key="key">
          <view class="uni-list-cell-divider"
                :id="list.letter">
            {{list.letter}}
          </view>
          <view class="uni-list-cell"
                hover-class="none"
                :class="list.data.length -1 == index ? 'uni-list-cell-last' : ''"
                v-for="(item,index) in list.data"
                :key="isKey(key,index)">
            <uni-swipe-action :options="[ {text: '备注'} ]"
                              @tap="swipeAction(item.user_id + '')">
              <view class="uni-media-list"
                    @tap="goDetails(item.user_id + '')">
                <view class="uni-media-list-logo">
                  <image :src="photo(item.photo+'')"
                         :lazy-load="true"
                         style="border-radius: 10px;" />
                </view>
                <view class="uni-media-list-body">
                  <view class="uni-list-cell-navigate">{{item.name}}</view>
                </view>
              </view>
            </uni-swipe-action>
          </view>
        </block>
      </view>
    </scroll-view>

    <view class="uni-indexed-list-bar"
          :class="touchmove ? 'active' : ''"
          @touchstart="touchStart"
          @touchmove.stop.prevent="touchMove"
          @touchend="touchEnd"
          @touchcancel="touchCancel"
          :style="{height:winHeight + 'px'}">
      <text v-for="(list,key) in key_data"
            :key="key"
            class="uni-indexed-list-text"
            :class="touchmoveIndex == key ? 'active' : ''"
            :style="{height:itemHeight + 'px',lineHeight:itemHeight + 'px'}">
        {{list}}
      </text>
    </view>

    <view class="uni-indexed-list-alert"
          v-if="touchmove">
      {{key_data[touchmoveIndex]}}
    </view>

  </view>
</template>

<script>

import uniIcon from '../../components/uni-ui/uni-icon/uni-icon.vue';
import uniList from '../../components/uni-ui/uni-list/uni-list.vue';
import uniListItem from '../../components/uni-ui/uni-list-item/uni-list-item.vue';
import uniSwipeAction from '../../components/uni-ui/uni-swipe-action/uni-swipe-action.vue'
import _get from '../../common/_get';
import _hook from '../../common/_hook';
import _data from '../../common/_data';
import _action from '../../common/_action';
import uniSearchBar from '@/components/mehaotian-search/mehaotian-search.vue'

export default {
  components: {
    uniIcon,
    uniList,
    uniListItem,
    uniSwipeAction,
    uniSearchBar
  },
  data () {
    return {
      list_data: [],
      new_friend_tips: 0,
      new_group_tips: 0,
      title: 'grid',
      touchmove: false,
      touchmoveIndex: -1,
      itemHeight: 0,
      winHeight: 0,
      scrollViewId: "A",
      titleHeight: 0,
      search_list: [],
      keyword: '',
      key_data: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
    }
  },
  onShow() {
    _hook.routeTabBarHook();
    let _this = this,
      frien_list = _data.localData('frien_list'),
      tips_num = _data.data('new_friend_tips_num'),
      tips_group_apply = _data.data('new_group_tips_num');

    /** 监听最新数据 */
    uni.$on('data_friend_list', function (data) {
      _this.list_data = data;
      _this.search_list = data;
    });
    /** 监听新的朋友提示 */
    uni.$on('data_new_friend_tips', function (data) {
      _this.new_friend_tips = data;
      console.log(_this.new_friend_tips);
    });
    /** 监听群认证消息 */
    uni.$on('data_new_group_apply_tips', function (data) {
      _this.new_group_tips = data;
    });

    _this.new_friend_tips = tips_num;
    _this.new_group_tips = tips_group_apply;

    /** 加载本地缓存数据，让页面秒速渲染出来 */
    if (frien_list) {
      _this.list_data = frien_list;
    } else {
      _get.getFriendList();
    }
  },
  onLoad () {
    let winHeight = uni.getSystemInfoSync().windowHeight;
    this.itemHeight = winHeight / 26;
    console.log(winHeight)
    this.winHeight = winHeight;
  },
  onHide () {
    uni.$off('data_friend_list');
    uni.$off('data_new_friend_tips');
    uni.$off('data_new_group_apply_tips');
    //清空search框
    if (this.keyword) {
      this.$refs.searchBar2.clear();
      this.list_data = this.search_list;
    }
  },
  computed: {
    staticPhoto () {
      return _data.staticPhoto();
    },
  },
  methods: {
    search (keyword) {
      this.keyword = keyword.trim();
      let _this = this;
      if (!keyword) {
        console.log(1111)
        console.log(_this.search_list)
        _this.list_data = _this.search_list;
        return true;
      }
      _get.searchFriends({ 'keyword': keyword }, function (data) {
        _this.list_data = data.data;
      })
    },
    photo (path) {
      return this.staticPhoto + path;
    },
    swipeAction (user_id) {
      uni.navigateTo({
        url: './remarks?user_id=' + user_id,
        animationType: 'slide-in-bottom',
      });
    },
    goDetails (user_id) {
      if (user_id) {
        uni.navigateTo({
          url: '../details/index?user_id=' + user_id,
        });
      }
    },
    goPath (path, type) {
      switch (type) {
        case 0:
          path += '?action=' + (this.new_friend_tips ? 1 : 0)
          this.new_friend_tips = 0;
          _data.data('new_friend_tips_num', 0);
          _action.setStatusTips();
          break;
        case 1:
          path += '?action=' + (this.new_group_tips ? 1 : 0);
          this.new_group_tips = 0;
          _data.data('new_group_tips_num', 0);
          _action.setStatusTips();
          break;
        default:
          break;
      }
      if (path) {
        uni.navigateTo({
          url: path,
        });
      }
    },
    isKey (key, index) {
      return key + '' + index;
    },
    touchStart (e) {
      this.touchmove = true;
      let pageY = e.touches[0].pageY;
      let index = Math.floor((pageY - this.titleHeight) / this.itemHeight);
      console.log("index", index)
      let item = this.list_data[index];
      console.log("list_data", this.list_data)
      console.log("item", item)
      if (item) {
        this.scrollViewId = item.letter;
      }

      this.touchmoveIndex = index;
    },
    touchMove (e) {
      let pageY = e.touches[0].pageY;
      let index = Math.floor((pageY - this.titleHeight) / this.itemHeight);
      let item = this.list_data[index];
      if (item) {
        this.scrollViewId = item.letter;
        this.touchmoveIndex = index;
      }
    },
    touchEnd () {
      this.touchmove = false;
      //this.touchmoveIndex = -1;
    },
    touchCancel () {
      this.touchmove = false;
      //this.touchmoveIndex = -1;
    },
  },
  watch: {

  },
  onNavigationBarButtonTap (e) {
    let _path = e.index ? './phone-search' : './add';
    uni.navigateTo({
      url: _path,
    });
  }
}
</script>

<style scoped>
.page {
  display: flex;
  flex-direction: row;
}
.search .content {
  padding-left: 20upx;
  height: 60upx;
}
.scrollList {
  flex: 1;
  height: 100vh;
}

.uni-indexed-list-bar {
  width: 40upx;
  height: 100vh;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
}

.uni-indexed-list-bar.active {
  /* background-color: rgb(200, 200, 200); */
}

.uni-indexed-list-text {
  font-size: 22upx;
  text-align: center;
}

.uni-indexed-list-bar.active .uni-indexed-list-text {
  color: #333;
}

.uni-indexed-list-text.active,
.uni-indexed-list-bar.active .uni-indexed-list-text.active {
  color: #02b300;
}

.uni-indexed-list-alert {
  position: absolute;
  z-index: 20;
  width: 160upx;
  height: 160upx;
  left: 50%;
  top: 50%;
  margin-left: -80upx;
  margin-top: -80upx;
  border-radius: 80upx;
  text-align: center;
  line-height: 160upx;
  font-size: 70upx;
  color: #fff;
  background-color: rgba(0, 0, 0, 0.5);
}

.header {
  display: flex;
  flex-direction: row;
  padding: 10px 15px;
  align-items: center;
}

.input-view {
  display: flex;
  align-items: center;
  flex-direction: row;
  background-color: #e7e7e7;
  height: 30px;
  border-radius: 5px;
  padding: 0 10px;
  flex: 1;
}

.input {
  flex: 1;
  padding: 0 5px;
  height: 24px;
  line-height: 24px;
  font-size: 16px;
}

.uni-list-cell-navigate {
  padding: 0;
}

.uni-media-list-body {
  height: auto;
}
.uni-media-list image {
  border-radius: 10px;
}

.uni-swipe-action {
  width: 710upx !important;
}
.btm_border {
  position: relative;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}
.btm_border::after {
  position: absolute;
  z-index: 3;
  right: 0;
  bottom: 0;
  left: 115upx;
  height: 1px;
  content: "";
  -webkit-transform: scaleY(0.5);
  transform: scaleY(0.5);
  background-color: #e7e6ef;
}
.img-icon {
  width: 85upx;
  height: 85upx;
  border-radius: 10upx;
}
.uni-media-list-logo {
  height: 85upx;
  width: 85upx;
  margin-right: 20upx;
}
.red_num {
  background-color: #f43530;
  width: 35upx;
  border-radius: 18upx;
  text-align: center;
  height: 35upx;
  line-height: 35upx;
  color: #ffffff;
  font-size: 23upx !important;
}
</style>

<template>

  <view class="page">
    <uni-search-bar ref="searchBar"
                    placeholder="搜索聊天记录"
                    :show="false"
                    @confirm="search"
                    @search="search"></uni-search-bar>
    <view class="uni-list"
          v-if="list.length">
      <uni-swipe-action >
        <uni-swipe-action-item class="uni-list-cell"
                        v-for="(value,key) of list"
                        :key="key" :right-options="swipeData(value,key)"
                               :auto-close="false" @click="swipeAction">
          <view class="uni-media-list"
                @tap="goMessage(value.list_id,key,value.no_reader_num,value.chat_id,value.show_name)">
            <view class="uni-media-list-logo">
              <image :src="staticPhoto + value.photo_path + '?_=' + imgRan"
                     :lazy-load="true"
                     style="border-radius: 10px;"
                     :data-index="key"
                     @error="imageError" />
            </view>

            <view class="red_num">
              <uni-badge :text="value.no_reader_num"
                         type="error" />
            </view>

            <view class="uni-media-list-body">
              <view class="uni-media-list-text-top">

                <text>{{msgHandle(value.show_name+'',12)}}</text>
                <view style="float: right;color: #8f8f94;font-size: 23upx;">
                  {{timestampFormat(value.time)}}
                </view>
              </view>
              <view class="uni-media-list-text-bottom uni-ellipsis">{{value.last_msg}}</view>
            </view>

          </view>
        </uni-swipe-action-item>
      </uni-swipe-action>
      <!-- <view class="uni-list-cell"
            v-for="(value,key) of list"
            :key="key">
        <uni-swipe-action :options="swipeData(value.no_reader_num)"
                          @click="swipeAction"
                          @opened="openedAction(key)">
          <uni-swipe-action>
            <view class="uni-media-list"
                  @tap="goMessage(value.list_id,key,value.no_reader_num,value.chat_id)">
              <view class="uni-media-list-logo">
                <image :src="staticPhoto + value.photo_path + '?_=' + imgRan"
                       :lazy-load="true"
                       style="border-radius: 10px;"
                       :data-index="key"
                       @error="imageError" />
              </view>

              <view class="red_num">
                <uni-badge :text="value.no_reader_num"
                           type="error" />
              </view>

              <view class="uni-media-list-body">
                <view class="uni-media-list-text-top">

                  <text>{{msgHandle(value.show_name+'',12)}}</text>
                  <view style="float: right;color: #8f8f94;font-size: 23upx;">
                    {{timestampFormat(value.time)}}
                  </view>
                </view>
                <view class="uni-media-list-text-bottom uni-ellipsis">{{value.last_msg}}</view>
              </view>

            </view>
          </uni-swipe-action>
        </uni-swipe-action>
      </view> -->
    </view>

    <view :class="['action_main animated faster',(action_menu ? 'bounceInDown' : 'bounceOutUp')]"
          v-show="showActionMenu"
          @tap="actionMain">
      <view class="action_base">

        <view class="sj"></view>

        <view class="action_item"
              @tap="goAction(0)">
          <view class="uni-media-list-logo action_icon">
            <image :src="'../../static/theme/default/chat/chat.png'"
                   :lazy-load="true" />
          </view>
          <text class="action_item_text">发起群聊</text>
        </view>

        <view class="action_item"
              @tap="goAction(1)">
          <view class="uni-media-list-logo action_icon">
            <image :src="'../../static/theme/default/chat/add_friend.png'"
                   :lazy-load="true" />
          </view>
          <text class="action_item_text">添加好友</text>
        </view>

        <!-- #ifdef APP-PLUS -->
        <view class="action_item"
              @tap="goScanCode">
          <view class="uni-media-list-logo action_icon">
            <image :src="'../../static/theme/default/chat/scan_code.png'"
                   :lazy-load="true" />
          </view>
          <text class="action_item_text">扫一扫</text>
        </view>
        <!-- #endif -->

        <view class="action_item"
              @tap="goPath('../my/pay/pay')">
          <view class="uni-media-list-logo action_icon">
            <image :src="'../../static/theme/default/chat/in_out.png'"
                   :lazy-load="true" />
          </view>
          <text class="action_item_text">收付款</text>
        </view>
      </view>
    </view>
    <uni-popup ref="popup" type="confirm">
      <uni-popup-confirm title="转发消息" :content="popuMsg" @confirm = "confirm"> </uni-popup-confirm>
    </uni-popup>
  </view>
</template>

<script>
import animate from '../../static/css/chat/animate.css';
import uniIcon from '../../components/uni-icons/uni-icons.vue';
import uniBadge from '../../components/uni-badge/uni-badge.vue';
import uniSwipeAction from '../../components/uni-swipe-action/uni-swipe-action.vue'
import uniSwipeActionItem from '../../components/uni-swipe-action-item/uni-swipe-action-item.vue'
import _get from '../../common/_get';
import _hook from '../../common/_hook';
import _action from '../../common/_action';
import _data from '../../common/_data';
import _page from '../../common/common';
import uniSearchBar from '@/components/mehaotian-search/mehaotian-search.vue';
import uniPopup from '../../components/uni-popup/uni-popup.vue';
import uniPopupConfirm from '../../components/uni-popup/uni-popup-confirm.vue';
export default {
  components: {
    uniIcon,
    uniBadge,
    uniSwipeAction,
    uniSwipeActionItem,
    uniSearchBar,
    uniPopup,
    uniPopupConfirm
  },
  data () {
    return {
      trans_id:'',
      popuMsg:'',
      list: [],
      search_list: [],
      list_index: '',
      action_menu: false,
      action_menu_num: 0,
      options: [
        {
          text: '取消',
          style: {
            backgroundColor: '#007aff'
          }
        }, {
          text: '删除',
          style: {
            backgroundColor: '#dd524d'
          }
        }
      ]
    }
  },
  onShow () {
    _hook.routeTabBarHook();
    uni.$off('data_chat_list');
    let _this = this,
      chat_list = _data.localData('chat_list');
    console.log(chat_list)

    /** 监听最新数据 */
    uni.$on('data_chat_list', function (data) {
      console.log("success");
      console.log(data);
      _this.list = data;
      _this.search_list = _this.list;
      console.log("接收到新数据....");
    });
    //有缓存则监听是否有数据更新，有则重新获取
    // uni.$once('update_chat_list', function () {
    //   _get.getChatList();
    // })
    /** 加载本地缓存数据，让页面秒速渲染出来 */
    if (chat_list) {
      _this.list = chat_list;
    } else {
      _get.getChatList();
    }
    _this.action_menu = false;

  },
  onLoad (options) {
    if('id' in options){
      this.trans_id = options.id
    }
  },
  onUnload () {
    uni.$off('data_chat_list');
  },
  onPullDownRefresh () {
    _get.getChatList();
    setTimeout(function () {
      uni.stopPullDownRefresh();
    }, 300);
  },
  onHide () {
    //清空search框
    if (this.keyword) {
      this.$refs.searchBar.clear();
      this.list = this.search_list;
    }
  },

  computed: {
    showActionMenu () {
      return this.action_menu;
    },
    staticPhoto () {
      return _data.staticPhoto();
    },
    imgRan () {
      return Math.random();
    },
  },
  methods: {
    search (chat_msg) {
      chat_msg = chat_msg.trim();
      let _this = this;
      _this.keyword = chat_msg;
      console.log(!chat_msg)
      if (!chat_msg) {
        _this.list = _this.search_list;
        return true;
      }
      _get.serchChatMsg({ 'chat_msg': chat_msg }, function (data) {
        _this.list = data;
      })
    },
    goPath (path) {
      if (path) {
        uni.navigateTo({
          url: path
        })
      }
    },
    imageError (e) {
      let index = e.currentTarget.dataset.index
      //替换index对应的图片
      this.list[index].photo_path = '/default_photo_path.png';
    },
    msgHandle (msg, num) {
      if (num == undefined) num = 16;
      if (!msg) return '';
      msg = msg.replace(/&lt;/g, '<');
      return msg.length > num ? msg.substr(0, num) + '...' : msg;
    },
    timestampFormat (time) {
      return _action.timestampFormat(time);
    },
    goAction (type) {
      let path = '';
      switch (type) {
        case 0:
          path = '../friend/index_list?list_id=0';
          break;
        case 1:
          path = '../friend/add';
          break;
        default:
          return;
          break;
      }
      uni.navigateTo({
        url: path,
        animationType: 'slide-in-bottom',
      });
    },
    actionMain () {
      this.action_menu = !this.action_menu;
      this.action_menu_num++;
    },
    openedAction (key) {
      this.list_index = key;
    },
    swipeAction (e) {
      let list_index = e.content.number
      let _this = this,
        list_id = _this.list[list_index].list_id;
      if (!list_id) {
        return;
      }
      let top = _this.list[list_index].top;
      console.log("top",top)
      let value = top == 1 ? 0 : 1;
      console.log("value",value)
      switch (e.index) {
        case 0:
          //置顶 /取消置顶
          _this.$httpSend({
            path: '/im/message/chatTop ',
            data: { list_id:list_id, value: value},
            success: () => {
              _get.getChatList();
            }
          });
          break;
        case 1:
          /** 删除这条对话 */
          _this.$httpSend({
            path: '/im/chat/deleteChat',
            data: { list_id, },
            success: (data) => {
              _get.getChatList();
            }
          });
          break;
        default:
          break;
      }
    },
    swipeData (value,index) {
      console.log(value)
      return [
        {
          text: value.top == 1 ? '取消置顶':'置顶',
          number:index,
          style: {

          },
        },
        {
          text: '删除',
          number:index,
          style: {
            backgroundColor: 'rgb(255,58,49)',
          }
        }
      ];
    },
    goMessage (list_id, key, no_reader_num, chat_id,show_name) {
      if (no_reader_num > 0) {
        _get.getChatData({
          send_data: {
            list_id: list_id,
            time: 0,
            is_up: 1,
          },
          is_action_data: 1,
        });
        this.list[key].no_reader_num = 0;
        _data.localData('chat_list', this.list);
        _action.updataNoReader(list_id);
        _action.setStatusTips();
      }
      console.log("chat_id", chat_id);
      _data.localData('message_list_id', list_id);
      // './message?list_id=' + list_id + "&chat_id="+chat_id,
      //TODO 弹窗发送消息
      this.popuMsg = "确认转发给："+show_name
     this.$refs.popup.open()
    },
    goScanCode () {
      let _this = this;
      _this.action_menu = false;
      _page.scanCode();
    },
    confirm(callback){
     if(typeof callback === "function"){
         let list_id = _data.localData('message_list_id');
         _get.transMsg({list_id:list_id,trans_id:this.trans_id},function (ret) {
             uni.redirectTo({
                 url:'/pages/chat/message?trans=1&list_id='+list_id,
                 success:function (res) {
                 }
             })
         });
     }
    }
  },
  watch: {

  },
  onNavigationBarButtonTap (e) {
    this.action_menu = !this.action_menu;
  },
}
</script>

<style>
.uni-list-cell{
  overflow: hidden;
}
.uni-media-list-logo {
  height: 100upx;
  width: 100upx;
}
.search .content {
  padding-left: 20upx;
  height: 60upx;
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

.red_num {
  position: absolute;
  height: 34upx;
  top: 7upx;
  left: 120upx;
  font-size: 23upx !important;
}

/**
	.uni-media-list-body {
		height: auto;
	}
	*/

.uni-swipe-action,.uni-swipe,.uni-view,.uni-media-list{
  width: 750upx !important;
}

.action_main {
  position: fixed;
  top: 55px;
  /* #ifndef H5 */
  top: 15px;
  /* #endif */
  width: 750upx;
  height: 1080upx;
  z-index: 10000;
}

.action_base {
  position: absolute;
  right: 15upx;
  width: 300upx;
  top: -15upx;
  background: #36363d;
  border-radius: 10upx;
}

.sj {
  position: fixed;
  top: -28upx;
  right: 26upx;

  /* #ifdef APP-PLUS */
  top: 3upx;
  right: 20upx;
  /* #endif */

  width: 0;
  height: 0;
  border-left: 20upx solid transparent;
  border-right: 20upx solid transparent;
  border-bottom: 20upx solid #36363d;
}

.action_item {
  color: #e5e5e5;
  height: 100upx;
  line-height: 100upx;
  margin-left: 45upx;
  border-bottom: 1px solid #3e3e3e;
}

.action_icon {
  width: 45upx;
  height: 45upx;
  display: inline-block;
  vertical-align: middle;
}

.action_item:last-child {
  border: none;
}

.action_item_text {
  font-size: 30upx;
}
</style>
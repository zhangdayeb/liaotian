<template>
  <view class="page">
    <view class="v-shiping" v-if="call_data.content_type == 6">
      <view class="page-shipin">
        <view class="shipin"></view>
      </view>
      <view class="page-user-info">
        <view class="page-user-img">
          <image :src="user_info.photo||default_img">
          </image>
        </view>
        <view class="page-user-msg">
          <text class="page-user-name">{{user_info.username}}</text>
          <text class="page-invite-msg">{{info}}</text>
        </view>
      </view>
    </view>
    <view class="v-yinpin" v-else>
        <view class="page-user-clunm">
            <image :src="user_info.photo||default_img"></image>
            <text>{{user_info.username}}</text>
            <text>{{info}}</text>
        </view>
    </view>

    <view class="page-bak"></view>
    <view class="page-do">
      <view   class="page-do-guaduan" @tap="doCancel">
        <image src="/static/theme/default/my/guaduan.png"></image>
        <text>挂断</text>
      </view>
        <view class="page-do-jieting" @tap="doGetCall">
          <image src="/static/theme/default/my/jieting.png"></image>
          <text>接听</text>
        </view>
    </view>
  </view>
</template>

<script>
import _get from '../../common/_get';
import _action from '../../common/_action';
import _data from '../../common/_data';
import _hook from '../../common/_hook';

export default {

  data () {
    return {
	  back_in:false,	
	  back:false,
	  click:true,
      // #ifdef APP-PLUS
      call:uni.requireNativePlugin('Html5App-TencentCall'),
      // #endif
      call_data:{},
      user_info:{
        username:'',
        photo:'',
      },
      info:'',
	  ret:false,
      default_img:'http://111.230.134.49:88/static/photo//default_photo_path.png?_=0.10315836224650199'
    }
  },
  onShow () {
    /** 监听新的个人数据 */
    let _this = this;
	_hook.routeSonHook();
    _this.user_info.photo = _data.staticPhoto()+_this.call_data.myavatar;
    _this.user_info.username = _this.call_data.name;
    _this.info = _this.call_data.wait;
	//关闭页面
    uni.$off('close_call');
	uni.$once('close_call',function(data){
	  _this.back_in = true;
      let user = _data.data('user_info');
	  if(user.id == data.user_id && !_this.back){
		  _this.back = true;
		  _action.stopVoice();
		  uni.navigateBack();
	  }
	});
  },
  onLoad (options) {
    this.call_data = options;
    _action.playVoice('/static/voice/video.mp3', true);
  },
  onHide () {
  },
  onUnload(){
	  uni.$off('close_call');
  },
  computed: {

  },
  methods: {
    doCancel(){
      console.log("取消.....")
      let _this = this;
	 _action.stopVoice();
	  if(!_this.click){
		  _this.back = true;
		  uni.navigateBack({
		  	delta:1
		  })
		  return false;
	  }
	  _this.click = false;
      _get.cancelCall(_this.call_data,function (res) {
      });
    },
    doGetCall(){
      // #ifdef APP-PLUS
      //发送消息接受消息
      let _this = this;
	  if(!_this.click){
	  		return false;
	  }
	  _action.stopVoice();
	    _this.click = false;
		
      _get.agreeVedio(_this.call_data,function () {
        _this.call.openCall(
                {
                  type: 1, //使用默认界面
                   ..._this.call_data
                }, ret => {
					if(ret.code == 1 && ret.time != undefined && !_this.ret){
						_this.call_data.time = ret.time;
						_this.ret = true;
						_get.cancelCall(_this.call_data, function (res) {
						});
					}
                });
      });
      // #endif
    }
  },
  watch: {

  },
}
</script>

<style>

page{
  background-color: #424242;
}
.page-user-clunm{
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: center;
  color: white;
  margin-top: 150rpx;
}
.page-bak{
  height: 500rpx;
}
.page-do{
  display: flex;
  align-items: center;
  justify-content: center;
  height:100%;
}
.page-user-name{
  font-size: 16px;
  font-weight: 400;
}
.page-user-info{
  margin-left: 60rpx;
}
.page-shipin{
  display: flex;
  justify-content: flex-end;
}
.page-do-guaduan{
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  width:100%;
  color:#FFFFFF;
}
.page-do-guaduan image{
  width: 50px;
  height: 50px;
  padding: 20rpx 0;
}
.page-user-clunm image{
  width: 50px;
  height: 50px;
  padding: 20rpx 0;
}
.page-do-jieting image{
  width: 50px;
  height: 50px;
  padding: 20rpx 0;
}
.page-do-jieting{
  width:100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  color:#FFFFFF;
}

.page-user-img image{
  height: 50px;
  width: 50px;
}
.page-user-msg{
  display: flex;
  flex-direction: column;
  justify-content: center;
  margin-left: 20rpx;
  color: white;
}
.page-user-msg text{
  display: flex;
}
.page{
  height: 100%;
  display: flex;
  flex-direction: column;
}
 .page .shipin {
   height: 400rpx;
   width: 220rpx;
   background-color: black;
   margin-right: 25rpx;
   margin-top:30rpx;
 }
  .page-user-info{
    display: flex;

  }
</style>

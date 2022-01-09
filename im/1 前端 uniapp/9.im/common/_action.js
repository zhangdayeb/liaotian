import _data from './_data';
import _mixins from './_mixins';
let innerAudioContext = uni.createInnerAudioContext();
export default {
  /** 显示状态通知提醒 */
  setStatusTips () {
    let pages = getCurrentPages();
    if (pages.length < 1) {
      return;
    }
    let route = pages[pages.length - 1].route,
      /** 只有tabbar页面才更新消息状态 */
      routes = [
        'pages/chat/index',
        'pages/friend/index',
        'pages/push/index',
        'pages/my/index'
      ];
    if (routes.indexOf(route) == -1) {
      return;
    }
    /** 通讯录提示 */
    let num = (_data.data('new_friend_tips_num') * 1),
      num_ = (_data.data('new_group_tips_num') * 1);
    if (num_) {
      uni.$emit('data_new_group_apply_tips', num_);
    }
    if (num) {
      uni.$emit('data_new_friend_tips', num);
    }
    if (num + num_) {
      uni.setTabBarBadge({
        index: 1,
        text: (num + num_ + ''),
      });
    } else {
      uni.removeTabBarBadge({ index: 1 });
    }
    /** 会话列表提示 */
    num = _data.chatTipsNum();
    if (num) {
      uni.setTabBarBadge({
        index: 0,
        text: (num + ''),
      });
      if (route == 'pages/chat/index') {
        uni.setNavigationBarTitle({
          title: '新聊' + '(' + num + ')',
        });
      }
    } else {
      uni.removeTabBarBadge({ index: 0 });
      if (route == 'pages/chat/index') {
        uni.setNavigationBarTitle({
          title: '新聊',
        });
      }
    }

    /** 朋友圈提示(优先显示消息条数，再提示好友动态) */
    num = _data.data('no_reader_circle_chat_num');
    let num2 = _data.data('no_reader_pay_num');
	let num3 = parseInt(num) + parseInt(num2);
    if (num3) {
      uni.setTabBarBadge({
        index: 2,
        text: (num2 + ''),
      });
     if(num) uni.$emit('data_circle_tips', num);
	 if(num2) uni.$emit('data_pay_tips', num2);
    }
    else {
      uni.removeTabBarBadge({ index: 2 });
      num = _data.data('no_reader_circle');
      if (num) {
        uni.showTabBarRedDot({ index: 2 });
        uni.$emit('data_circle_tips', '好友动态');
      } else {
        uni.hideTabBarRedDot({ index: 2 });
      }
    }
	
	

  },
  /** 路由守卫执行方法 */
  routeTool () {
    _data.data('isOnlie',true);
    let token = _data.localData('token');
    /** 没有token就跳转到登陆去获得token */
    if (!token) {
      uni.reLaunch({
        url: '/pages/in/login'
      });
      return;
    }
    /** 如果没有连接上socket,则连接 */
    if (!_data.data('socket_state')) {
      _mixins.methods.$reset().$reconnect();
    }
	
  },
  /** 验证失败后执行 */
  checkFail () {
    /** 好友申请通知 */
    _data.data('new_friend_tips_num', 0);
    /** 朋友圈通知 */
    _data.data('no_reader_circle', 0);
    /** 朋友圈消息未读数 */
    _data.data('no_reader_circle_chat_num', 0);
    /** 清空自己的头像保存的本地的临时地址 */
    let data = _data.data('cache');
    data.local_photo = '';
    _data.data('cache', data);
    /** 归档用户信息 */
    _data.data('user_info', {
      id: 0,
      nickname: '',
      username: '',
      photo: 'default_man/90.jpg',
      doodling: '',
      circle_img: 'default_circle_img.jpg',
    });
    uni.clearStorage();
    // /** 跳转到登陆界面 */
    // uni.reLaunch({
    //   url: '/pages/in/login'
    // });
  },
  /** 更新未读消息为0 */
  updataNoReader (list_id) {
    _mixins.methods.$httpSend({
      path: '/im/message/updataNoReader',
      data: { list_id: list_id },
    });
  },
  /** 下载自己的头像 */
  downloadPhoto () {
    let url =  _data.staticPhoto() + _data.data('user_info').photo;
    let data = _data.data('cache');
    uni.downloadFile({
      url: url,
      success: (res) => {
        console.log("download:",res)
        if (res.statusCode === 200) {
          data.local_photo = res.tempFilePath;
          if(!data.local_photo) data.local_photo = url
          _data.data('cache', data);
        }
      },
      fail(res) {
        data.local_photo = url;
        console.log(1111)
        _data.data('cache', data);
      }
    });
    if(!_data.data('cache').local_photo){
      data.local_photo = url;
      console.log("data",data)
      _data.data('cache', data);
    }
    console.log("_cache",_data.data('cache'))
    },
  /** 播放音效 */
  playVoice (path, loop) {
    innerAudioContext.src = path;
    innerAudioContext.loop = loop;
    // innerAudioContext.obeyMuteSwitch = false;
    innerAudioContext.play();
    innerAudioContext.onPlay(() => {
      //console.log('开始播放');
    });
    innerAudioContext.onError((res) => {
      innerAudioContext.destroy();
      return;
      uni.showToast({
        title: '音效播放错误 ->' + JSON.stringify(res),
        icon: 'none',
      });
    });
  },
  // 停止播放
  stopVoice () {
    console.log("停止")
    innerAudioContext.stop()
  },
  /** 时间戳转换 */
  timestampFormat (timestamp) {
    let curTimestamp = parseInt(new Date().getTime() / 1000), //当前时间戳
      timestampDiff = curTimestamp - timestamp, // 参数时间戳与当前时间戳相差秒数
      curDate = new Date(curTimestamp * 1000), // 当前时间日期对象
      tmDate = new Date(timestamp * 1000),  // 参数时间戳转换成的日期对象
      Y = tmDate.getFullYear(),
      m = tmDate.getMonth() + 1, d = tmDate.getDate(),
      H = tmDate.getHours(), i = tmDate.getMinutes(),
      s = tmDate.getSeconds();
    if (timestampDiff < 60) { // 一分钟以内
      return "刚刚";
    } else if (timestampDiff < 3600) { // 一小时前之内
      return Math.floor(timestampDiff / 60) + "分钟前";
    } else if (curDate.getFullYear() == Y && curDate.getMonth() + 1 == m && curDate.getDate() == d) {
      return '今天 ' + ((String(H).length == 1 ? '0' : '') + H) + ':' + ((String(i).length == 1 ? '0' : '') + i);
    } else {
      var newDate = new Date((curTimestamp - 86400) * 1000); // 参数中的时间戳加一天转换成的日期对象
      if (newDate.getFullYear() == Y && newDate.getMonth() + 1 == m && newDate.getDate() == d) {
        return '昨天 ' + ((String(H).length == 1 ? '0' : '') + H) + ':' + ((String(i).length == 1 ? '0' : '') + i);
      } else if (curDate.getFullYear() == Y) {
        return ((String(m).length == 1 ? '0' : '') + m) + '月' + ((String(d).length == 1 ? '0' : '') + d) + '日 ' + ((String(H).length == 1 ? '0' : '') + H) + ':' + ((String(i).length == 1 ? '0' : '') + i);
      } else {
        return Y + '年' + ((String(m).length == 1 ? '0' : '') + m) + '月' + ((String(d).length == 1 ? '0' : '') + d) + '日 ' + ((String(H).length == 1 ? '0' : '') + H) + ':' + ((String(i).length == 1 ? '0' : '') + i);
      }
    }
  },
  getStrCharLength(val) {
  var str = new String(val);
  var bytesCount = 0;
  for (var i = 0 ,n = str.length; i < n; i++) {
    var c = str.charCodeAt(i);
    if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
      bytesCount += 1;
    } else {
      bytesCount += 2;
    }
  }
  return bytesCount;
  },
}
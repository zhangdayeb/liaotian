import _data from './_data';
import _get from './_get';
import _mixins from './_mixins';
import _action from './_action';
import _page from "./common";
import SDK from "./tendenceImSdk";
// #ifdef APP-PLUS
let call = uni.requireNativePlugin('Html5App-TencentCall')
// #endif
export default {
  closeVoiceRoom(){
    uni.$emit('closeVoiceRoom',{})
  },
  getVoiceRoom(params){
    let route = _page.getRoute();
    if(route.indexOf('chat/message') > -1){
      _get.checkVoiceRoomState(params,function (ret) {
        //加入
          uni.$emit('memberJoinRoom',ret)
      })
    }
  },
  clientLink(data){
    _data.localData('client_id',data.client_id);
  },
  cancleVedio(data){
    // #ifdef APP-PLUS
    call.close();
    // #endif
    uni.$emit('close_call',data);
  },
  vedioData (data) {
	//判断是否在线发送视频邀请
	if(!_data.data('isOnlie')){
		_page.pushVedioLocalMsg(data);
	}else{
		uni.navigateTo({
		  url: '/pages/chat/videoCall?'+_page.pageParam(data)
		});
	}
    return true;
  },
  /** 验证token */
  checkToken (res) {
    if (res.err) {
      _action.checkFail();
    } else {
      /** 获取基础数据 */
      _get.base();
    }
  },
  /** 下线 */
  offline (res) {
    uni.showModal({
      content: '你的账号在另一客户端登陆，如果不是你本人操作，请修改你的密码',
      success(){
        _action.checkFail();
      },
    });
  },
  /** 获得会话列表 */
  getChatList () {
    _get.getChatList();
  },
  /** 获得好友列表 */
  getFriendList () {
    _get.getFriendList({ up: 1 });
  },
  /** 新好友提醒 */
  newFriend (data) {
    _action.playVoice('/static/voice/friend.mp3');
    let num = _data.data('new_friend_tips_num') + (data.num * 1);
    _data.data('new_friend_tips_num', num);
    _action.setStatusTips();
  },
  /** 点赞提醒 */
  circleLike (data) {
    _action.playVoice('/static/voice/circle.mp3');
    //通知朋友圈
    let circle_data = _data.localData('circle_data');
    for (let i = 0, j = circle_data.length; i < j; i++) {
      if (circle_data[i].post_id == data.id) {
        console.log('circleLike1...')
        circle_data[i].like = data.likes;
        circle_data[i].islike = data.action;
        _data.localData('circle_data', circle_data);
        uni.$emit('data_circle_data', circle_data);
        break;
      }
    }
    let circle_data_user = _data.localData('circle_data_user');
    for (let i = 0, j = circle_data_user.length; i < j; i++) {
      if (circle_data_user[i].post_id == data.id) {
        console.log('circleLike2...')
        circle_data_user[i].like = data.likes;
        circle_data_user[i].islike = data.action;
        _data.localData('circle_data_user', circle_data_user);
        uni.$emit('data_circle_data_user', circle_data_user);
        break;
      }
    }
  },
  addChatList(){ //田百合花

  },
  /** 接收新消息 */
  chatData (data) {
    if (!_data.localData('token'))return false;
    let chat_data = _data.localData(data.list_id),
         brate = _data.localData('DISTURB:'+data.list_id),
      msg_reader_num = 0;
    /** 如果不是自己的消息,在这条会话界面,震动提示，没有在这条会话界面，震动加声音提示 */
    if (_data.data('user_info').id != data.data.msg.user_info.uid) {
      // #ifdef APP-PLUS
	  _page.pushLocalMsg(data);

      if(brate == 0 || brate == undefined || brate == null){
         uni.vibrateLong();
      }
      // #endif
      //在列表则更新未读状态
      if (_data.localData('message_list_id') == data.list_id) {
        _action.updataNoReader(data.list_id);
      }
      else {
        //否则声音提示
        if(brate == 0 || brate == undefined || brate == null){
          _action.playVoice('/static/voice/chat.mp3');
        }

        msg_reader_num = 1;
      }
    }

    /** 更新对话列表数据 */
    let action_list_data = {};
    for (let i = 0, local_chat_list = _data.localData('chat_list'), j = local_chat_list.length; i < j; i++) {
      if (local_chat_list[i].list_id == data.list_id) {
        switch (data.data.msg.type * 1) {
          case 0:
            local_chat_list[i].last_msg = data.data.msg.content.text;
            break;
          case 1:
            /** 语音 */
            local_chat_list[i].last_msg = '[语音]';
            break;
          case 2:
            /** 图片 */
            local_chat_list[i].last_msg = '[图片]';
            break;
          case 3:
            /** 视频 */
            local_chat_list[i].last_msg = '[视频]';
            break;
          case 4:
            /** 文件 */
            local_chat_list[i].last_msg = '[文件]';
            break;
          case 5:
            /** 红包 */
            local_chat_list[i].last_msg = '[红包]';
            break;
          case 6:
            /** 在线视频 */
            local_chat_list[i].last_msg = '[在线视频]';
            break;
          case 7:
            /** 在线语音 */
            local_chat_list[i].last_msg = '[在线语音]';
            break;
          case 8:
            /** 名片 */
            local_chat_list[i].last_msg = '[名片]';
            break;
          case 9:
            /** 名片 */
            local_chat_list[i].last_msg = '[戳一戳]';
            break;
          default:
            /** 未知消息类型 */
            local_chat_list[i].last_msg = '[未知]';
            break;
        }
        local_chat_list[i].no_reader_num += msg_reader_num;
        local_chat_list[i].time = data.data.msg.time;
        local_chat_list.sort((x,y)=>{
          if(x.top >y.top){
            return -1;
          }
         if(x.time > y.time){
           return -1;
         }
        })
		 _data.localData('chat_list',local_chat_list);
        uni.$emit('data_chat_list', local_chat_list);
        action_list_data = local_chat_list[i];
        break;
      }
    }
    if(!Object.keys(action_list_data).length){
        //如果没有则新增
      action_list_data.list_id = data.list_id;
      action_list_data.chat_id = data.data.msg.id;
      action_list_data.no_reader_num = 1;
      action_list_data.photo_path = data.data.msg.user_info.face;
      action_list_data.show_name = data.data.msg.user_info.name;
      action_list_data.time = data.data.msg.time;
	  
      action_list_data.last_msg = data.data.msg.content.text;
      action_list_data.top = 0;
      action_list_data.top_time = 0;
      action_list_data.type = data.data.type;
      let chat_list =  _data.localData('chat_list');
      chat_list.splice(0,0,action_list_data);
      //排序首选根据top排序，然后根据time排序
	  chat_list = chat_list.slice(0,30);
      chat_list.sort((x,y)=>{
        if(x.top == y.top){
          y.time - x.time;
        }else {
          return y.top - x.top;
        }
      })
	  _data.localData('chat_list',chat_list);
      uni.$emit('data_chat_list', chat_list);
    }
    /** 在有这条对话的缓存数据情况下 */
    if (chat_data) {
      chat_data.list.push(data.data);
      chat_data.list = chat_data.list.slice(-15);
      _data.localData(data.list_id, chat_data);
      /** 如果在与对方的对话界面,发送数据到页面显示 */
      if (_data.localData('message_list_id') == data.list_id) {
        /** 保持页面15条数据，提升性能 */
        uni.$emit('data_chat_data_push', chat_data.list);
      }
    }
    _action.setStatusTips();
  },
  /** 接收好友朋友圈动态提示 */
  circleTips (data) {
    _action.playVoice('/static/voice/circle.mp3');
    _data.data('no_reader_circle', 1);
    _action.setStatusTips();
  },
  /** 接收朋友圈好友回复/赞通知 */
  cricleChatTips (data) {
    _action.playVoice('/static/voice/circle.mp3');
    let num = _data.data('no_reader_circle_chat_num');
    num++;
    _data.data('no_reader_circle_chat_num', num);
    _action.setStatusTips();
  },
  /** 撤回消息 */
  deleteChat (data) {
    let chat_data = _data.localData(data.list_id);
    for (let i = 0, j = chat_data.list.length; i < j; i++) {
      if (chat_data.list[i].msg.id == data.data.msg.id) {
        chat_data.list[i] = data.data;
        _data.localData(data.list_id, chat_data);
        uni.$emit('data_chat_data_delete', chat_data.list);
        break;
      }
    }
  },
  /** 加群申请 */
  chatGroupApply (data) {
    let local_data = _data.localData('group_apply_list');
    if (!local_data) {
      local_data = [];
    }
    local_data.push(data);
    _data.localData('group_apply_list', local_data);
    uni.$emit('data_group_apply_data', local_data);
    let num = _data.data('new_group_tips_num');
    num++;
    _data.data('new_group_tips_num', num);
    _action.playVoice('/static/voice/friend.mp3');
    _action.setStatusTips();
  },

  /** 通知群管理已处理 */
  groupChatApplyAllow (id) {
    let local_data = _data.localData('group_apply_list');
    for (let value of local_data) {
      if (value.id == id) {
        value.status = 1;
        value.text = '已接受';
        let num = _data.data('new_group_tips_num');
        num--;
        if (num < 0) {
          num = 0;
        }
        _data.data('new_group_tips_num', num);
      }
      break;
    }
    _data.localData('group_apply_list', local_data);
    uni.$emit('data_group_apply_data', local_data);
    _action.setStatusTips();
  },

  /** 解散群 */
  removeGroup (data) {
    /** 删除对话列表缓存数据 */
    for (let i = 0, local_chat_list = _data.localData('chat_list'), j = local_chat_list.length; i < j; i++) {
      if (local_chat_list[i].list_id == data.list_id) {
        local_chat_list.splice(i, 1);
        _data.localData('chat_list', local_chat_list);
        uni.$emit('data_chat_list', local_chat_list);
        break;
      }
    }
    /** 删除对话缓存数据 */
    _data.localData(data.list_id, null);
    uni.showModal({
      title: data.group_name + ' 群聊已经被群主解散了!',
    });
  },
  //付款消息
  payAmount(data){
	 _action.playVoice('/static/voice/chat.mp3');
	 let local_data = _data.data('data_pay_tips');
	 local_data = parseInt(local_data);
	 if(local_data <= 0){
		 local_data = 0
	 }
	 local_data++;
	 _data.data('data_pay_tips',local_data);
	 uni.$emit('pay_amount_after',data)
	 uni.$emit('data_user_info', data);
	 _data.data('user_info', data);
	  _action.setStatusTips();
  },
  collectAmount(data){
	   _action.playVoice('/static/voice/chat.mp3');
	   let user_info = data.user_info;
	   user_info.amount = data.amount;
	   uni.navigateTo({
			url:'/pages/pay/collect_money?'+_page.pageParam(user_info)
	   })
  },
  //在线支付成功通知
  onlinePaySuccess(data){
    uni.$emit('data_user_info', data);
    _data.data('user_info', data);
  },

  cricleComment(data){
    let comment = data.comment;
    let circle = _data.localData('circle_data');
    for (let i = 0, j = circle.length; i < j; i++) {
      if (circle[i].post_id == data.circle_id) {
        circle[i].comments.push(data.comment)
        _data.localData('circle_data', circle);
        uni.$emit('data_circle_data', circle);
        break;
      }
    }
    let circle_user = _data.localData('circle_data_user');
    for (let i = 0, j = circle_user.length; i < j; i++) {
      console.log('circle_user[i]:',circle_user[i])
      if (circle_user[i].post_id == data.circle_id) {
        circle_user[i].comments.push(data.comment)
        _data.localData('circle_data_user', circle_user);
        uni.$emit('data_circle_data_user', circle_user);
        break;
      }
    }
  },
  //购买成功通知
  payCircleOrder(data){
    console.log('payCircleOrder....')
    _action.playVoice('/static/voice/circle.mp3');
    //通知朋友圈
    let circle_data = _data.localData('circle_data');
    for (let i = 0, j = circle_data.length; i < j; i++) {
      if (circle_data[i].post_id == data.circle_id) {
        console.log('circle_data11[i]', circle_data[i])
        circle_data[i].can_pay_times = data.can_pay_times;
        _data.localData('circle_data', circle_data);
        uni.$emit('data_circle_data', circle_data);
        break;
      }
    }
    let circle_data_user = _data.localData('circle_data_user');
    for (let i = 0, j = circle_data_user.length; i < j; i++) {
      if (circle_data_user[i].post_id == data.circle_id) {
        circle_data_user[i].can_pay_times = data.can_pay_times;
        _data.localData('circle_data_user', circle_data_user);
        uni.$emit('data_circle_data_user', circle_data_user);
        break;
      }
    }
  },
  memberIsOnline(){ //消息提醒
    _action.playVoice('/static/voice/chat.mp3');
  },
  setMessagePageTitle(data){ //设置聊天页面的title
    console.log("设置标题:",data)
    let chat_data = _data.localData(data.list_id);
    chat_data.show_name = data.show_name;
    _data.localData(data.list_id,chat_data);
  },
  zhenDong(data){
    let user_id  =_data.data('user_info').id;
    console.log("USER_ID",user_id);
    if(user_id != data['user_id']){
      // #ifdef APP-PLUS
       uni.vibrateLong();
      // #endif
    }
  }
}
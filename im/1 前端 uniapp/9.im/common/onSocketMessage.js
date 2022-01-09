import store from './store/';
import _get from './_get';
import _action from './_action';

export default {
	/** 验证token */
	checkToken(res) {
		if(res.err){
			_action.checkFail();
		} else {
			/** 设置为登陆状态 */
			store.commit('set',{ k:'socket_state',v:1 });
			/** 获取基础数据 */
			_get.base();
		}
	},
	/** 下线 */
	offline(res){
		uni.showModal({
			content: '你的账号在另一客户端登陆，如果不是你本人操作，请修改你的密码',
			success(){
				_action.checkFail();
			},
		});
	},
	/** 获得会话列表 */
	getChatList(){
		_get.getChatList();
	},
	/** 获得好友列表 */
	getFriendList(){
		_get.getFriendList({ up: 1});
	},
	/** 新好友提醒 */
	newFriend(data){
		_action.playVoice('/static/voice/friend.mp3');
		let num = store.state.new_friend_tips_num + (data.num * 1);
		store.commit('set',{ k:'new_friend_tips_num',v:num });
		_action.setStatusTips();
	},
	/** 接收新消息 */
	chatData(data){
		let chat_data = store.state.page_data.chat_data,
		msg_reader_num = 1;
		if(chat_data[data.list_id]){
			// 如果在与对方的对话界面，更新这个对话的阅读(即反馈接收状态)
			if(store.state.page_data.message_query_list_id == data.list_id && store.state.user_info.id != data.data.msg.user_info.uid){
				_action.updataNoReader(data.list_id);
				msg_reader_num = 0;
			}
			store.state.page_data.chat_data[data.list_id].list.push(data.data);
		}
		
		/** 更新对话列表数据 */		
		for(let i = 0,j = store.state.page_data.chat_list.length;i < j;i ++){
			if(store.state.page_data.chat_list[i].list_id == data.list_id){
				let last_msg;
				switch(data.data.msg.type * 1){
					case 0:
						last_msg = data.data.msg.content.text;
						break;
					case 1:
						/** 语音 */
						last_msg = '[语音]';
						break;
					case 2:
						/** 图片 */
						last_msg = '[图片]';
						break;
					case 3:
						/** 视频 */
						last_msg = '[视频]';
						break;
					case 4:
						/** 文件 */
						last_msg = '[文件]';
						break;
					case 5:
						/** 红包 */
						last_msg = '[红包]';
						break;
					default:
						/** 未知消息类型 */
						last_msg = '[未知]';
						break;
				}
				store.state.page_data.chat_list[i].last_msg = last_msg;
				store.state.page_data.chat_list[i].no_reader_num += msg_reader_num;
				store.state.page_data.chat_list[i].time = data.data.msg.time;
				let action_list_data = store.state.page_data.chat_list[i];
				store.state.page_data.chat_list.splice(i,1);
				store.state.page_data.chat_list.unshift(action_list_data);
				break;
			}
		}
		
		/** 如果不是自己的消息，震动提示 */
		if(store.state.user_info.id != data.data.msg.user_info.uid){
			uni.vibrateLong();
			_action.playVoice('/static/voice/chat.mp3');
		}
	},
	/** 接收好友朋友圈动态提示 */
	circleTips(data){
		_action.playVoice('/static/voice/circle.mp3');
		store.commit('set',{ k:'no_reader_circle',v:1 });
		_action.setStatusTips();
	},
	/** 接收朋友圈好友回复/赞通知 */
	cricleChatTips(data){
		_action.playVoice('/static/voice/circle.mp3');
		let num = store.state.no_reader_circle_chat_num;
		num ++;
		store.commit('set',{ k:'no_reader_circle_chat_num',v:num });
		_action.setStatusTips();
	},
	/** 撤回消息 */
	deleteChat(data){
		let chat_data = store.state.page_data.chat_data;
		if(chat_data[data.list_id] && chat_data[data.list_id].list.length){
			for(let i = 0,j = chat_data[data.list_id].list.length;i < j;i++ ){
				if(chat_data[data.list_id].list[i].msg.id == data.msg_id){
					store.state.page_data.chat_data[data.list_id].list.splice(i,1);
					break;
				}
			}
		}
	},
}
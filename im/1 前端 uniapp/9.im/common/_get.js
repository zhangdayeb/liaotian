import _mixins from './_mixins';
import _action from './_action';
import _data from './_data';

export default {
	/** 获得会话列表数据 */
	getChatList(){
		_mixins.methods.$httpSend({
			path: '/im/get/chatList',
			success(data) {
				// data.hasData = 1;
				// if(!data.length)data.hasData = 0;
				if(data.length){
					data.sort((x,y)=>{
						if(x.top == y.top){
							return y.time - x.time;
						}else {
							return y.top - x.top;
						}
					})
				}
				_data.localData('chat_list',data);
				uni.$emit('data_chat_list',data);
				_action.setStatusTips();
			}
		});
	},
	getGroupChatList(data,sucess){
		_mixins.methods.$httpSend({
			path: '/im/get/chatList',
			data:data,
			success(data) {
				console.log(1111)
				if(sucess){
					sucess(data)
				}
			}
		});
	},
   /**
	 * 获得对话数据 
	 * @param {
			发送的数据
			send_data: {
				list_id: list_id,
				time: 0,
				是否更新未读消息数
				is_up: 1,
			},
			回调函数
			calllback(data){
				
			},
			是否需要操作本地缓存数据
			is_action_data: 1,
		}
	 */
	getChatData(config){
		_mixins.methods.$httpSend({
			path: '/im/get/chatData',
			data: config.send_data,
			success(data) {
				// console.log('12312311213',data)
				if(config.is_action_data){
					uni.$emit('data_chat_data',data);
					_data.localData(data.list_id,data);
				}
				else{
					uni.$emit('data_chat_data_unshift',data.list);
				}
				if('callback' in config){
					config.callback(data);
				}
			}
		});
	},
	/** 获得通讯录数据 */
	getFriendList(send_data,callback){
		if(!send_data){
			send_data = {};
		}
		_mixins.methods.$httpSend({
			path: '/im/get/friendList',
			data: send_data,
			success(data) {
				if(data.data.length || 'up' in send_data || Object.keys(data.data).length){
					_data.localData('friend_list',data.data);
					uni.$emit('data_friend_list',data.data);
				}
				if(callback){
					callback(data);
				}
			}
		});
	},
	/** 获得朋友圈数据 data要发送的数据 type 0加载最新数据 1加载历史数据 */
	getCircleList(send_data,callback){
		_mixins.methods.$httpSend({
			path: '/im/get/circleData',
			data: send_data,
			success(data) {
				let key1 = 'circle_data',_data_key1 = 'data_circle_data';
				let circle_data = _data.localData(key1);
				if(!circle_data){
					circle_data = [];
				}
				if(send_data.type){
					circle_data.push(...data.data);
				} else {
					circle_data.unshift(...data.data);
				}
				uni.$emit(_data_key1,circle_data);
				_data.localData(key1,circle_data);
				if('update' in send_data){
					let key2 = 'circle_data_user',_data_key2 = 'data_circle_data_user';
					let circle_data2 = _data.localData(key2);
					if(!circle_data){
						circle_data = [];
					}
					if(send_data.type){
						circle_data2.push(...data.data);
					} else {
						circle_data2.unshift(...data.data);
					}
					uni.$emit(_data_key2,circle_data2);
					_data.localData(key2,circle_data2);
				}
				if(callback) {
					callback(data);
				}
			}
		});
	},
	/** 获得基础数据 */
	getUserCircleList(send_data,callback){
		console.log('to')
		_mixins.methods.$httpSend({
			path: '/im/get/circleData',
			data: send_data,
			success(data) {
				console.log(1111111)
				let key2 = 'circle_data_user',_data_key2 = 'data_circle_data_user';
				let circle_data2 = _data.localData(key2);
				if(!circle_data2){
					circle_data2 = [];
				}
				if(send_data.type){
					circle_data2.push(...data.data);
				} else {
					circle_data2.unshift(...data.data);
				}
				uni.$emit(_data_key2,circle_data2);
				_data.localData(key2,circle_data2);

				if(callback) {
					callback(data);
				}
			}
		});
	},
	base(){
		_mixins.methods.$httpSend({
			path: '/im/get/base',
			success(data) {
				data.user_info.photo += '?_=' + Math.random();
				data.user_info.circle_img += '?_=' + Math.random();
				
				_data.data('user_info',data.user_info);
				uni.$emit('data_user_info',data.user_info);
				
				_data.data('new_friend_tips_num',data.new_friend_tips_num);
				_data.data('no_reader_chat_num',data.no_reader_chat_num);
				_data.data('no_reader_circle',data.no_reader_circle);
				_data.data('no_reader_circle_chat_num',data.no_reader_circle_chat_num);
				_data.data('new_group_tips_num',data.new_group_tips_num);

				_data.data('kefu_list_id',data.kefu_list_id);
				_action.setStatusTips();
				_action.downloadPhoto();
			}
		});
	},
	/** 获得好友申请列表数据 */
	getFriendApplyList(callback){
		_mixins.methods.$httpSend({
			path: '/im/get/applyFriend',
			success(data) {
				_data.localData('friend_apply_list',data);
				uni.$emit('data_friend_apply_list',data);
				if(callback){
					callback(data);
				}
			}
		});
	},
	/** 获得群认证列表数据 */
	getGroupApplyList(callback){
		_mixins.methods.$httpSend({
			path: '/im/get/applyGroup',
			success(data) {
				_data.localData('group_apply_list',data);
				uni.$emit('data_group_apply_data',data);
				if(callback){
					callback(data);
				}
			}
		});
	},
	//搜索聊天记录
	serchChatMsg(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/get/searchCahtMsg',
			data:params,
			success(data) {
				if(callback){
					callback(data);
				}
			}
		});
	},
	//搜索好友
	searchFriends(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/get/searchFriends',
			data:params,
			success(data) {
				if(callback){
					callback(data);
				}
			}
		});
	},
	//取消音/视频
	cancelCall(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/message/closeVideo',
			data: params,
			success (res) {
				if(callback){
					callback(res);
				}
			}
		});
	},
	//同意/音视频
	agreeVedio(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/message/agreeVedio',
			data: params,
			success (res) {
				if(callback){
					callback(res);
				}
			}
		});
	},
	createHongBao(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/message/createHongBao',
			data: params,
			success (res) {
				if(callback){
					callback(res);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	checkBeforePay(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/user/checkBeforePay',
			data: params,
			success (res) {
				if(callback){
					callback(res);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getHongBao(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/message/getHongBao',
			data: params,
			success (res) {
				if(callback){
					callback(res);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getUserCapitalList(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/get/getUserCapitalList',
			data: params,
			success (res) {
				if(callback){
					callback(res);
				}
			},
		});
	},
	getUserbankList(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/get/getUserbankList',
			data: params,
			success (res) {
				if(callback){
					callback(res);
				}
			},
		});
	},
	addUserBank(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/get/addUserBank',
			data: params,
			success (fireParams) {
				uni.$emit('update_bank_list_data',fireParams);
				if(callback){
					callback(fireParams);
				}
			},
		});
	},
	setUserTradePassword(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/user/setUserTradePassword',
			data: params,
			success (fireParams) {
				if(callback){
					callback(fireParams);
				}
			},
		});
	},
	checkUserTradePassword(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/user/checkUserTradePassword',
			data: params,
			success (fireParams) {
				if(callback){
					callback(fireParams);
				}
			},
		});
	},
	sendContact(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/app/setUserContact',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
		});
	},
	getOnlineList(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/agent/getOnlineList',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
		});
	},
	sendCard(params,callback){ //发送名片
		_mixins.methods.$httpSend({
			path: '/im/message/sendCard',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
		});
	},
	getHongBaoDetail(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/get/getHongBaoDetail',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
		});
	},
	getUserInfo(params,callback){
		_mixins.methods.$httpSend({
			path: '/im/get/getUserInfo',
			data: params,
			success (ret) {
				console.log(ret)
				_data.data('user_info',ret);
				uni.$emit('data_user_info',ret);
				if(callback){
					callback(ret);
				}
			},
		});
	},
	payAmount(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/user/payAmount',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	collectAmount(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/user/collectAmount',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	charge(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/pay/userCharge',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getVedioPayConfig(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/get/getVedioPayConfig',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	payCicleOrder(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/pay/payCircleOrder',
			data: params,
			success (ret) {
				//更新状态
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getUserOrderList(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/order/getUserOrderList',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	updateOrderStatus(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/order/updateOrderStatus',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	payVideoAamount(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/pay/payVideoAamount',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	updateUserSayType(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/action/updateUserSayType',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getWithDrawConfig(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/withdraw/getWithDrawConfig',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	withDrawMoney(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/withdraw/withDrawMoney',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	updateMiaoqiang(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/bigRegQiang',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	createLeiHongBao(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/createLeiHongBao',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
    getLeiHongBao(params,callback,fail_callback){
        _mixins.methods.$httpSend({
            path: '/im/vendor/getLeiHongBao',
            data: params,
            success (ret) {
                if(callback){
                    callback(ret);
                }
            },
            fail_callback(res){
                if(fail_callback){
                    fail_callback(res)
                }
            }
        });
    },
	setHongBaoConfig(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/setHongBaoConfig',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getUserVendor(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/getUserVendor',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getVendorInfo(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/getVendor',
			data: params,
			success (ret) {
				console.log("dasdsada")
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				console.log("dasdsada")
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
    getSysConfig(params,callback,fail_callback){
        _mixins.methods.$httpSend({
            path: '/im/App/config',
            data: params,
            success (ret) {
                if(callback){
                    callback(ret);
                }
            },
            fail_callback(res){
                if(fail_callback){
                    fail_callback(res)
                }
            }
        });
    },
	getSms(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/App/getSms',
			data: params,
			success (ret) {
				console.log(ret)
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	vendorLogin(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/in/vendorLogin',
			data: params,
			success (ret) {
				console.log(ret)
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getRobotList(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/getRobotList',
			data: params,
			success (ret) {
				console.log(ret)
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	addRobot(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/addRobot',
			data: params,
			success (ret) {
				console.log(ret)
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	tuiQun(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/robotTuiQun',
			data: params,
			success (ret) {
				console.log(ret)
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	autoBigRed(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/robotAutoHongbao',
			data: params,
			success (ret) {
				console.log(ret)
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	updateUserTradePassword(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/updateUserTradePassword',
			data: params,
			success (ret) {
				console.log(ret)
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	checkSmsCode(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/app/checkSmsCode',
			data: params,
			success (ret) {
				console.log(ret)
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	saveGroupNickName(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/saveGroupNickName',
			data: params,
			success (ret) {
				console.log(ret)
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	//群成员列表
	getMemberList(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/getMemberList',
			data: params,
			success (ret) {
				console.log(ret)
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	groupAdd(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/message/addChat',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getInviteName(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/getInviteName',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	zhendong(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/zhendong',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getGroupDetail(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/getGroupDetail',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	copyNewQun(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/copyNewQun',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getExpireBigRed(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/getExpireBigRed',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	sendChuoYiChuoMsg(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/sendChuoYiChuoMsg',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getCapitalList(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/getUserCapitalList',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getArticleList(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/getArticleList',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	getArticleDetail(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/getArticleDetail',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
    getUserStore(params,callback,fail_callback){
        _mixins.methods.$httpSend({
            path: '/im/vendor/getUserStore',
            data: params,
            success (ret) {
                if(callback){
                    callback(ret);
                }
            },
            fail_callback(res){
                if(fail_callback){
                    fail_callback(res)
                }
            }
        });
    },
    getStoreStatics(params,callback,fail_callback){
        _mixins.methods.$httpSend({
            path: '/im/vendor/getStoreStatics',
            data: params,
            success (ret) {
                if(callback){
                    callback(ret);
                }
            },
            fail_callback(res){
                if(fail_callback){
                    fail_callback(res)
                }
            }
        });
    },
    deleteStore(params,callback,fail_callback){
        _mixins.methods.$httpSend({
            path: '/im/vendor/deleteStore',
            data: params,
            success (ret) {
                if(callback){
                    callback(ret);
                }
            },
            fail_callback(res){
                if(fail_callback){
                    fail_callback(res)
                }
            }
        });
    },
    getMemberPhotos(params,callback,fail_callback){
        _mixins.methods.$httpSend({
            path: '/im/vendor/getMemberPhotos',
            data: params,
            success (ret) {
                if(callback){
                    callback(ret);
                }
            },
            fail_callback(res){
                if(fail_callback){
                    fail_callback(res)
                }
            }
        });
    },
	transMsg(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/transMsg',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	joinVoiceRoom(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/joinVoiceRoom',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	setVoiceRoomMsg(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/setVoiceRoomMsg',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	memberjoinVoiceRoom(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/memberjoinVoiceRoom',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	checkVoiceRoomState(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/vendor/checkVoiceRoomState',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	},
	xiaoHui(params,callback,fail_callback){
		_mixins.methods.$httpSend({
			path: '/im/group/xiaoHuiMessage',
			data: params,
			success (ret) {
				if(callback){
					callback(ret);
				}
			},
			fail_callback(res){
				if(fail_callback){
					fail_callback(res)
				}
			}
		});
	}
}
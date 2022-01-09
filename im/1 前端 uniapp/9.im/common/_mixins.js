import _data from './_data';
import _onSocket from './_onSocket';

/**
 * socket 发送用到的一个函数
 */
function stringSource(s)
{
	let i = 0;
	return () => {
		return i < s.length ? s.charCodeAt(i++) : null;
	};

}

let params  = {
	timeout: 18000,
	timeout2: 22000,
	timeoutObj: null,
	serverTimeoutObj: null,
	lockReconnect : false,
	tt:false,
	maxConnect:3,
	status:false,
	lockSend:false
}

export default {
	/** 添加方法时,方法name前加$以避免与页面方法冲突 */
	methods: {
	
		/**
		 *  http 请求
		 *  config object
		 *  {
		 *      path: string, 请求路径
		 *	 	data: object, 发送数据
		 * 		success: function, 回调
		 * 		fail: function, 错误回调
		 * 		type: string 请求方式(默认post)
		 * 		success_action: boolean err状态不为0时是否执行success回调(默认是err状态不为0就只提示msg而不执行success回调)
		 * 		check: false 是否验证登陆默认不验证
		 *	}
		 */
		getCurPage(){
			let pages = getCurrentPages();
			let curPage = pages[pages.length-1];
			return curPage
		},
		$reconnect(cb,sendData){
			if(params.lockReconnect  || params.maxConnect <= 0 || _data.data("socket_state") > 0){
				return false;
			}
			_data.data('socket_state',0);
			clearTimeout(params.timeoutObj);
			clearTimeout(params.serverTimeoutObj);
			uni.closeSocket();
			params.lockReconnect = true;
			params.status = false;
			params.maxConnect --;
			if(sendData != undefined){
				this.$socketSend(sendData,cb);
			}else {
				this.$sendWithPingToken(cb);
			}
		},
		$sendWithPingToken(cb){
			this.$socketSend({'action':'ping','data':_data.localData('token')},cb);
		},
		$reset(){
			params.status = false;
			params.lockReconnect = false;
			params.maxConnect = 3;
			params.lockSend = false;
			clearTimeout(params.timeoutObj);
			clearTimeout(params.serverTimeoutObj);
			return this;
		},
		$sendWithToken(cb){
			if(params.lockSend){
				return false;
			}
			params.lockSend = true;
			this.$socketSend({
				action: 'checkToken',
				data: _data.localData('token'),
			},cb);
		},
		$start(){
			if(params.status){
				return false;
			}
			params.status = true;
			let self = this;
			clearTimeout(params.serverTimeoutObj);
			clearTimeout(params.timeoutObj);
			params.timeoutObj = setTimeout(function () {
				//这里发送一个心跳，后端收到后，返回一个心跳消息，
				//onmessage拿到返回的心跳就说明连接正常
				self.$sendWithPingToken();
				params.serverTimeoutObj = setTimeout(function () { // 如果超过一定时间还没重置，说明后端主动断开了
					uni.closeSocket();;//如果onclose会执行reconnect，我们执行 websocket.close()就行了.如果直接执行 reconnect 会触发onclose导致重连两次
				}, params.timeout2)
			}, params.timeout)
		},
		$requestSend(config){
			let header = {
				/** 这里设置为简单跨域，只会请求一次 */
				'Content-Type': 'application/x-www-form-urlencoded',
			};
			let send_data = ('data' in config ? config.data : {}),
			url = _data.data('http_url') + config.path;
			send_data['_token'] = _data.localData('token');
			send_data['_agent_id'] = _data.data('agent_id');
			let _this = this;
			uni.request({
				url: url,
				data: send_data,
				method: ('type' in config ? config.type : 'POST'),
				header: header,
				dataType: 'json',
				success(res) {
					if(res.statusCode == 200){
						if(('success_action' in config) && config.success_action ){
							config.success(res.data);
						}
						else {
							if(res.data.err){
								/** 不显示未登录提示 */
								console.log( config.path);
								if(send_data['_token'] || config.path.indexOf('/in/') > -1 ||  config.path.indexOf('/App/') > -1){
									//执行错误回调
									console.log(JSON.stringify(res));
									if(('fail_callback' in config) &&  config.fail_callback){
										config.fail_callback(res.data);
									}else {
										uni.showToast({
											title: res.data.msg,
											duration: 1000,
											icon:"none"
										});
									}
								}
							}
							else {
								if('success' in config){
									config.success(res.data.data);
								}
							}
						}
					} else {
						//TODO websoket 重连
						uni.showToast({
							title: '您的网络好像出了点状况哦',
							duration: 1000,
							icon:"none"
						});
						// uni.showModal({
						// 	content: 'server error：' + JSON.stringify(res.data),
						// });
					}
				},
				fail(err) {
					if('fail' in config){
						config.fail(err);
					}else{
						return;
						uni.showModal({
							content: JSON.stringify(err),
						});
					}
				}
			});
		},
		$httpSend(config){
			let _this = this;
			_this.$requestSend(config);
		},
		
		/**
		 * 通过 websocket 发送数据,
		 * 如果还没有连接 websocket 就先连接websocket,过两秒等websocket连接上了发送本次的数据,如果两秒后还是没有连接上，则舍弃这次发送数据，
		 * 如果发送的值为空则只连接
		 * 	@param data object 
		 * 	{
		 *		action: 'model.controller.action',
		 *		data: {}
		 *	}
		 */
		$socketSend(send_data,cb){
			let self = this;
			/** callback1是连接,callback2是发送 */
			((callback1,callback2) => {
				if(send_data && _data.data('socket_state')){
						callback2(send_data);
				}else{
					callback1(callback2,send_data);
				}
			})((callback,send_data) => {
				uni.connectSocket({
					url: _data.data('socket_url'),
					header: {
						'content-type': 'application/json',
					},
					// protocols: [ 'protocol1' ],
					method: 'GET',
					success(){
						_data.data('socket_state',1);
					},
					fail(err){
						self.$reset().$reconnect();
					}
				});
				uni.onSocketOpen((res) => {
					self.$reset().$start();
					/** 绑定服务器消息事件 */
					uni.onSocketMessage((res) => {
						self.$reset().$start();
						res = JSON.parse(res.data);
						if(!(res.action in _onSocket)){
							if(res.action != 'ping' && res.type != 'ping' ){
								uni.showModal({
									content: '接受到无效的消息',
								});
							}
						} else {
							console.log("接收到消息:",res.action)
							_onSocket[res.action](res.data);
						}

						return;
						/** 下面的写法二进制接收数据不兼容APP */
						
						if (res.data instanceof Blob) {
							/** js中的blob没有没有直接读出其数据的方法，通过FileReader来读取相关数据 */
							let reader = new FileReader();
							reader.readAsDataURL(res.data);							
						    /** 当读取操作成功完成时调用. */
							reader.onload = function(evt){								
								let data = JSON.parse(((str) => {
									/**  base64编码解析 */
									if(str.indexOf(',') > -1){
										str = str.split(',')[1];
									}
									return decodeURIComponent(atob(str).split('').map((c) => {
									    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
									}).join(''));
								})(evt.target.result));
								if(!(data.action in _onSocket)){
									if(data.action != 'ping'){
									}
									return;
								}
								_onSocket[data.action](data.data);
							}
						}
					});
					
					/** 这里发送token到服务器验证 */						
					callback({
						action: 'checkToken',
						data: _data.localData('token'),
					});
					
					/** 这里如果有需要发送的数据，就等待2s再进行发送，如果2s后，token验证还是不合法，就舍弃这次的发送 */
					if(send_data) {
						if(_data.localData('token')){
							callback(send_data);
						}else {
							callback({
								action: 'checkToken',
								data: _data.localData('token'),
							});
						}
					}
					
				});
				
				uni.onSocketClose((err) => {
					_data.data('socket_state',0);
					params.lockReconnect = false;
					self.$reconnect();
				});
				
				uni.onSocketError((err) => {
					_data.data('socket_state',0);
					params.lockReconnect = false;
					self.$reconnect();
				});
			},
			(send_data) => {
				
				uni.sendSocketMessage({
					data: JSON.stringify(send_data),
					fail(err){
						return;
						uni.showModal({
							content: JSON.stringify(err) + '---发送消息失败',
						});
					},
					success(res) {
						if(cb !=undefined ){
							cb();
						}
					}
				});
				
				return true;
			});	
		},
		
		/** 
		 * http发送文件(图片、文件、语音)
		 * @param json obj 
		 * {
			local_url: string * 在不调用上传控件的时候的本地文件地址
			data: json obj * 上传的数据
			success: function * 上传成功回调
			fail: function * 上传失败回调
			type: int 0对话上传文件 1上传头像 2朋友圈上传文件 3朋友圈背景图片上传 4群头像上传
			onProgressUpdate: function 上传进度监听
		   }
		 */
		$httpSendFile(config){
			if(!config){
				config = {};
			}
			let send_data = ('data' in config ? config.data : {});
			send_data['_token'] = _data.localData('token');
			
			((callback) => {
				switch (config.type){
					/** 对话上传文件 */
					case 0:
						callback(config.local_url,'/im/upload/chat');
						break;
					/** 上传头像 */
					case 1:
						callback(config.local_url,'/im/upload/photo');
						break;
					/** 朋友圈上传文件 */
					case 2:
						callback(config.local_url,'/im/upload/circle');
						break;
					/** 朋友圈背景图片上传 */
					case 3:
						callback(config.local_url,'/im/upload/circleImg');
						break;
					/** 群头像上传 */
					case 4:
						callback(config.local_url,'/im/upload/groupPhoto');
						break;
					default:
						uni.showModal({
							content: '无效的操作',
						});
						break;
				}
			})((local_url,action_path) => {
				console.log("local_url",local_url)
				let uploadTask = uni.uploadFile({
					url: (_data.data('static_url') + action_path),
					filePath: local_url,
					name: 'file',
					/** formData必须要有值，否则会上传失败 */
					formData: send_data,
					success: (res) => {
						if(res.statusCode == 200){
							if('success' in config){
								console.log(res.data);
								res.data = JSON.parse(res.data);
								if(res.data.err){
									if('fail' in config){
										config.fail(err);
									} else {
										uni.showModal({
											content: res.data.msg,
										});
									}
								}else{
									config.success(res.data.data);
								}
							}
						}
					},
					fail(err){
						if('fail' in config){
							config.fail(err);
						} else {
							uni.showModal({
								content: JSON.stringify(err),
							});
						}
					}
				});
				uploadTask.onProgressUpdate((res) => {
					
					if('onProgressUpdate' in config){
						config.onProgressUpdate();
					}
					
					return;
				});
			});
		},
		
	}
}
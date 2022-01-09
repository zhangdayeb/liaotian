export default {
	/**
	 * [设置获取globalData数据]
	 * @param {Object} k 设置/获取的键
	 * @param {Object} v 设置的值,没有传值就是获取这个键的值
	 * @return {String|Array|Object}
	 */
	data(k,v){
		if(v === undefined){
			return getApp().globalData[k];
		}
		else{
			getApp().globalData[k] = v;
		}
	},
	/**
	 * [设置获取保存在本地的页面数据]
	 * @param {Object} k 设置/获取的键
	 * @param {Object} v 设置的值,v为undefined获取这个键的值,v为null,移除这个键的数据
	 * @return {String|Array|Object}
	 */
	localData(k,v){
		if(v === undefined){
			return uni.getStorageSync(k);
		}
		else if(v === null){
			uni.removeStorage({
				key: k,
				fail(){
				}
			});
		}
		else {
			uni.setStorage({
				key: k,
				data: v,
				fail(){
				}
			});
		}
	},
	domainUrl(){
		return getApp().globalData.http_url
	},
	/** 聊天静态文件地址 */
	staticChat(){
		return getApp().globalData.static_url + '/static/chat/';
	},
	/** 朋友圈静态文件地址 */
	staticCircle(){
		return getApp().globalData.static_url + '/static/circle/';
	},
	/** 头像地址 */
	staticPhoto(){
		return getApp().globalData.static_url + '/static/photo/';
	},
    /** 视频图片地址 */
    staticVideoImg(){
        return getApp().globalData.static_url + '/static/photo/video_gif/';
    },
	/** 获取会话界面有多少未读消息 */
	chatTipsNum(){
		let num = 0,
		chat_list = uni.getStorageSync('chat_list');
		if(chat_list){
			for(let value of chat_list){
				num += (value.no_reader_num * 1);
			}
		}
		return num;
	},
	//根据网络地址获取本地地址
	getDowndloadVedio(url,cb){
		//ifdef H5
			return url;
		//endif
		 let _this = this;
		 let key = 'VEDIO_URL_'+ url;
		let address = this.localData(key);
        console.log(address)
		if(address == undefined || address == null || !address){
			const downloadTask = uni.downloadFile({
				url: url, //仅为示例，并非真实的资源
				success: (res) => {
					if (res.statusCode === 200) {
						uni.saveFile({
							tempFilePath: res.tempFilePath,
							success: function(red) {
								//下载到本地下次秒读取
								address = red.savedFilePath
								_this.localData(key,address);
								if(cb)cb(address)
							}
						});
					}

				}
			});
			downloadTask.onProgressUpdate((res) => {
				console.log('下载进度' + res.progress);
				console.log('已经下载的数据长度' + res.totalBytesWritten);
				console.log('预期需要下载的数据总长度' + res.totalBytesExpectedToWrite);
			});
		}else {
			if(cb)cb(address);
			return address
		}
	}
}
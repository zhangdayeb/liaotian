<template>
    <view class="page">
        <view class="uni-textarea">
            <textarea auto-height v-model="content" :maxlength="-1" placeholder="填写内容，1-600字" />
        </view>
    </view>
</template>

<script>
	
	import _get from '../../common/_get';
	import _hook from '../../common/_hook';
	import _data from '../../common/_data';
	
	export default {
		components:{
			
		},
		data() {
			return {
				content: '',
				type: '',
				list_id: 0,
				show_type: {
					name: {
						title: '群名称',
					},
					notice: {
						title: '群公告',
					}
				}
			}
		},
		onShow(){
			_hook.routeSonHook();
		},
		onLoad(option){
			let _this = this;
			_this.type = option.type;
			_this.list_id = option.list_id;
			uni.setNavigationBarTitle({
				title: (_this.show_type[_this.type].title + '设置'),
			});
			_this.$httpSend({
				path: '/im/message/getGroupData',
				data: { list_id: this.list_id,type: _this.type, },
				success(data) {
					_this.content = data;
				}
			});
		},
		computed: {
			
		},
		methods:{
			send(){
				let _this = this;
				_this.$httpSend({
					path: '/im/message/setGroupData',
					data: { content: _this.content,type: _this.type,list_id: _this.list_id, },
					success(data) {
						
						/** 如果是修改群名称，重新获得会话列表,和当前会话数据 */
						if(_this.type == 'name'){
							
							let chat_data = _data.localData(_this.list_id);
							chat_data.show_name = data.show_name;
							_data.localData(_this.list_id,chat_data);
							
							let chat_list = _data.localData('chat_list');
							for(let i = 0,j = chat_list.length;i < j;i ++){
								if(chat_list[i].list_id == _this.list_id){
									chat_list[i].show_name = _this.content;
									_data.localData('chat_list',chat_list);
									uni.$emit('data_chat_list',chat_list);
									break;
								}
							}
							
						}
						
						uni.showToast({
							title: '保存成功',
							duration: 2000
						});
						setTimeout(() => {
							uni.navigateBack();
						},2000);
					}
				});
			},
			radioChange(e){
				this.info[this.show_type[this.type].key] = e.target.value;
			},
		},
		onNavigationBarButtonTap(e) {
			this.send();
		},
		watch: {
			
		},
	}
</script>

<style>
    .page{
        margin-top: 15px;
        height: 300px;
        background-color: white;

    }
    page{
    }
</style>
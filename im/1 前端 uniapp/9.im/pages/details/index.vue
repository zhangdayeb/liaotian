<template>
    <view class="page">
        <view class="uni-list my_padding">
            <view class="uni-list-cell">
                <view class="uni-media-list uni-list-cell-navigate" style="flex-direction: row;">
                    <view class="phto2">
                        <image :src="userPhoto" :lazy-load="true" @tap="showPhoto()"/>
                    </view>
                    <view class="uni-media-list-detail" style="height: aotu;">
                        <view class="uni-media-list-text-top">{{my.nickname}} <image class="sex_type"  :src="'../../static/theme/default/details/' + my.sex + '.png'" :lazy-load="true"  /></view>
                        <view class="uni-media-list-info">
                            昵称: 	{{my.nickname}}
                        </view>
                        <view class="uni-media-list-info">
                            账号: {{my.username}}
                        </view>
                        <!--<view class="uni-media-list-info">-->
                        <!--地区:	-->
                        <!--</view>-->
                        <view class="uni-media-list-text-bottom uni-ellipsis"></view>
                    </view>
                </view>
            </view>
        </view>

        <view class="uni-card" v-if="isRemarks">
            <navigator hover-class="none" :url="'/pages/friend/remarks?user_id=' + user_id" animation-type="slide-in-bottom">
                <view class="uni-list">
                    <view class="uni-list-cell" hover-class="none">
                        <view class="uni-list-cell-navigate uni-navigate-right">
                            <view style="width:100%">
                                设置备注和标签
                            </view>
                        </view>
                    </view>
                </view>
            </navigator>
        </view>

        <view class="uni-card" v-if="is_in">
            <view class="uni-list">
                <view class="uni-list-cell" hover-class="none">
                    <view class="uni-list-cell-navigate">
                        <view style="width:100%;">
                            验证信息 <view class="show_text">{{my.content}}</view>
                        </view>
                    </view>
                </view>
            </view>
        </view>

        <view class="uni-card">
            <view class="uni-list">
                <view class="uni-list-cell" hover-class="none">
                    <view class="uni-list-cell-navigate">
                        <view style="width:100%;">
                            个性签名<view class="show_text">{{my.doodling}}</view>
                        </view>
                    </view>
                </view>
            </view>
        </view>

        <view class="uni-card" @tap="goCircle">
            <view class="uni-list">
                <view class="uni-list-cell" hover-class="none">
                    <view class="uni-list-cell-navigate uni-navigate-right friend_cricle">
                        <view class="cricle_title">朋友圈</view>
                        <view class="uni-media-list-logo cricle_img"
                              v-for="(img,img_index) in my.show_friend.circle"
                              :key="img_index">
                            <image :src="staticPath + img" style="border-radius: 8upx;" />
                        </view>
                    </view>
                </view>
            </view>
        </view>

        <view class="uni-card" v-if="isFrom">
            <view class="uni-list">
                <view class="uni-list-cell" hover-class="none">
                    <view class="uni-list-cell-navigate">
                        <view style="width:100%">
                            来 源 <view class="show_text">{{my.from}}</view>
                        </view>
                    </view>
                </view>
            </view>
        </view>
        <view class="uni-card" v-if="type == 1" @tap="memberDetail">
            <view class="uni-list">
                <view class="uni-list-cell" hover-class="none">
                    <view class="uni-list-cell-navigate">
                        <view style="width:100%">
                            邀请人 <view class="show_text">{{invite_name}}</view>
                        </view>
                    </view>
                </view>
            </view>
        </view>
        <!--<view class="uni-card" v-if="isFrom && type == 1">-->
            <!--<navigator hover-class="none" :url="'/pages/chat/message/reduce?list_id=' + list_id" animation-type="slide-in-bottom">-->
                <!--<view class="uni-list">-->
                    <!--<view class="uni-list-cell" hover-class="none">-->
                        <!--<view class="uni-list-cell-navigate uni-navigate-right">-->
                            <!--<view style="width:100%">-->
                                <!--移除本群-->
                            <!--</view>-->
                        <!--</view>-->
                    <!--</view>-->
                <!--</view>-->
            <!--</navigator>-->
        <!--</view>-->
        <view class="uni-card" v-if="my.is_friend">
            <view class="uni-list">
                <view class="uni-list-cell" hover-class="none" v-if="my.show_friend.phone">
                    <view class="uni-list-cell-navigate">
                        <navigator hover-class="none" >
                            <view style="width:100%">
                                手机号码 <view class="show_text">{{my.show_friend.phone}}</view>
                            </view>
                        </navigator>
                    </view>
                </view>
                <view class="uni-list-cell" hover-class="none" v-if="0">
                    <view class="uni-list-cell-navigate uni-navigate-right">
                        <navigator hover-class="none" url="/pages/details/more">
                            <view style="width:100%">
                                更多信息
                            </view>
                        </navigator>
                    </view>
                </view>
            </view>
        </view>
        <view class="uni-card" @tap="goKefu">
            <view class="uni-list">
                <view class="uni-list-cell" hover-class="none" >
                    <view class="uni-list-cell-navigate uni-navigate-right">
                        <view hover-class="none">
                            <view style="width:100%">
                                举报
                            </view>
                        </view>
                    </view>
                </view>
            </view>
        </view>
        <view class="uni-card">
            <view class="uni-list">

                <view v-if="my.is_friend">
                    <view class="uni-list-cell" hover-class="none">

                        <view class="uni-list-cell-navigate" @tap="goMsg()">
                            <view class="tool">
                                <view class="uni-media-list-logo">
                                    <image src="../../static/theme/default/details/msg.png"></image>
                                </view>
                                发消息
                            </view>
                        </view>

                    </view>
                    <view class="uni-list-cell" hover-class="none" v-if="0">
                        <view class="uni-list-cell-navigate">
                            <view class="tool">
                                <view class="uni-media-list-logo">
                                    <image src="../../static/theme/default/details/conversation.png"></image>
                                </view>
                                音视频通话
                            </view>
                        </view>
                    </view>
                </view>

                <view class="uni-list-cell" hover-class="none" v-else>
                    <view class="uni-list-cell-navigate">
                        <view class="tool" @tap="addFriend">
                            添加到通讯录
                        </view>
                    </view>
                </view>

            </view>
        </view>

    </view>

</template>

<script>

    import _get from '../../common/_get';
    import _hook from '../../common/_hook';
    import _data from '../../common/_data';

    export default {
        components: {

        },
        data() {
            return {
                user_id: '',
                is_type: 0,
                is_in: 0,
                type:0,
                list_id:'',
                invite_name:'',
                invite_id:0,
                my: {
                    show_friend: [],
                    photo: 'default_man/90.jpg',
                    sex: 0,
                },
            }
        },
        onShow(){
            _hook.routeSonHook();
            let _this = this;
            if(this.type == 1 && this.list_id){
                _get.getInviteName({list_id:this.list_id,user_id:this.user_id},function (ret) {
                    _this.invite_name = ret.invite_name
                    _this.invite_id = ret.invite_id
                });
            }
        },
        computed: {
            isFrom(){
                return this.user_id != _data.data('user_info').id;
            },
            userPhoto(){
                return _data.staticPhoto() + this.my.photo + '?_=' + Math.random();
            },
            staticPath(){
                return _data.staticCircle();
            },
            isRemarks(){
                return this.my.is_friend && this.my.user_id != _data.data('user_info').id;
            },
        },
        methods: {
            goKefu(){
                uni.navigateTo({'url':'/pages/chat/message?list_id='+_data.data('kefu_list_id')})
            },
            memberDetail(){
                if(!this.invite_id){
                    return false;
                }
                uni.navigateTo({
                    url:"../details/index?user_id="+this.invite_id+'&type=1&list_id='+this.list_id+'&is_action=2'
                })
            },
            showPhoto(){
                let photo = this.userPhoto.replace('70.jpg','300.jpg');
                uni.previewImage({
                    indicator:"none",
                    current: photo,
                    urls: [ photo, ],
                });
            },
            goCircle(){
                uni.navigateTo({
                    url: '../push/circle_details?user_id=' + this.my.user_id,
                });
            },
            goMsg(list_id){
                if(this.my.user_id == _data.data('user_info').id){
                    uni.showToast({
                        title: '不能给自己发消息',
                        duration: 2000,
                        icon: 'none',
                    });
                    return;
                }
                this.$httpSend({
                    path: '/im/message/getListId',
                    data: { user_id: this.my.user_id },
                    success(data) {
                        uni.navigateTo({
                            url: '../chat/message?list_id=' + data.list_id,
                        });
                    }
                });
            },
            addFriend(){
                let _this = this;
                if(_this.is_in){
                    _this.$httpSend({
                        path: '/im/action/friendAddAction',
                        data: { apply_id: _this.my.apply_id },
                        success(data) {
                            /** 更新申请列表数据 */
                            let friend_apply_list = _data.localData('friend_apply_list');
                            for(let i = 0,j = friend_apply_list.length;i < j;i ++){
                                if(friend_apply_list[i].id == _this.my.apply_id){
                                    friend_apply_list[i].text = '已添加';
                                    _data.localData('friend_apply_list',friend_apply_list);
                                    break;
                                }
                            }
                            uni.showToast({
                                title: '已添加',
                                duration: 2000,
                                complete:function () {
                                    uni.navigateTo({url:'/pages/friend/index'})
                                }
                            });
                            // setTimeout(() => {
                            // 	uni.navigateBack();
                            // },2500);

                        }
                    });
                } else {
                    uni.navigateTo({
                        url: ('../friend/apply?user_id=' + _this.user_id + '&is_type=' + _this.is_type),
                    });
                }
            }
        },
        onLoad(option) {
            let _this = this;
            _this.user_id = option.user_id;
            if('in' in option){
                _this.is_in = option.in;
            }
            if('is_type' in option){
                _this.is_type = option.is_type;
            }
            if('type' in option){
                _this.type = option.type;
            }
            if('list_id' in option){
                _this.list_id = option.list_id;
            }
            if('is_action' in option){
                _this.is_action = option.is_action;
            }
            _this.$httpSend({
                path: '/im/get/details',
                data: { user_id: _this.user_id,in: _this.is_in },
                success(data) {
                    _this.my = data;
                }
            });
        },
        onNavigationBarButtonTap(e) {
            if(this.user_id == _data.data('user_info').id){
                /* uni.showToast({
                    title: '不能操作自己',
                    duration: 1500,
                    icon:'none',
                }); */
                return;
            }
            if(!this.my.is_friend){
                uni.showToast({
                    title: '对方不是好友,没有更多操作了',
                    duration: 1500,
                    icon:'none',
                });
                return;
            }
            uni.navigateTo({
                url: ('./more_details?user_id=' + this.user_id),
            });
        },
    }
</script>

<style>
    .uni-media-list-detail {
        display: flex;
        flex: 1;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
        overflow: hidden;
        margin-left: 26upx;
    }
    .uni-media-list-info{
        font-size: 26upx;
        padding-top: 5upx;
        color:#8f8f94;
    }
    .uni-media-list-text-top{
        margin-top: 0;
        font-size: 38upx;
        font-weight: 600;
    }
    .uni-media-list-logo {
        width: 45upx;
        height: 45upx;
        margin-right: 10upx;
        display: inline-block;
        vertical-align:middle;
    }

    .phto {
        position:relative;
        z-index: 3;
        margin-left: 15upx;
        margin-right: 20upx;
        bottom: 0;
        top: -30upx;
        width: 125upx;
        height: 125upx;

    }
    .phto2 {
        height:175upx;
        width:175upx;
    }
    .phto2 image{
        height: 100%;
        width: 100%;
        border-radius: 10px;
    }

    .uni-list-cell{
        height:auto !important;
    }
    .uni-card {
        box-shadow: none;
    }

    .my_padding:before {
        background-color:white;
    }

    .tool {
        width:100%;
        text-align: center;
    }

    .friend_cricle {
        padding-top: 20upx;
        padding-bottom: 20upx;
    }
    .cricle_title {
        display: inline-block;
        width: 120upx;
    }
    .cricle_img {
        width: 100upx;
        height: 100upx;
    }
    .sex_type {
        width: 35upx;
        height: 35upx;
        margin-right: 0upx;
        margin-left: 20upx;
    }
    .show_text {
        position: absolute;
        right: 60upx;
        color: #8f8f94;
        display: inline-block;
    }
</style>

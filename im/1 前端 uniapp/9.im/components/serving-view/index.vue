<template>
    <view @touchstart="drag_start"
          @touchmove.stop.prevent="moveStop"
          @touchmove="drag_hmove" v-if="show">
        <view class="ball" :class="typeClass"
              :style="'left:'+setX+'px;top :'+setY+'px;'" @tap="toModel">
        </view>
        <uni-popup ref="popup" type="alert">
            <view class="alert" v-if="onLine">
                <view class="alert-list">
                    <view class="alert-item" v-if="voiceModel == 0" @tap="voiceModelTap(1)">
                        <view class="alert-item-model">扬声器播放</view>
                    </view>
                    <view class="alert-item" v-else @tap="voiceModelTap(0)">
                        <view class="alert-item-model">听筒播放</view>
                    </view>
                    <view class="hr"></view>
                    <view class="alert-item" @tap="xiaMai(list_id,0)">
                        <view class="alert-item-model"> 下麦并关闭收听</view>
                    </view>
                    <view class="hr"></view>
                    <view class="alert-item" @tap="xiaMai(list_id)">
                        <view class="alert-item-model">下麦</view>
                    </view>
                </view>
            </view>
            <view class="alert" v-else>
                <view class="alert-list">
                    <view class="alert-item" v-if="voiceModel == 1" @tap="voiceModelTap(0)">
                        <view class="alert-item-model">扬声器播放</view>
                    </view>
                    <view class="alert-item" v-else @tap="voiceModelTap(1)">
                        <view class="alert-item-model">听筒播放</view>
                    </view>
                    <view class="hr"></view>
                    <view class="alert-item" @tap="closeVoice">
                        <view class="alert-item-model">关闭收听</view>
                    </view>
                </view>
            </view>
            <!--<uni-popup-alert title="温馨提示" :content="popuMsg" @confirm = "confirm"> </uni-popup-alert>-->
        </uni-popup>
    </view>

</template>

<script>
    import _data from '../../common/_data';
    import _get from '../../common/_get';
    import SDK from '../../common/tendenceImSdk';
    import uniPopup from '@/components/uni-popup/uni-popup.vue';

    export default {
        props: {
            show: {
                type: Boolean,
                defualt: false
            },
            state:{
                type: Number,
                defualt: 3
            },
            list_id:{
                type: String,
                defualt: ""
            }
        },
        data() {
            return {
                start: [0, 0],
                voiceModel:0,
                onLine:0
            }
        },
        components:{
            uniPopup,
        },
        computed:{
            typeClass(){
                switch (true) {
                    case this.state == 1:
                        return 'shangmai bgred';
                    case this.state == 2:
                        return 'shangmai-ing bgblue';
                    case this.state == 3:
                        return 'shouting bgblue';
                    case this.state == 4:
                        return 'jingyin bgblue';
                    default:
                        return 'shangmai bgred';
                }
          },
            setX(){
                return this.X;
            },
            setY(){
                return this.Y;
            },
            setState(){
                return this.state;
            }
        },
        created() {
            this.setInfo();
            let _this = this;
        },
        methods: {
            closeVoice(){
                //关闭收听
                let _this = this;
                SDK.IMSDK.muteLocalAudio(0,function () {
                    _this.setModel(4);
                    _this.closeModel();
                });
            },
            closeModel(){
                if(this.$refs.popup){
                    this.$refs.popup.close();
                }
            },
            voiceModelTap(val){
                let _this = this;
                console.log("使用扬声器")
                SDK.IMSDK.muteLocalAudio(1,function () { //开启声音
                    SDK.IMSDK.setAudioRoute(val,function () {  //设置扬声器模式
                        if(val == 0){
                            uni.showToast({
                                title:'使用扬声器播放',
                                icon:'none'
                            })
                        }else {
                            uni.showToast({
                                title:'使用听筒播放',
                                icon:'none'
                            })
                        }
                        _this.closeModel();
                        _this.voiceModel = val;
                    })
                });


            },
            xiaMai(list_id,mode = 1){
                let _this = this;
                console.log("下麦..........")
                _get.setVoiceRoomMsg({list_id:list_id,type:0},function (num) {
                    //判断有几个人在麦上，如果有且只有一个人则同时下麦，如果大于1人则设置为听筒模式]
                    console.log(num)
                    if(num == 0){
                        _this.closeVoiceRoom()
                    }else {
                            if(mode == 1){
                                //禁言 收听
                                _this.jingyanShouTing() //禁言 关闭收听
                            }else {
                                _this.jinyanJingyin();
                            }
                    }
                    _this.closeModel()
                });

            },
            toModel(){
               switch (true) {
                   case this.state == 1:
                       //如果是在上麦模式打开则打开弹窗提示操作
                       this.onLine = 1;
                       this.$refs.popup.open();
                       return 'shangmai';
                   case this.state == 2:
                       //如果是正在上麦则切换图片
                       return 'shangmai-ing';
                   case this.state == 3:
                       //切换到收听图片
                       this.onLine = 0;
                       this.$refs.popup.open();
                       return 'shouting';
                   case this.state == 4:
                       //切换到禁音图片
                       this.setModel(3);
                       //设置扬声器模式
                       this.voiceModelTap(0)
                       return 'jingyin';
                   default:
                       return 'shangmai';
               }
            },
            joinOnline(list_id,cb){
                //开启语音聊天
                let _this = this;
                SDK.IMSDK.muteRemoteAudio(_data.localData('voice_room_userid'),1,function () {
                    _this.setModel(1);//加入
                    _this.onLine = 1; //在线上
                    _data.localData('voice_room_type',1); //是否在麦
                    _this.voiceModelTap(1)
                    _get.setVoiceRoomMsg({list_id:list_id,type:1},function (ret) {
                        if(cb)cb()
                    });
                });
            },
            setModel(state){
              //设置模式
               this.$emit('setState',{state:state})
            },
            joinRoom(list_id,cb){
                let _this = this;
                _get.joinVoiceRoom({list_id:list_id},function (ret) {
                    SDK.IMSDK.joinRoom(ret,function (sdk_ret) {
                    })
                    _this.setModel(1);
                    _data.localData('voice_room_userid',ret.userid);
                    _data.localData('voice_room_type',1); //是否在麦]
                    _this.voiceModelTap(1)
                    _get.setVoiceRoomMsg({list_id:list_id,type:1},function () {
                        if(cb)cb();
                    });
                })
            },
            closeVoiceRoom(){
              //静默退出聊天室
                this.setModel(-1)
                this.$emit('closeServing',{});
                _data.localData('voice_room_userid',null);
                SDK.IMSDK.exitRoom(function () {
                })
            },
            memberJoin(user_id,list_id,cb){
                let _this = this;
                _get.memberjoinVoiceRoom({list_id:list_id},function (ret) {
                    SDK.IMSDK.joinRoom(ret,function (sdk_ret) {
                    })
                    _this.jinyanJingyin(cb)
                    _data.localData('voice_room_userid',ret.userid);
                    _data.localData('voice_room_type',0); //是否在麦
                    _this.voiceModelTap(1)
                })
            },
            jinyanJingyin(cb){  //禁言禁音
                let _this = this;
                SDK.IMSDK.muteRemoteAudio(_data.localData('voice_room_userid'),0,function () {
                    _this.setModel(4);//加入之后直接禁言
                    SDK.IMSDK.muteLocalAudio(0); //禁音
                     if(cb)cb();
                });
            },
            jingyanShouTing(cb){ //禁言收听
                let _this = this;
                SDK.IMSDK.muteRemoteAudio(_data.localData('voice_room_userid'),0,function () {
                    _this.setModel(3);//加入之后直接禁言
                    SDK.IMSDK.muteLocalAudio(1); //s收听
                    if(cb)cb();
                });
            },
            setInfo(){
                let dragInfo = getApp().globalData['dragInfo']
                this.X = dragInfo.moveX;
                this.Y = dragInfo.moveY;
            },
            moveStop() {
            },
            drag_start(event) {
                this.start[0] = event.touches[0].clientX - event.target.offsetLeft;
                this.start[1] = event.touches[0].clientY - event.target.offsetTop;
            },
            setGlobleX(x){
                this.X = x;
                let dragInfo = getApp().globalData['dragInfo'];
                dragInfo.moveX = x;
                getApp().globalData['dragInfo'] = dragInfo;
            },
            setGlobleY(y){
                this.Y = y;
                let dragInfo = getApp().globalData['dragInfo'];
                dragInfo.moveY = y;
                getApp().globalData['dragInfo'] = dragInfo;
            },
            drag_hmove(event) {
                let sysInfo = uni.getSystemInfoSync();
                const maxWidth = sysInfo.windowWidth - 50;//屏幕宽度减去悬浮框宽高
                const maxHeight = sysInfo.windowHeight;
                let tag = event.touches;
                if (tag[0].clientX <= 50) { //屏幕x限制
                    this.setGlobleX(0);
                } else if (tag[0].clientX > maxWidth) {
                    this.setGlobleX(maxWidth);
                } else {
                    let x = tag[0].clientX - this.start[0];
                    this.setGlobleX(x);
                }
                if (tag[0].clientY <= 25) { //屏幕y限制
                    this.setGlobleY(0);
                } else if (tag[0].clientY > maxHeight) {
                    this.setGlobleY(maxHeight);
                } else {
                    let y = tag[0].clientY - this.start[1];
                    this.setGlobleY(y);
                }
            }
        }
    }
</script>

<style lang="less">
    .ball {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        z-index: 10000;
        top: 140px;
        position: fixed;
    }
    .bgred{
        background: red;
    }
    .bgblue{
        background: #00b1f7;
    }
   .shangmai{
       background-image: url("/static/theme/default/shangmai.png");
       background-size:40px 40px;
       background-repeat:no-repeat;
       background-position:center;
   }
   .shouting{
       background-image: url("/static/theme/default/laba.png");
       background-size:30px 30px;
       background-repeat:no-repeat;
       background-position:center;
   }
    .jingyin{
        background-image: url("/static/theme/default/jingyin.png");
        background-size:20px 20px;
        background-repeat:no-repeat;
        background-position:center;
    }
    .alert{
        width: 300px;
        background-color: #fff;
    }
    .alert-list{
        display: flex;
        flex-direction: column;
    }
    .alert-item{
        height: 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-left: 20px;
    }
    .alert-item-model{
    }
    .hr{
        height: 1upx;
        width:95%;
        margin: 0 auto;
        background-color: #e1e1e1;
    }
</style>

<template>
    <view class="page" v-if="!showVedio">
        <view class="page-content">
            <view class="page-content-list">
                <view  class="page-content-item"  @tap="info(item)" @longtap="openConfirm(item,index)" v-for="(item,index) in list">
                    <view class="content-one">
                        <view class="image"  v-if="item.type == 2">
                            <image class="content-one-image" :src="staticPath+ item.list_id+'/'+item.content.url"></image>
                            <text></text>
                        </view>
                        <view class="voice" :class="play_id == item.id ?'play':''"  v-if="item.type == 3">
                            <view class="iconfont-im icon-yuyin-you yuyin" @tap="palyVoice(item)"></view>
                            <view class="length">{{item.content.length}}</view>
                        </view>
                        <view class="vedio" v-if="item.type == 4">
                            <image class="content-one-image" :src="staticPath+ item.list_id+'/'+item.content.image"></image>
                            <image class="bubble-bofang-left"
                                   src="/static/theme/default/my/bofang.png"></image>
                        </view>
                        <view class="text-info" v-if="item.type == 1">
                            <text>{{item.content.text}}</text>
                        </view>
                    </view>

                    <view class="content-two">
                        <text>{{item.user_info.nickname}}</text>
                        <text>{{item.time}}</text>
                    </view>
                    <view class="footer-hr"></view>
                </view>
            </view>
        </view>
        <uni-popup ref="popup" type="img">
            <uni-popup-img title="温馨提示" :beforeClose="true" @close="close" content="testst" @confirm = "confrim"> </uni-popup-img>
        </uni-popup>
    </view>
    <view v-else="showVedio"
          class="showVedio">
        <!-- <video :src="videoPath"
               style="height: 100%;width: 100%"
               id="myVideo"
               object-fit="fill"
               airplay="allow" /> -->
        <video autoplay="true"
               object-fit="fill"
               page-gesture="true"
               controls="false"
               style="height: 100%;width: 100%"
               id="myVideo"
               :src="videoPath">
            <!-- <cover-view
                        @tap="showVedio = false"> -->
            <cover-image @tap="showVedio = false"
                         src="/static/theme/default/my/close.png"
                         class="cloneBut"></cover-image>
            <!-- </cover-view> -->
        </video>
    </view>
</template>

<script>
    import uniPopup from '../../components/uni-popup/uni-popup.vue';
    import uniPopupImg from '../../components/uni-popup/uni-popup-img.vue';
    import _get from "../../common/_get";
    import _data from "../../common/_data";
    import _page from "../../common/common";
    import { mapState,mapMutations } from 'vuex'
    export default {
        data() {
            return {
                selectIndex:0,
                id:0,
                play_id:'',
                showVedio:false,
                videoPath:'',
                type:0,
                storge_info:{
                    'user_storge_count':0,
                    'user_storge':'0KB',
                    'max_count':'0',
                    'max_storge':'0KB',
                    "user_info":{}
                },

                list:[]
            }
        },
        components:{
            uniPopup,
            uniPopupImg
        },
        computed:{
            ...mapState({
                RECORD:state=>state.audio.RECORD,
                AUDIO:state=>state.audio.AUDIO,
                RecordTime:state=>state.audio.RecordTime,
                KeyboardH:state=>state.common.KeyboardHeight
            }),
            toPlay(){
                return this.play_id;
            },
            staticPath(){
                return _data.staticChat();
            },
            myPhoto() {
                return _data.staticPhoto()+this.storge_info.user_info.face;
            },
        },
        onShow(){
            let _this = this;
            _get.getUserStore({type:_this.type},function (ret) {
                _this.storge_info = ret.info;
                _this.list = ret .data
            });
        },
        onLoad(options){
            if ('type' in options) {
                this.type = options.type
            }
            let title = '全部'
            switch (true) {
                case options.type == 0:
                    title = '全部'
                    break;
                case options.type == 4:
                    title = '视频'
                    break;
                case options.type == 3:
                    title = '语音'
                    break;
                case options.type == 2:
                    title = '图片'
                    break;
                case options.type == 1:
                    title = '文字'
                    break;
                default:
                    title = '全部'
                    break;
            }
            uni.setNavigationBarTitle({
                title: title,
            });
            // 注册音频自然结束事件
            this.regVudioEndEvent((e)=>{
                this.play_id = '';
            });
        },
        methods: {
            ...mapMutations(['regVudioEndEvent']),
            palyVoice(item){
                let _this = this
                _this.AUDIO.stop();
                _this.list_id = item.list_id;
                if(this.play_id == item.id){ //正在播放的是当前语音
                    return _this.play_id = '';
                }
                let url = this.staticPath + item.content.url;
                _this.AUDIO.src = url;
                console.log(url)
                _this.$nextTick(function () {
                    _this.AUDIO.play();
                });
                return this.play_id = item.id
            },
            getDetail(val){
                uni.navigateTo({url:'store_info?type='+val})
            },
            toDetail(){
                uni.navigateTo({url:'store_detail'})
            },
            confrim(val){
                console.log(val);
                let _this = this;
                if(val.type == 2){
                    uni.navigateTo({url:'trans_index?id='+this.id})
                }else {
                    _get.deleteStore({id:this.id},function (ret) {
                        uni.showToast({
                            title:ret.msg,
                            icon:'none',
                            duration:'2000',
                        });
                        _this.$refs.popup.close()
                        _this.list.splice(_this.selectIndex,1);
                    });
                }
            },
            openConfirm(item,index){
                this.id = item.id;
                this.selectIndex = index;
                this.$refs.popup.open()
            },
            autoVideo (msg) {
                this.list_id = msg.list_id;
                this.showVedio = true;
                this.videoPath = _data.staticChat() + this.list_id + "/" + msg.content.url;
            },
            info(item){
                if(item.type == 1){
                    return true;
                }
                if(item.type == 2){
                    let url = this.staticPath+item.list_id+'/'+item.content.url
                    _page.imgPreview([url],0);
                    return true;
                }
                if(item.type == 3){
                    // _page.imgPreview([item.content.url],0);
                    return true;
                }
                if(item.type == 4){ //视频
                    this.autoVideo(item)
                    return true;
                }
                //语音就播放
                //图片就预览
                //视频就播放

                // uni.navigateTo({
                // 	url:'store_item_info?id='+item.id
                // })
            }
        }
    }
</script>

<style lang="scss">
    .page{
        display: flex;
        flex-direction: column;
    }
    .page-header{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 50rpx 40rpx;
    }
    .page-header-left{
        display: flex;
        flex-direction: column;
        margin-left: 20px;

    }
    .page-header-right{
        display: flex;
        flex-direction: column;
    }
    .page-header-right-view1{
        display: flex;
        flex: 1;
    }
    .page-header-right-view2{
        display: flex;
        flex: 1;
        text-decoration:underline;
        color: #2c5f8a;
    }
    .page-content{
        display: flex;
        flex-direction: column;
        padding: 30rpx;
    }
    .page-content-header{
        display: flex;
        flex-direction: row;
        justify-content: space-around;
    }
    .page-content-list{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .page-content-item{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 8px;
    }
    .content-one{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }

    .content-two{
        display: flex;
        justify-content:space-between;
        align-items: center;
    }
    .page-header-info{
        display: flex;
    }
    .page-header-info  image{
        width: 50px;
        height: 50px;
    }
    .voice{
        display: flex;
        justify-content: flex-start;
        align-items: center;
        background-color: #ffffff;
        width: 80px;
        padding: 2px 10px;
        border-radius: 10px;
    }
    .length{
        margin-left: 4rpx
    }
    .vedio{
        position: relative;
    }
    .content-one-image{
        width: 80px;
        height: 100px;
    }
    .bubble-bofang-left {
        position: absolute;
        left: 25px;
        top: 35px;
        width: 30px;
        height: 30px;
    }

    .text-info{
        padding: 10px 0;
    }
    .footer-hr{
        height: 1upx;
        width: 90%;
        background-color: #e1e1e1;
        margin: 0 auto;
    }
    @keyframes voicePlay {
        0% {
            background-position: 0;
        }
        100% {
            background-position: 100%;
        }
    }
    .voicePlay {
        animation-name: voicePlay;
        animation-duration: 10s;
        animation-direction: normal;
        animation-iteration-count: infinite;
        animation-timing-function: steps(3);
    }
    .play{
        @keyframes other-play {
            0% {
                transform: translateX(-80%);
            }
            100% {
                transform: translateX(0%);
            }
        }
        .icon-yuyin-you:after
        {
            border-right: solid 10upx rgba(255,255,255,.8);
            animation: other-play 1s linear infinite;
            left: 50upx;
        }
    }
    .icon-yuyin-you:after{
        content: " ";
        width: 40px;
        height: 40px;
        -webkit-border-radius: 100%;
        border-radius: 100%;
        position: absolute;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }
    .showVedio {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 300;
    }
    .cloneBut {
        z-index: 400;
        position: relative;
        text-align: right;
        font-size: 24px;
        color: red;
        margin-left: 10px;
        margin-top: 10px;
        height: 30px;
        width: 30px;
    }
    .cloneBut-img {
        position: absolute;
        width: 30px;
    }
</style>


const IMSDK = {
    $api: null,
    init(){
      this.$api =   uni.requireNativePlugin('Html5App-TencentCall');
      return this;
    },
    joinRoom(param,cb) {  //加入/创建房间
        if(!this.$api)this.init();
        this.$api.joinRoom({
            "userid": param.userid,
            "roomid": param.roomid,
            "usersig": param.usersig
        }, ret => {
            if(cb)cb();
        })
    },
    exitRoom(cb){  //离开房间
        if(!this.$api)this.init();
        this.$api.exitRoom()
        if(cb)cb()
    },
    removeUser(userid,cb){ //踢出房间
        if(!this.$api)this.init();
        this.$api.removeUser({"userid":userid},ret=>{
            if(cb)cb();
        });
    },
    muteLocalAudio(mute,cb){ //设置本地音频是否开启，
        if(!this.$api)this.init();
        this.$api.muteLocalAudio({mute:mute},ret=>{
            if(cb)cb();
        });
    },
    setAudioRoute($route,cb){ //设置切换音频通道 //0=>代表扬声器,1=> 听筒
        if(!this.$api)this.init();
        this.$api.setAudioRoute({route:$route},ret=> {
            if(cb)cb();
        });
    },
    muteRemoteAudio(userid,mute,cb){ //禁言mute : 0=>代表禁言,1=> 开启发言
        if(!this.$api)this.init();
        this.$api.muteRemoteAudio({"userid":userid,mute:mute},ret=>{
            if(cb)cb();
        });
    }
}

export default{
    IMSDK
}

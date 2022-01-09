<template>
    <view class="page">
        <pay-keyboard :show_key="show_key" :set_info="set_info" ref="payKeyboard" :set_msg="set_msg" @hideFun="hideFun" @getPassword="getPassword" :password="password"></pay-keyboard>
    </view>
</template>

<script>
    import payKeyboard from '../../../components/uni-keyword/uni-keyword';
    import _get from '../../../common/_get';
    import _hook from '../../../common/_hook';
    export default {
        components: {
            payKeyboard
        },
        data() {
            return {
                set_times:1,
                title: '设置交易密码',
                show_key: true,
                password:'',
                set_msg:'设置交易密码',
                set_info:'请输入支付密码，以验证身份',
                pageMsg:{
                    title:'设置交易密码',
                    info:'请输入支付密码，用于支付验证',
                    info2:'请再次输入支付密码以确认'
                }
            }
        },
        onShow(){
            _hook.routeSonHook();
        },
        onLoad() {

        },
        methods: {
            showFun() {
                this.show_key = true
            },
            hideFun() {
                this.show_key = false
            },
            setTimes(){
                switch (this.set_times) {
                    case 1:
                        this.set_info = this.pageMsg.info;
                        break;
                    case 2:
                        this.set_info = this.pageMsg.info2;
                        break;
                }
            },
            getPassword(n) {
                let _this = this;
                switch (this.set_times) {
                    case 1:
                        this.$refs.payKeyboard.cleanNum();
                        this.password = n.password;
                        this.set_times++;
                        _this.setTimes();
                        break;
                    case 2:
                        _this.set_times = 1;
                        this.$refs.payKeyboard.cleanNum();
                        if(this.password != n.password){
                            uni.showToast({
                                title:'两次密码输入不一致',
                                icon:'none',
                                success(res) {
                                    _this.setTimes();
                                    return false;
                                }
                            })
                        }
                        let params = {};
                        params.password = this.password;
                        params.confirm_password = n.password;
                        _get.setUserTradePassword(params,function(res){
                            uni.$emit('data_user_info',res);
                            _this.setTimes();
                             uni.navigateBack();
                        });
                        break;
                }
            }
        }
    }
</script>


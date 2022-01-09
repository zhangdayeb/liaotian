<template>
    <view class="page">
        <view class="page">
            <pay-keyboard  :set_info = "set_info" :show_key="show_key" ref="payKeyboard" :set_msg="set_msg" @hideFun="hideFun" @getPassword="getPassword" :password="password"></pay-keyboard>
        </view>
    </view>
</template>

<script>
    import payKeyboard from '../../components/uni-keyword/uni-keyword';
    import _get from '../../common/_get';
    import _hook from '../../common/_hook';
    export default {
        components: {
            payKeyboard
        },
        data() {
            return {
                title: '请再次输入交易密码',
                show_key: true,
                password:'',
                set_msg:'请再次输入交易密码',
                set_info:'请再次输入交易密码，以确认身份',
                page_params:{},
                click:true
            }
        },
        onLoad(options) {
            this.page_params = options;
        },
        onShow(){
            _hook.routeSonHook();

        },
        methods: {
            showFun() {
                this.show_key = true
            },
            hideFun() {
                this.show_key = false
            },
            getPassword(n) {
                let _this = this;
                if(_this.page_params.password != n.password){
                   return uni.showToast({
                        title: '两次密码输入不一致!',
                        duration:2000,
                        icon:'none',
                        success:function () {
                           setTimeout(function () {
                               _this.$refs.payKeyboard.cleanNum();
                               uni.$emit('clean_password_data');
                               uni.redirectTo({url:"/pages/my/foget_trade_password?show_key="+1})
                           },1000)
                        }
                    });
                }

                _this.page_params.confirmPassword = n.password;
                _get.updateUserTradePassword(_this.page_params,function (res) {
                    uni.showToast({
                        title: '操作成功',
                        duration:2000,
                        icon:'none',
                        success:function () {
                            _this.$refs.payKeyboard.cleanNum();
                            uni.navigateBack();
                        }
                    });
                },function (ret) {
                    uni.showToast({
                        title: ret.msg,
                        duration:2000,
                        icon:'none',
                        success:function () {
                            setTimeout(function () {
                                _this.$refs.payKeyboard.cleanNum();
                                uni.$emit('clean_password_data');
                                uni.redirectTo({url:"/pages/my/foget_trade_password"})
                            },1000)
                        }
                    });
                })
            },
            cleanNum(){
                this.$refs.payKeyboard.cleanNum();
            }
        }
    }
</script>
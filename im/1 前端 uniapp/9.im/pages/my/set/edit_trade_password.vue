<template>
    <view class="page">
        <pay-keyboard :set_info="set_info" :show_key="show_key" ref="payKeyboard" :set_msg="set_msg" @hideFun="hideFun"
                      @getPassword="getPassword" :password="password"></pay-keyboard>
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
                set_times: 1,
                title: '修改交易密码',
                show_key: true,
                password: '',
                set_msg: '修改交易密码',
                set_info: '请输入支付密码，以验证身份',
                pageMsg: {
                    title: '修改交易密码',
                    info: '请输入支付密码，用于支付验证',
                    info2: '请设置支付密码，用于支付验证',
                    info3: '请再次输入支付密码以确认',
                    info4: '两次密码输入不一致',
                },
                requestParams: {}
            }
        },
        onLoad(options) {
            this.pageParams = options;
        },
        onShow() {
            _hook.routeSonHook();
        },
        methods: {
            setTimes() {
                switch (this.set_times) {
                    case 1:
                        this.set_info = this.pageMsg.info;
                        break;
                    case 2:
                        this.set_info = this.pageMsg.info2;
                        break;
                    case 3:
                        this.set_info = this.pageMsg.info3;
                        break;
                }
            },
            showFun() {
                this.show_key = true
            },
            hideFun() {
                this.show_key = false
            },
            getPassword(n) {
                let _this = this;
                switch (this.set_times) {
                    case 1:
                        _this.$refs.payKeyboard.cleanNum();
                        _get.checkUserTradePassword(n,function (res) {
                            _this.set_times++;
                            _this.setTimes();
                        });
                        //TODO 校验密码
                        break;
                    case 2:
                        _this.$refs.payKeyboard.cleanNum();
                        _this.password = n.password;
                        this.set_times++;
                        _this.setTimes();
                        break;
                    case 3:
                        _this.$refs.payKeyboard.cleanNum();
                        _this.requestParams.password = _this.password;
                        _this.requestParams.confirm_password = n.password;
                        if (_this.password != n.password) {
                            uni.showToast({
                                title: '两次密码输入不一致',
                                icon: 'none',
                                success(res) {
                                    _this.set_times--;
                                    _this.set_info = _this.pageMsg.info4;
                                }
                            })
                        }
                        _this.requestParams.is_edit = 1;
                        _get.setUserTradePassword(_this.requestParams, function (res) {
                            uni.navigateBack({
                                success(res) {
                                    _this.set_times = 1;
                                    _this.setTimes();
                                }
                            });
                        });
                }
            }
        }
    }
</script>


<template>
    <view class="page">
        <view class="page">
            <pay-keyboard  :set_info = "set_info" :show_key="show_key" ref="payKeyboard" :set_msg="set_msg" @hideFun="hideFun" @getPassword="getPassword" :password="password"></pay-keyboard>
        </view>
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
                title: '请输入交易密码',
                show_key: true,
                password:'',
                set_msg:'请输入交易密码',
                set_info:'请输入交易密码，以确认身份',
                page_params:{},
                click:true
            }
        },
        onLoad(options) {
            this.page_params = options;
        },
        onShow(){
			_hook.routeSonHook();
          uni.$on('clean_password_data',this.cleanNum);
        },
        methods: {
            showFun() {
                this.show_key = true
            },
            hideFun() {
                this.show_key = false
            },
            getPassword(n) {
                console.log("用户输入的密码", n);
                this.page_params.trade_password = n;
                let _this = this;
                if(!_this.click) return false;
                _this.click = false;
                //此处实际应用时应该post到服务器，然后服务器广播长连接
                uni.showLoading({title:'提交中'});
                _get.createHongBao( _this.page_params,function (res) {
                    uni.navigateBack();
                },function (res) {
                    uni.hideLoading();
                    uni.showToast({title:res.msg,icon:'none'});
                    _this.click = true;
                    _this.$refs.payKeyboard.cleanNum();
                })
            },
            cleanNum(){
                this.$refs.payKeyboard.cleanNum();
            }
        }
    }
</script>
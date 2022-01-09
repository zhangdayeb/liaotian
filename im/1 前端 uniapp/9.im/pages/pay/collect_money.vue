<template>
    <view class="page">
        <pay-keyboard  :set_info = "set_info" :show_key="show_key" ref="payKeyboard" :set_msg="set_msg" @hideFun="hideFun" @getPassword="getPassword" :password="password"></pay-keyboard>
    </view>
</template>

<script>
    import payKeyboard from '../../components/uni-keyword/uni-keyword';
    import _get from '../../common/_get';
    import _data from '../../common/_data';
    import _hook from '../../common/_hook';
    export default {
        components: {
            payKeyboard
        },
        data() {
            return {
                title: '请输入交易密码',
                show_key: true,
                password:'',
                set_msg:'',
                set_info:'请输入交易密码，以确认身份',
                page_params:{},
                click:true
            }
        },
        onLoad(options) {
            _hook.routeSonHook();
            this.page_params = options;
        },
        onShow(){
			this.set_msg = "用户'"+this.page_params.username+"'向你收款"+this.page_params.amount+'元'
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
                uni.showLoading({title:'付款中'});
				_get.payAmount({amount:_this.page_params.amount,to_user_id:_this.page_params.id},function(ret){
					 uni.$emit('data_user_info',ret);
					_data.data('user_info',ret);
					 _this.$refs.payKeyboard.cleanNum();
					uni.hideLoading();
					uni.showToast({
						title:'支付成功',
						icon:'none'
					});
					setTimeout(function(){
						uni.redirectTo({
							url:'/pages/my/wallet/capital'
						})
					},1000);
				})
            },
            cleanNum(){
                this.$refs.payKeyboard.cleanNum();
            }
        }
    }
</script>
<template>
    <view class="page">
        <view class="content">
            <form @submit="addBank" @reset="">
            <view class="uni-form-item">
                <text class="title"><text style="margin-right: 10px;">*</text>姓名</text>
                <input class="uni-input" @input="fullname"  type="text" placeholder="请输入姓名"/>
            </view>
            <view class="uni-form-item">
                <text class="title"><text style="margin-right: 10px;">*</text>身份证号</text>
                <input class="uni-input" @input="idCard" type="idcard" placeholder="请输入身份证号"/>
            </view>
            <view class="uni-form-item">
                <text class="title"><text style="margin-right: 10px;">*</text>支付宝账号</text>
                <input class="uni-input"  @input="account" type="text" placeholder="请输入支付宝账号"/>
            </view>
            <button class="withdraw" form-type="submit" type="submit">绑定</button>
            </form>
        </view>
    </view>
</template>


<script>
    import _get from '../../../common/_get';
    import _hook from '../../../common/_hook';
    export default {
        data() {
            return {
                requestParams:{
                    'fullname':'',
                    'id_card':'',
                    'account':'',
                    'bank_type':1
                }
            }
        },
        onShow(){
            _hook.routeSonHook();
        },
        methods: {
            fullname(e){
                return this.requestParams.fullname = e.detail.value.trim();
            },
            idCard(e){
                return this.requestParams.id_card = e.detail.value.trim();
            },
            account(e){
                return this.requestParams.account = e.detail.value.trim();
            },
            bank_type(e){
                return this.requestParams.bank_type = e.detail.value.trim();
            },
            addBank(e){
                if(this.requestParams.account == ''){
                    return this.showToast('请输入账号!');
                }
                if(this.requestParams.id_card == ''){
                    return this.showToast('请输入身份证号!');
                }
                if(this.requestParams.fullname == ''){
                    return this.showToast('请输入姓名!');
                }
                _get.addUserBank(this.requestParams,function (res) {
                    uni.navigateBack();
                });
            },
            showToast(msg){
                return uni.showToast({title:msg,icon:'none'});

            }
        }
    }
</script>

<style>
    page{
        background-color: white;
    }
    .page{
        border-top: 1px solid #e3e3e3;
    }
.uni-input{
    border: none;
    text-align: right;
}
    .uni-form-item{
        border-bottom: 1px solid #e3e3e3;
    }
    .content .withdraw{
        margin-top: 70upx;
        width: 90%;
        background-color: #5693ee;
        color: white;
        height: 70upx;
        line-height:  70upx !important;
        border-radius: 40upx;
        font-size: 36upx;
        cursor: pointer;
    }
</style>

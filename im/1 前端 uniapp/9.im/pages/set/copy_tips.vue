<template>
    <view class="page">
        <view class="page-header">
            <image :src="photo" :lazy-load="true""></image>
            <text class="page-header-title">{{info.name}}</text>
            <text>{{info.num}}人</text>
        </view>
        <view class="page-content">
            <view>温馨提示</view>
            <view>1.一键复杂新群后，将生成一个新成员相同的群</view>
            <view>2.新群的群成员详情设置,群管理等将保留老群设置</view>
            <view>3.老群中的新聊机器人无法一键复制到新群</view>
        </view>
        <view class="page-footer">
            <view class="page-footer-info" @tap="change">
                <checkbox :checked="info.checked"></checkbox>
                <text>解散原本的群</text>
            </view>
            <view>
                <button class="sub-but" style="background-color: #496cb1" @tap="copyQun">确定复制</button>
            </view>
        </view>
    </view>
</template>

<script>
    import _get from '../../common/_get';
    import _hook from '../../common/_hook';
    import _data from '../../common/_data';

    export default {
        data() {
            return {
                info: {
                    photo: 'https://im.smiaoshen.com/static/photo//group_photo/8E5BCBD1B1AF0322DAB197A54FF9EA6E/90.jpg?_=0.6412025411589806',
                    num: 1,
                    name: '',
                    checked: '1'
                },
                list_id: '',
                main_id: 0
            }
        },
        onShow() {
            let _this = this;
            _hook.routeSonHook();
            _get.getGroupDetail({list_id:this.list_id,jiesan:this.info.checked,main_id:this.main_id},function (res) {
                _this.info.num = res.num;
                _this.info.name = res.group.name;
                _this.info.photo = res.group.photo_path;
            });
        },
        onLoad(options) {
            if ('list_id' in options) {
                this.list_id = options.list_id
            }
            if ('main_id' in options) {
                this.main_id = options.main_id
            }
        },
        computed:{
            photo(){
                return this.staticPhoto + this.info.photo + '?_=' + Math.random();
            },
            staticPhoto(){
                return _data.staticPhoto();
            },
        },
        methods: {
            change() {
                if (this.info.checked) {
                    this.info.checked = '0';
                } else {
                    this.info.checked = '1';
                }
            },
            copyQun(){
                _get.copyNewQun({list_id:this.list_id,jiesan:this.info.checked,main_id:this.main_id},function () {
                    
                })
            }
        }
    }
</script>

<style>
    .sub-but {
        background-color: #496cb1;
        color: #ffffff;
        width: 200px;
    }

    page {
        background-color: #ffffff;
    }

    .page {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        height: 100%;
    }

    .page-header {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .page-header image {
        width: 130rpx;
        height: 130rpx;
    }

    .page-header-title {
        padding: 25rpx;
    }

    .page-content {
        padding-top: 40px;
    }

    .page-content view {
        padding: 5px;
    }

    .page-footer-info {
        padding: 40px;
    }

    .page-footer {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
</style>

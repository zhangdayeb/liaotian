<template>
    <view class="page">
        <view class="page-content" style="margin-top: 1px;">
            <uni-list class="page-list">
                <!-- 水平排列，右图左文 -->
                <uni-list-item @tap="toDetails(item)" class="page-list-item" :thumb="staticPic+item.small_pic" :title="item.article_name"
                               v-for="(item,index) in list">
                </uni-list-item>
            </uni-list>
        </view>
    </view>
</template>

<script>
    import _get from "../../common/_get";
    import _data from "../../common/_data";
    import _hook from "../../common/_hook";

    export default {
        data() {
            return {
                list: [
                ]
            }
        },
        computed: {
            staticPic() {
                return _data.domainUrl()
            }
        },
        onShow() {
            let _this = this;
            _hook.routeSonHook();
            _get.getArticleList({}, function (ret) {
                _this.list = ret
            });
        },
        methods: {
            toDetails(item){
                uni.navigateTo({url:'detail?id='+item.id})
            }
        }
    }
</script>

<style>
    .page-head-img {
        height: 200px;
        width: 100%;
    }

    uni-view {
        line-height: normal !important;
    }
</style>

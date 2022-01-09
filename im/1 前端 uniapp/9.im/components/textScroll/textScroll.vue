<template>
    <div class="tip">
        <div class="inner" :class="{'move': scroll}" :style="styleName">
            <text class="tip-inder">{{text}} {{scroll ? text : '' }}</text>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            text: {
                type: String,
                defualt: ''
            },
        },
        data() {
            return {
                styleName: "animation-duration: 6s",
                scroll: false,
                tipWidth: 0
            };
        },
        watch: {
            text: {
                handler(val) {
                    this.textScroll()
                },
                immediate: false
            }
        },
        methods: {
            textScroll() {
                // 等待节点挂载后再执行,热门线路tip滚动实现
                this.$nextTick(() => {
                    console.log('滚动')
                    let query = uni.createSelectorQuery().in(this)
                    query.select('.tip').boundingClientRect(data => {
                        this.tipWidth = data.width
                        console.log('tip', this.tipWidth)
                    }).exec();
                    query.select('.tip-inder').boundingClientRect(data => {
                        console.log('tip-inder', data.width)
                        if(data.width > this.tipWidth) {
                            let w = Number(data.width)
                            let time = Math.round(w / 40)
                            this.styleName = `animation-duration: ${time}s`
                            this.scroll = true
                        }
                    }).exec();
                })
            }
        }
    };
</script>

<style lang="less">
    .tip {
        width: 100%;
        background: transparent;
        color: #4d82ff;
        font-size: 28rpx;
        height: 80rpx;
        line-height: 80rpx;
        overflow: hidden;
        box-sizing: border-box;
        white-space: nowrap;
    }

    .tip .inner {
        overflow: hidden;
        display: inline-block;
    }

    .tip .inner .tip-inder {
        white-space: nowrap;
    }

    .tip .inner.move {
        // animation: move 6s infinite linear;
        animation-name: scroll;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    @keyframes scroll {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }
</style>


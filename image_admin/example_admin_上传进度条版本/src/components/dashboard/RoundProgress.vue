<template>
   <div class="card chart" :style="styles">
     <div class="head">
      <p class="line-title">
        <i class="iconfont" style="font-size: 13px; color: #FEB062; background: rgba(254, 176, 98, 0.15)">&#xe6de;</i>
        <span>{{title}}</span>
      </p>
     </div>
     <div class="progress">
      <svg v-for="(item, index) in showList" :key="index"  :style="'width: '+item.width+'px;height: '+item.height+'px;left: '+item.left+'px;top: '+item.top+'px;z-index: '+item.zIndex+';'" viewBox="0 0 100 100">
        <path d="
        M 50 50
        m 0 50
        a 50 50 0 1 1 0 -100
        a 50 50 0 1 1 0 100
        " :stroke="item.bgColor" :stroke-width="dasharrayList[index]" fill="none" stroke-linecap="round" class="circle_track"></path>
        <path d="
        M 50 50
        m 0 50
        a 50 50 0 1 1 0 -100
        a 50 50 0 1 1 0 100
        " :stroke="color" fill="none" stroke-linecap="round" :stroke-width="item.strokeWidth" class="circle_path" :style="'stroke-dasharray: '+item.dasharray+'px,385px'"></path>
      </svg>
      <div class="detailShow">
        <i class="iconfont" :style="{color: color, background: iconBg}">&#xe6de;</i>
        <p :style="{color: color}">16</p>
      </div>
      <p class="bottom-title">{{title2}}{{total}}</p>
    </div>
   </div>
</template>
<script>
export default {
  props: {
    title: {
      type: String,
      default: '代办事项'
    },
    title2: {
      type: String,
      default: '本月待办事项：'
    },
    color: {
      type: String,
      default: '#6EB2F4'
    },
    icon: String,
    iconBg: {
      type: String,
      default: '#CAE2FA'
    },
    styles: String
  },
  data() {
    return {
      total: 20, // 总的数据
      list: [15], // 每一个环形的数据
      dasharrayList: [5], // 每个环形的宽度
      detailShow: true, // 鼠标滑到环形上的提示文字
      details1: '',
      details2: '',
      // 圆环相关数据
      showList: [{
        name: 'A', // 名称
        dasharray: 0, // 当前的数据
        strokeWidth: 0, // 圆环的线宽度
        width: 180, // 圆环宽度
        height: 180, // 圆环高度
        top: 0, // 圆环位置
        left: 0,
        zIndex: 3,
        bgColor: '#e5e9f2', // 底层圆环颜色
        strokeColor: '#409EFF' // 上层圆环颜色
      }]
    }
  },
  created() {
    // 页面刷新加载圆环数据，从无到有体现动画效果
    setTimeout((e) => {
      for (let x = 0; x < this.showList.length; x++) {
        this.$set(this.showList[x], 'dasharray', this.list[x] / this.total * 255)
        if (this.list[x] / this.total * 255 === 0) {
          this.$set(this.showList[x], 'strokeWidth', 0)
        } else {
          this.$set(this.showList[x], 'strokeWidth', this.dasharrayList[x])
        }
      }
    }, 10)
  },
  methods: {
    
  }
}
</script>
<style lang="scss" scoped>

  .card {
    flex: 1;
    position: relative;
  }
  
  .progress {
    width: 230px;
    height: 230px;
    margin: auto;
    text-align: center;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin: auto;

    p {
      color: #666666;
      font-size: 14px;
    }
  }

  .circle_path{
    stroke-dashoffset: 0px;
    transition: stroke-dasharray 0.7s ease-out 0s, stroke 0.7s ease-out 0s;
  }
  
  .circle_track{
    stroke-dasharray: 255px, 295px;
    stroke-dashoffset: 0px;
  }
  
  svg{
    overflow: initial;
    position: absolute;
    transform: rotate(35deg);
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin: auto;
  }
  .detailShow {
    position: absolute;
    z-index: 100;
    left: 50%;
    margin-left: -55px;
    top: 50%;
    margin-top: -7px;

    i {
      font-size: 20px; 
      color: #409EFF; 
      position: relative; 
      top: -30px;
      background: #EAF4FF; 
      padding: 10px;
      border-radius: 50%;
    }

    p {
      color: #409EFF; 
      font-size: 36px !important;
      padding: 0;
      margin: 0;
      line-height: 1;
      font-size: 14px;
      width: 110px;
      text-align: center;
    }
  }

  .bottom-title {
    color: #666666;
    font-size: 14px;
    position: absolute;
    left: 0;
    right: 0;
    bottom: -40px;
    margin: auto;
  }

  @media only screen and (max-width: $device-ipad) { 
    .card {
      width: 100%;
      margin-top: 15px;
    }
  }

  @media only screen and (max-width: $device-phone) { 
    .card {
      width: 100%;
      margin-top: 15px;

      .progress {
        width: 180px;
        height: 180px;
      }
    }
  }
</style>
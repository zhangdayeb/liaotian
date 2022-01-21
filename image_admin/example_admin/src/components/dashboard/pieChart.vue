<template>
  <div class="pie chart">
    <div class="head">
      <p class="line-title">
        <i class="iconfont" style="color: #FF9592; background: rgba(242, 109, 91, 0.15)">&#xe61c;</i>
        <span>分类统计</span>
      </p>
    </div>
    <div class="pie-chart">
      <ve-pie :data="chartData" :settings="chartSettings" :extend="chartExtend"></ve-pie>
    </div>
  </div>
  
</template>

<script>
  export default {
    name: "PieChart",
    data() {
      this.chartSettings = {
        roseType: 'radius'
      }
      this.chartExtend = {
        color: ['#FF8685', '#FF9F43', '#FFC069', '#64B6F6', '#95DE64', '#9BB4F3'],
        legend: {
          show: false
        },
        series: {
          center: ['50%', '40%']
        }
      }
      return {
        chartData: {
          columns: ['类别', '占比'],
          rows: [
            { '类别': '化妆品13%', '占比': 2693 },
            { '类别': '食品类20%', '占比': 3530 },
            { '类别': '烟酒类32%', '占比': 2923 },
            { '类别': '字画28%', '占比': 2423 },
            { '类别': '电子2%', '占比': 3792 },
            { '类别': '骑车配件5%', '占比': 4593 }
          ]
        }
      }
    },
    mounted() {
      
    },
    methods: {
      
    }
  };
</script>

<style lang="scss" scoped>
  .pie {
    width: 30%;
    position: relative;

    .pie-chart {
      height: calc(100% - 80px);
      position: absolute;
      bottom: 20px;
      left: 0;
      right: 0;
      margin: auto;
      overflow: hidden;
    }
  }

  @media only screen and (max-width: $device-ipad) { 
    .pie {
      width: 100%;
      margin-top: 15px;
    }
  }
</style>

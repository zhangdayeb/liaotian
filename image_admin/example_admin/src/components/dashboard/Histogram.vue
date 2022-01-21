<template>
  <div class="his chart">
    <div class="head">
      <p class="line-title">
        <i class="iconfont" style="color: #1890FF; background-color: rgb(230, 247, 255)">&#xe75e;</i>
        <span>消耗短信量</span>
      </p>
    </div>

    <div class="histogram">
      <ve-histogram
        :data="chartData"
        :extend="chartExtend"
      />
    </div>
  </div>
</template>

<script>
  import { indexChart } from '@/api/apiApi'
export default {
  name: "Histogram",
  data() {
    this.chartExtend = {
      // ---- legend ----
      legend: {
        type: 'plain',
        bottom: -1000,
        itemWidth: 10,  // 设置宽度
        itemHeight: 10, // 设置高度
        itemGap: 13, // 设置间距
        textStyle: { //图例文字的样式
          color: '#999',
          fontSize: 12,
        },
      },
      color: [
        new echarts.graphic.LinearGradient(
          0,1,0,0,[{
          offset: 0, color: 'rgba(45, 140, 240, 0.8)'
        },{
          offset: 1, color: 'rgba(66, 197, 246, 0.7)'
        }])
      ],
      series: {
        barMaxWidth: 35,
        barGap: '90%',/*多个并排柱子设置柱子之间的间距*/
        barCategoryGap: '50%',/*多个并排柱子设置柱子之间的间距*/
        itemStyle: {    // 图形的形状
          barBorderRadius: [2, 2, 0 ,0],
        }
      },
      //  ------  X轴 ------
      xAxis: {
        show: true,  // 是否显示
        position: 'bottom',  // x轴的位置
        offset: 8, // x轴相对于默认位置的偏移
        type: 'category',   // 轴类型， 默认为 'category'
        nameGap: 15, // 坐标轴名称与轴线之间的距离
        nameRotate: 0,  // 坐标轴名字旋转
        axisLabel: {//x轴文字的配置
          show: true,
          textStyle: {
            color: "#666",
          }
        },
        axisLine: {       // 坐标轴 轴线
          show: false,  // 是否显示
          lineStyle: {
            color: '#EBEBEB',
            width: 1,
            type: 'solid'
          }
        }
      },
      yAxis: {
        show: true,  // 是否显示
        position: 'left', // y轴位置
        offset: 0, // y轴相对于默认位置的偏移
        type: 'value',  // 轴类型，默认为 ‘category’
        nameLocation: 'end', // 轴名称相对位置value
        nameTextStyle: {    // 坐标轴名称样式
          color: '#fff',
          padding: [5, 0, 0, 5]  // 坐标轴名称相对位置
        },
        nameGap: 15, // 坐标轴名称与轴线之间的距离
        nameRotate: 270,  // 坐标轴名字旋转

        axisLine: {    // 坐标轴 轴线
          show: false,  // 是否显示
          // ----- 线 -------
          lineStyle: {
            color: '#666',
            width: 1,
            type: 'solid'
          }
        },
        axisTick: {      // 坐标轴的刻度
          show: false,    // 是否显示
          inside: true,  // 是否朝内
          length: 3,      // 长度
          lineStyle: {
            color: 'red',  // 默认取轴线的颜色
            width: 1,
            type: 'solid'
          }
        },
        axisLabel: {      // 坐标轴的标签
          show: true,    // 是否显示
          inside: false,  // 是否朝内
          rotate: 0,     // 旋转角度
          margin: 8,     // 刻度标签与轴线之间的距离
          color: '#666',  // 默认轴线的颜色
        },
        splitLine: {    // gird 区域中的分割线
          show: false,   // 是否显示
          lineStyle: {
            color: '#666',
            width: 1,
            type: 'dashed'
          }
        },
        splitArea: {     // 网格区域
          show: false   // 是否显示，默认为false
        }
      },
    }
    return {
      chartData: {
        columns: ['月份', '消耗短信量'],
        rows: []/* [
          { '月份': '1月', '消耗短信量': 1391},
          { '月份': '2月', '消耗短信量': 2530},
          { '月份': '3月', '消耗短信量': 2023},
          { '月份': '4月', '消耗短信量': 1723},
          { '月份': '5月', '消耗短信量': 1492},
          { '月份': '6月', '消耗短信量': 1893},
          { '月份': '7月', '消耗短信量': 2393},
          { '月份': '8月', '消耗短信量': 3030},
          { '月份': '9月', '消耗短信量': 2023},
          { '月份': '10月', '消耗短信量': 2723},
          { '月份': '11月', '消耗短信量': 2023},
          { '月份': '12月', '消耗短信量': 1423},
        ] */
      }
    };
  },
  created:function(){
    indexChart({
      token: localStorage.getItem('token'),
    }).then(res => {
      if(res.code === 1) {
        this.chartData.rows = res.data;
      }
    })
  }
};
</script>

<style lang="scss" scoped>
  .his {
    width: 55%;
    margin-right: 20px;
    position: relative;

    .histogram {
      width: calc(100% - 30px);
      position: absolute;
      bottom: -40px;
      left: 0;
      right: 0;
      margin: auto;
    }
  }

  @media only screen and (max-width: $device-ipad) {
    .his {
      width: 100%;
      margin-right: 0px !important;

      .histogram {
        width: 100%;
      }
    }
  }
</style>

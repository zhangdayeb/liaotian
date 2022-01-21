<template>
  <div class="pro chart">
    <div class="head">
      <p class="line-title">
        <i class="iconfont" style="color: #95DE64; background: rgba(149, 222, 100, 0.15)">&#xe60a;</i>
        <span>计划</span>
      </p>
    </div>
    <div class="table-box">
      <tao-table ref="tables" :data="tableData" :showPage="false" height="100%" :hideScrollBar="true" headBg="">
        <el-table-column prop="title" label="计划事项" />
        <el-table-column label="进度" width="200px" >
          <template slot-scope="scope">
            <el-progress :percentage="scope.row.pro" :color="scope.row.color"/>
          </template>
        </el-table-column>
        <el-table-column width="55px"/>
        <el-table-column prop="startDate" label="开始时间"  />
        <el-table-column prop="endDate" label="结束时间"  />
      </tao-table>
    </div>
  </div>
   
</template>
<script>
  export default {
    data() {
      return {
        tableData: [
          {
            title: '学习Flutter',
            startDate: '2020-1-1',
            endDate: '2020-12-31',
            percentage: 30,
            color: '#69C0FF !important'
          },
          {
            title: '网站重构',
            startDate: '2020-1-1',
            endDate: '2020-12-31',
            percentage: 70,
            color: '#FFC069 !important'
          },
          {
            title: '减肥',
            startDate: '2020-1-1',
            endDate: '2020-12-31',
            percentage: 50,
            color: '#95DE64 !important'
          },
          {
            title: 'Golang',
            startDate: '2020-1-1',
            endDate: '2020-12-31',
            percentage: 80,
            color: '#B7CBE2 !important'
          },
          {
            title: 'TypeScript',
            startDate: '2020-1-1',
            endDate: '2020-12-31',
            percentage: 50,
            color: '#909399 !important'
          },
          {
            title: 'JS深度指南',
            startDate: '2020-1-1',
            endDate: '2020-12-31',
            percentage: 60,
            color: '#9BB4F3 !important'
          },
          {
            title: '设计模式',
            startDate: '2020-1-1',
            endDate: '2020-12-31',
            percentage: 30,
            color: '#F2B985 !important'
          },
          {
            title: '高级程序设计',
            startDate: '2020-1-1',
            endDate: '2020-12-31',
            percentage: 5,
            color: '#F5B7CE !important'
          }
        ],
      }
    },
    mounted() {
      this.addAnimation()
    },
    methods: {
      addAnimation() {
        setTimeout(() => {
          let { tableData } = this
          for(let i=0; i<tableData.length; i++) {
            let item = tableData[i]

            this.$set(this.tableData[i], 'pro', item.percentage)
          }
        }, 1)
      }
    }
  }
</script>

<style lang="scss">
  // 进度动画
  .el-progress-bar__inner {
    transition: all 1s !important;
  }
</style>

<style lang="scss" scoped>
  .pro {
    flex: 1;
    padding-bottom: 30px; 

    .table-box {
      padding: 0 8px;
      height: calc(100% - 30px);
    }
  }

  /deep/ .el-table .cell {
    font-size: 13px;
  }

  @media only screen and (max-width: $device-ipad) { 
    .pro {
      width: 100% !important;
      margin-top: 15px;
      padding-bottom: 30px; 
    }
  }
</style>
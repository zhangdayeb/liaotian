<template>
  <div class="table-bar">
    <div class="top-wrap" v-show="showSearchWrap">
      <slot name="top"></slot>
    </div>
    <div class="bottom-wrap" v-if="showBottom">
      <div class="left-wrap">
        <slot name="bottom"></slot>
      </div>
      <div class="right-wrap">
        <el-button-group>
          <el-button icon="el-icon-search" @click="isShowSearchWrap()" v-if="layout.indexOf('search') !== -1"/>
          <el-button icon="el-icon-refresh-right" @click="refresh()" v-if="layout.indexOf('refresh') !== -1"/>
          <el-popover placement="bottom-end" width="100" trigger="hover" @show="showPopover" v-if="layout.indexOf('column') !== -1">
            <el-checkbox-group v-model="colOptions" :min="1">
              <el-checkbox v-for="(item, index) in colSelect" :label="item" :key="item" @change="changeColumn($event, index)" />
            </el-checkbox-group>
            <el-button slot="reference" icon="el-icon-s-operation"/>
          </el-popover>
        </el-button-group>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'TableBar',
    inject: ['reload'],
    props: {
      showTop: {
        type: Boolean,
        default: true
      },
      showBottom: {
        type: Boolean,
        default: true
      },
      columns: {
        type: Array,
        default: []
      },
      layout: {
        type: String,
        default: 'search, refresh, column'
      }
    },
    data() {
      return {
        showSearchWrap: true,
        colOptions: [],
        colSelect: [],
        columnChage: false
      };
    },
    mounted() {
      this.showSearchWrap = this.showTop
    },
    methods: {
      // 刷新页面
      refresh() {
        this.reload()
      },
      // 是否显示搜索区域
      isShowSearchWrap() {
        this.showSearchWrap = !this.showSearchWrap
      },
      // 列显示隐藏
      showPopover() {
        if(!this.columnChage) {
          let ops = []
          this.columns.map(item => { ops.push(item.name) })
          this.colOptions = ops
          this.colSelect = ops
          this.columnChage = true
        }
      },
      // 选择列
      changeColumn(show, index) {
        let columns = this.columns

        columns.map((item, i) => { 
          if(index === i) {
            item.show = show
          }
        })

        this.$emit('changeColumn', columns)
      }
    }
  };
</script>

<style lang="scss" scoped>
  .table-bar {
    padding-bottom: 15px;

    .top-wrap {
      transition: height .3s;
    }

    .bottom-wrap {
      display: flex;
      justify-content: space-between;
    }
  }

  @media screen and (max-width: $device-phone){
    /deep/ .el-form {
      padding-bottom: 15px;
    }
  }
</style>

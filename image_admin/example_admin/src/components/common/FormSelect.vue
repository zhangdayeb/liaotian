<template>
  <el-col :xs="24" :sm="12" :lg="6">
    <el-form-item :label="label+'：'">
      <el-select 
        :value="value" 
        :clearable="clearable" 
        :placeholder="placeholder" 
        style="width: 100%" 
        @input="inputChange($event)"
      >
        <el-option
          v-for="item in options"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
    </el-form-item>
  </el-col>
</template>

<script>
  export default {
    props: {
      label: String,
      value: String,
      options: Array,
      placeholder: {
        type: String,
        default: '请选择'
      },
      clearable: {
        type: Boolean,
        default: true
      }
    },
    data() {
      return {
        place: ''
      }
    },
    mounted() {
      this.initPlaceholder()
    },
    methods: {
      initPlaceholder() {
        this.place = this.placeholder || this.label
      },
      inputChange(val) {
        this.$emit("input", val)
      },
    },
  };
</script>
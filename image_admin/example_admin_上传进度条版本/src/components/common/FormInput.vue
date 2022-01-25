<template>
  <el-col :xs="24" :sm="12" :lg="6">
    <el-form-item :label="label+'：'">
      <el-input :value="value" @input="inputChange($event)" :placeholder="place"></el-input>
    </el-form-item>
  </el-col>
</template>

<script>
  export default {
    props: {
      label: String,
      value: String,
      placeholder: String
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
import Vue from 'vue';
import App from './App';
import _mixins from './common/_mixins';
import _common from './common/common';
import _data from './common/_data';
import store from './store';

import hxNavbar from "./components/hx-navbar/hx-navbar.vue";
import servingView from "./components/serving-view/index.vue"
Vue.component('serving-view',servingView);
Vue.component('hx-navbar', hxNavbar);
// 关闭生产提示
Vue.config.productionTip = false;
Vue.prototype.$store = store;
// 小程序页面组件和这个`App.vue`组件的写法和引入方式是一致的，为了区分两者，需要设置`mpType`值
App.mpType = 'app';
import { mapState,mapMutations } from 'vuex';
Vue.mixin(_mixins);
Vue.mixin(_common);
Vue.mixin({
    data(){
      return {
          X: 260,
          Y: 180,
      }
    },
    onLoad() {
      if (this.$initData$) {
          Object.assign(this, JSON.parse(this.$initData$))
      } else {
          this.$initData$ = JSON.stringify(this.$data)
      }
    },
    onShow(){
        let dragInfo = getApp().globalData['dragInfo'];;
        this.X = dragInfo.moveX;
        this.Y = dragInfo.moveY;
    }
})
const app = new Vue({
    store,
    ...App
});

app.$mount();

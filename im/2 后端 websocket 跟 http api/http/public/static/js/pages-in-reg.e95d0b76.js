(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-in-reg"],{"0f82":function(n,t,i){t=n.exports=i("2350")(!1),t.push([n.i,".landing[data-v-66450865]{height:%?84?%;line-height:%?84?%;color:#fff;font-size:%?32?%;bordor:none;border-radius:%?10?%}.placeholdertext[data-v-66450865]{\n\twidth:%?48?%;\n\t\n\theight:%?24?%}.landing_false[data-v-66450865]{background-color:#d8d8d8}.login-btn[data-v-66450865]{padding:%?10?% %?20?%;margin-top:%?100?%;text-align:center}.login-input uni-input[data-v-66450865]{background:#f2f5f6;font-size:%?28?%;padding:%?10?% %?25?%;height:%?62?%;line-height:%?62?%;border-radius:%?8?%}.login-margin-b[data-v-66450865]{margin-bottom:%?25?%}.login-input[data-v-66450865]{padding:%?20?% %?20?%}.login-head[data-v-66450865]{font-size:%?34?%;text-align:center;margin-top:%?35?%;margin-bottom:%?24?%;padding:%?25?% %?80?% %?130?% %?10?%}.login-card[data-v-66450865]{background:#fff;border-radius:%?12?%;padding:%?10?% %?25?%;\n\t/* box-shadow: 0 6upx 18upx rgba(0,0,0,0.12); */position:relative;margin-top:%?100?%}.login-bg[data-v-66450865]{\n\t/* height: 260upx;\n\tpadding: 25upx;\n\tbackground: linear-gradient(#FF978D, #FFBB69); */}.uni-input[data-v-66450865]{height:%?50?%;width:%?460?%;padding:%?15?% 0 %?15?% %?25?%;line-height:%?50?%;font-size:%?28?%;background:#fff;-webkit-box-flex:1;-webkit-flex:1;-ms-flex:1;flex:1}.uni-icon[data-v-66450865]{text-align:left}uni-page-body[data-v-66450865]{background-color:#fff}body.?%PAGE?%[data-v-66450865]{background-color:#fff}",""])},"15c7":function(n,t,i){"use strict";var a=function(){var n=this,t=n.$createElement,i=n._self._c||t;return i("v-uni-view",{staticClass:"content"},[i("v-uni-view",{staticClass:"login-bg"},[i("v-uni-view",{staticClass:"login-card"},[i("v-uni-view",{staticClass:"login-head"},[n._v("输入您的注册信息")]),i("v-uni-label",{staticClass:"uni-list-cell uni-list-cell-pd"},[i("v-uni-label",{staticClass:"label-2-text"},[i("v-uni-text",[n._v("帐号")])],1),i("v-uni-view",[i("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",placeholder:"手机号/相遇号(6-16位字母/数字)"},model:{value:n.form.username,callback:function(t){n.$set(n.form,"username",t)},expression:"form.username"}})],1),n.form.username?i("v-uni-view",{staticClass:"uni-icon uni-icon-clear",on:{click:function(t){t=n.$handleEvent(t),n.delInputUsernameText(t)}}}):i("v-uni-view",{staticClass:"uni-icon"}),i("v-uni-view",{staticClass:"uni-icon placeholdertext"})],1),i("v-uni-label",{staticClass:"uni-list-cell uni-list-cell-pd"},[i("v-uni-label",{staticClass:"label-2-text"},[i("v-uni-text",[n._v("密码")])],1),i("v-uni-view",[i("v-uni-input",{staticClass:"uni-input",attrs:{placeholder:"请输入密码(6-16位)",password:n.showPassword},model:{value:n.form.password,callback:function(t){n.$set(n.form,"password",t)},expression:"form.password"}})],1),n.form.password?i("v-uni-view",{staticClass:"uni-icon uni-icon-clear",on:{click:function(t){t=n.$handleEvent(t),n.delInputPasswordText(t)}}}):i("v-uni-view",{staticClass:"uni-icon"}),i("v-uni-view",{staticClass:"uni-icon uni-icon-eye",class:[n.showPassword?"":"uni-active"],on:{click:function(t){t=n.$handleEvent(t),n.changePassword(t)}}})],1)],1)],1),i("v-uni-view",{staticClass:"login-btn"},[i("v-uni-button",{class:["landing",n.checkIn?"landing_true":"landing_false"],attrs:{disabled:!n.checkIn,type:"primary"},on:{click:function(t){t=n.$handleEvent(t),n.subReg(t)}}},[n._v("注 册")])],1)],1)},e=[];i.d(t,"a",function(){return a}),i.d(t,"b",function(){return e})},"1cf6":function(n,t,i){"use strict";i.r(t);var a=i("33e9"),e=i.n(a);for(var s in a)"default"!==s&&function(n){i.d(t,n,function(){return a[n]})}(s);t["default"]=e.a},"1d33":function(n,t,i){"use strict";var a=i("fbac"),e=i.n(a);e.a},"33e9":function(n,t,i){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var a={data:function(){return{showPassword:!0,form:{username:"",password:""}}},onLoad:function(){},computed:{checkIn:function(){return""!=this.form.password&&""!=this.form.username&&this.form.password.length>5&&this.form.username.length>5}},methods:{changePassword:function(){this.showPassword=!this.showPassword},delInputUsernameText:function(){this.form.username=""},delInputPasswordText:function(){this.form.password=""},subReg:function(){var n=this;n.checkIn&&(/^\w{1,20}$/.test(this.form.username)?/^\w{1,20}$/.test(this.form.password)?n.$httpSend({path:"/im/in/reg",data:n.form,success:function(n){uni.setStorage({key:"token",data:n.token,fail:function(){uni.showModal({content:"本地存储数据不可用!"})},success:function(){uni.reLaunch({url:"../chat/index"})}})}}):uni.showModal({content:"密码只能包括下划线、数字、字母,长度6-20位"}):uni.showModal({content:"相遇号只能包括下划线、数字、字母,并且不能超过20个"}))},go_forget:function(){uni.navigateTo({url:"../../pages/in/forget"})},go_register:function(){uni.navigateTo({url:"../../pages/in/reg"})}}};t.default=a},"715e":function(n,t,i){"use strict";i.r(t);var a=i("15c7"),e=i("1cf6");for(var s in e)"default"!==s&&function(n){i.d(t,n,function(){return e[n]})}(s);i("1d33");var o=i("2877"),u=Object(o["a"])(e["default"],a["a"],a["b"],!1,null,"66450865",null);t["default"]=u.exports},fbac:function(n,t,i){var a=i("0f82");"string"===typeof a&&(a=[[n.i,a,""]]),a.locals&&(n.exports=a.locals);var e=i("4f06").default;e("6f688ba2",a,!0,{sourceMap:!1,shadowMode:!1})}}]);
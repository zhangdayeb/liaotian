(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-chat-message-hand_lei"],{"0ef8":function(t,e,n){"use strict";var i;n.d(e,"b",(function(){return a})),n.d(e,"c",(function(){return s})),n.d(e,"a",(function(){return i}));var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-uni-view",[n("v-uni-view",{staticClass:"content",class:t.typeClass},[n("v-uni-view",{staticClass:"luck"},[n("v-uni-view",{staticClass:"row"},[n("v-uni-view",{staticClass:"term"},[t._v("红包个数")]),n("v-uni-view",{staticClass:"input"},[n("v-uni-input",{attrs:{type:"number",placeholder:"输入红包个数"},model:{value:t.number,callback:function(e){t.number=e},expression:"number"}}),t._v("个")],1)],1),n("v-uni-view",{staticClass:"row"},[n("v-uni-view",{staticClass:"term"},[t._v("总金额")]),n("v-uni-view",{staticClass:"input"},[n("v-uni-input",{attrs:{type:"number",placeholder:"输入金额"},model:{value:t.luckMoney,callback:function(e){t.luckMoney=e},expression:"luckMoney"}}),t._v("元")],1)],1),n("v-uni-view",{staticClass:"row"},[n("v-uni-view",{staticClass:"term"},[t._v("红包雷值")]),n("v-uni-view",{staticClass:"input"},[t.lei.length?t._e():n("v-uni-input",{attrs:{type:"number",disabled:"true",placeholder:"请点击下方选择雷值"}}),t.lei.length?n("v-uni-view",{staticClass:"lei-content"},t._l(t.lei,(function(e,i){return n("v-uni-view",{staticClass:"input-num"},[t._v(t._s(e))])})),1):t._e()],1)],1),n("v-uni-view",{staticClass:"tis"},[t._v("* 提示再次点击选中的雷为取消")]),n("v-uni-view",{staticClass:"blessing"},[n("v-uni-view",{class:["input-num-select",t.selected_num0?" active":""],on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.taptLei(0)}}},[t._v("0")]),n("v-uni-view",{class:["input-num-select",t.selected_num1?" active":""],on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.taptLei(1)}}},[t._v("1")]),n("v-uni-view",{class:["input-num-select",t.selected_num2?" active":""],on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.taptLei(2)}}},[t._v("2")]),n("v-uni-view",{class:["input-num-select",t.selected_num3?" active":""],on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.taptLei(3)}}},[t._v("3")]),n("v-uni-view",{class:["input-num-select",t.selected_num4?" active":""],on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.taptLei(4)}}},[t._v("4")]),n("v-uni-view",{class:["input-num-select",t.selected_num5?" active":""],on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.taptLei(5)}}},[t._v("5")]),n("v-uni-view",{class:["input-num-select",t.selected_num6?" active":""],on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.taptLei(6)}}},[t._v("6")]),n("v-uni-view",{class:["input-num-select",t.selected_num7?" active":""],on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.taptLei(7)}}},[t._v("7")]),n("v-uni-view",{class:["input-num-select",t.selected_num8?" active":""],on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.taptLei(8)}}},[t._v("8")]),n("v-uni-view",{class:["input-num-select",t.selected_num9?" active":""],on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.taptLei(9)}}},[t._v("9")])],1),n("v-uni-view",{staticClass:"hand",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.hand("luck")}}},[t._v("发红包")])],1),n("v-uni-view",{staticClass:"normal"},[n("v-uni-view",{staticClass:"row"},[n("v-uni-view",{staticClass:"term"},[t._v("红包个数")]),n("v-uni-view",{staticClass:"input"},[n("v-uni-input",{attrs:{type:"number",placeholder:"输入红包个数"},model:{value:t.number,callback:function(e){t.number=e},expression:"number"}}),t._v("个")],1)],1),n("v-uni-view",{staticClass:"row"},[n("v-uni-view",{staticClass:"term"},[t._v("单个金额")]),n("v-uni-view",{staticClass:"input"},[n("v-uni-input",{attrs:{type:"number",placeholder:"输入金额"},model:{value:t.money,callback:function(e){t.money=e},expression:"money"}}),t._v("元")],1)],1),n("v-uni-view",{staticClass:"tis"},[t._v("小伙伴领取的金额相同")]),n("v-uni-view",{staticClass:"blessing"},[n("v-uni-input",{attrs:{type:"text",maxlength:"12",placeholder:"恭喜发财"},model:{value:t.blessing,callback:function(e){t.blessing=e},expression:"blessing"}})],1),n("v-uni-view",{staticClass:"hand",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.hand("normal")}}},[t._v("发红包")])],1)],1)],1)},s=[]},"5f965":function(t,e,n){"use strict";n.r(e);var i=n("b41f"),a=n.n(i);for(var s in i)"default"!==s&&function(t){n.d(e,t,(function(){return i[t]}))}(s);e["default"]=a.a},"6e30":function(t,e,n){var i=n("24fb");e=i(!1),e.push([t.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */uni-page-body[data-v-10d1b797]{background-color:#f3f3f3}uni-view[data-v-10d1b797]{display:flex;flex-wrap:wrap}.tabr[data-v-10d1b797]{width:94%;height:%?105?%;padding:0 3%;border-bottom:solid %?1?% #dedede}.tabr uni-view[data-v-10d1b797]{width:50%;height:%?100?%;justify-content:center;align-items:center;font-size:%?28?%;color:#999}.tabr .on[data-v-10d1b797]{color:#cf3c35}.tabr .border[data-v-10d1b797]{height:%?4?%;background-color:#cf3c35;transition:all .3s ease-out}.tabr .border.normal[data-v-10d1b797]{-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}.content[data-v-10d1b797]{width:100%;height:80vh;overflow:hidden}.content.normal .luck[data-v-10d1b797]{-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}.content.normal .normal[data-v-10d1b797]{-webkit-transform:translate3d(0,-100%,0);transform:translate3d(0,-100%,0)}.content .luck[data-v-10d1b797], .content .normal[data-v-10d1b797]{transition:all .3s ease-out}.content .normal[data-v-10d1b797]{-webkit-transform:translate3d(100%,-100%,0);transform:translate3d(100%,-100%,0)}.content .row[data-v-10d1b797], .content .tis[data-v-10d1b797], .content .blessing[data-v-10d1b797], .content .hand[data-v-10d1b797]{width:94%}.content .row[data-v-10d1b797], .content .tis[data-v-10d1b797], .content .blessing[data-v-10d1b797]{border-bottom:#dedede solid %?1?%}.content .row[data-v-10d1b797], .content .blessing[data-v-10d1b797]{padding:%?30?%;background-color:#fff;display:flex;justify-items:center;justify-content:center}.content .row[data-v-10d1b797], .content .hand[data-v-10d1b797]{align-items:center}.content .row[data-v-10d1b797]{justify-content:space-between;flex-wrap:nowrap}.content .row .term[data-v-10d1b797], .content .row .input[data-v-10d1b797]{width:50%}.content .row .input[data-v-10d1b797]{flex-shrink:0;flex-wrap:nowrap;justify-content:flex-end;align-items:center}.content .row .input uni-input[data-v-10d1b797]{height:%?50?%;display:flex;justify-content:flex-end;align-items:center;text-align:right;margin-right:%?20?%;font-size:%?30?%}.content .input-lei[data-v-10d1b797]{flex-shrink:0;flex-wrap:nowrap;justify-content:flex-end;align-items:center}.content .input-lei uni-text[data-v-10d1b797]{height:%?50?%;display:flex;justify-content:flex-start;align-items:center;text-align:left;margin-right:%?20?%;font-size:%?30?%}.content .tis[data-v-10d1b797]{height:%?60?%;padding:%?20?% 3%;font-size:16px;color:red}.content .hand[data-v-10d1b797]{margin:%?30?% 3%;background-color:#cf3c35;color:#fff;font-size:%?34?%;justify-content:center;border-radius:%?10?%;height:%?100?%}.content .input-num[data-v-10d1b797]{width:20px;height:20px;font-size:12px;font-weight:700;line-height:20px;text-align:center;background:url(/static/theme/default/chat/lei1.png) no-repeat;background-size:100% 100%;display:inline-block;margin-left:5px}.input-num-select[data-v-10d1b797]{display:inline-block;width:50px;height:50px;line-height:50px;text-align:center;border-radius:100%;background:#fff;font-size:18px;font-weight:700;margin:0 9px 10px 0;background:url(/static/theme/default/chat/lei1.png) no-repeat;background-size:100% 100%}.input-num-select[data-v-10d1b797]:nth-child(2n){background:url(/static/theme/default/chat/lei2.png) no-repeat!important;background-size:100% 100%!important}.lei-content[data-v-10d1b797]{display:flex;word-break:break-all;width:%?300?%;justify-content:flex-end}.blessing .active[data-v-10d1b797]{background:url(/static/theme/default/chat/lei3.png) no-repeat!important;background-size:100% 100%!important}body.?%PAGE?%[data-v-10d1b797]{background-color:#f3f3f3}',""]),t.exports=e},7783:function(t,e,n){"use strict";n.r(e);var i=n("0ef8"),a=n("5f965");for(var s in a)"default"!==s&&function(t){n.d(e,t,(function(){return a[t]}))}(s);n("f7af");var c,l=n("f0c5"),u=Object(l["a"])(a["default"],i["b"],i["c"],!1,null,"10d1b797",null,!1,i["a"],c);e["default"]=u.exports},b41f:function(t,e,n){"use strict";(function(t){var i=n("4ea4");n("c975"),n("a434"),n("e25e"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=i(n("e04a")),s=i(n("eefd")),c=(i(n("b516")),{data:function(){return{typeClass:"luck",number:"",money:"",luckMoney:"",blessing:"",click:!0,lei:[],page_params:{},selected_num0:!1,selected_num1:!1,selected_num2:!1,selected_num3:!1,selected_num4:!1,selected_num5:!1,selected_num6:!1,selected_num7:!1,selected_num8:!1,selected_num9:!1}},onLoad:function(t){var e=this;e.page_params=t},onShow:function(){s.default.routeTabBarHook()},computed:{},methods:{deleteNum:function(t){var e=this.lei.indexOf(t);this.lei.splice(e,1)},taptLei:function(t){switch(t){case 0:return this.selected_num0?(this.deleteNum(t),this.selected_num0=!1):(this.lei.push(t),this.selected_num0=!0);case 1:return this.selected_num1?(this.deleteNum(t),this.selected_num1=!1):(this.lei.push(t),this.selected_num1=!0);case 2:return this.selected_num2?(this.deleteNum(t),this.selected_num2=!1):(this.lei.push(t),this.selected_num2=!0);case 3:return this.selected_num3?(this.deleteNum(t),this.selected_num3=!1):(this.lei.push(t),this.selected_num3=!0);case 4:return this.selected_num4?(this.deleteNum(t),this.selected_num4=!1):(this.lei.push(t),this.selected_num4=!0);case 5:return this.selected_num5?(this.deleteNum(t),this.selected_num5=!1):(this.lei.push(t),this.selected_num5=!0);case 6:return this.selected_num6?(this.deleteNum(t),this.selected_num6=!1):(this.lei.push(t),this.selected_num6=!0);case 7:return this.selected_num7?(this.deleteNum(t),this.selected_num7=!1):(this.lei.push(t),this.selected_num7=!0);case 8:return this.selected_num8?(this.deleteNum(t),this.selected_num8=!1):(this.lei.push(t),this.selected_num8=!0);case 9:return this.selected_num9?(this.deleteNum(t),this.selected_num9=!1):(this.lei.push(t),this.selected_num9=!0)}},switchType:function(t){this.typeClass=t},hand:function(e){var n=this,i={type:2,num:this.number,hongbao_msg:this.lei,amount:this.money};return"luck"==e&&(i.amount=this.luckMoney),n.lei.length<=0?uni.showToast({title:"请选择红包雷",icon:"none"}):!i.amount||i.amount<=0?uni.showToast({title:"金额不能为空",icon:"none"}):i.num!=Math.abs(parseInt(i.num))?uni.showToast({title:"数量填写大于0的整数",icon:"none"}):(i.hongbao_msg=JSON.stringify(i.hongbao_msg)||"恭喜发财",i=Object.assign(this.page_params,i),void a.default.checkBeforePay(i,(function(t){a.default.createLeiHongBao(i,(function(t){uni.navigateTo({url:"../message?list_id="+n.page_params.list_id})}),(function(t){n.click=!0,uni.showToast({title:t.msg,icon:"none"})}))}),(function(e){t.log("fail callback"),uni.showToast({title:e.msg,icon:"none"})}),(function(t){uni.showToast({title:t.msg,icon:"none"})})))},getPassword:function(e){t.log("参数传递",e);var n=this;if(!n.click)return!1;n.click=!1,uni.showLoading({title:"提交中"}),a.default.createLeiHongBao(e,(function(t){uni.navigateTo({url:"../message?list_id="+n.page_params.list_id})}),(function(t){n.click=!0}))}}});e.default=c}).call(this,n("5a52")["default"])},b4a7:function(t,e,n){var i=n("6e30");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var a=n("4f06").default;a("b888ba24",i,!0,{sourceMap:!1,shadowMode:!1})},eefd:function(t,e,n){"use strict";var i=n("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=i(n("e4f8")),s={routeTabBarHook:function(){a.default.routeTool(),a.default.setStatusTips()},routeSonHook:function(){a.default.routeTool()}};e.default=s},f7af:function(t,e,n){"use strict";var i=n("b4a7"),a=n.n(i);a.a}}]);
(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-push-web"],{"43ad":function(t,e,u){"use strict";var n=u("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var r=n(u("4a44")),o={components:{},data:function(){return{url:!1}},onShow:function(){r.default.routeTabBarHook()},onLoad:function(t){"url"in t&&(t.url=decodeURIComponent(t.url),/^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:\/?#[\]@!\$&'\*\+,;=.]+$/.test(t.url)&&(/^http/.test(t.url)||(t.url="http://"+t.url),this.url=t.url))},computed:{},methods:{},onNavigationBarButtonTap:function(t){switch(t.index){case 0:uni.switchTab({url:"../chat/index"});break;case 1:location.reload();break;case 2:history.forward();break;default:break}}};e.default=o},"4a44":function(t,e,u){"use strict";var n=u("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var r=n(u("1d68")),o={routeTabBarHook:function(){r.default.routeTool(),r.default.setStatusTips()},routeSonHook:function(){r.default.routeTool()}};e.default=o},"7d52":function(t,e,u){"use strict";u.r(e);var n=u("43ad"),r=u.n(n);for(var o in n)"default"!==o&&function(t){u.d(e,t,function(){return n[t]})}(o);e["default"]=r.a},b395:function(t,e,u){"use strict";var n=function(){var t=this,e=t.$createElement,u=t._self._c||e;return u("v-uni-view",[t.url?u("v-uni-web-view",{attrs:{src:t.url}}):u("v-uni-text",{staticStyle:{"text-align":"center",color:"red"}},[t._v("无效的地址")])],1)},r=[];u.d(e,"a",function(){return n}),u.d(e,"b",function(){return r})},f1bb:function(t,e,u){"use strict";u.r(e);var n=u("b395"),r=u("7d52");for(var o in r)"default"!==o&&function(t){u.d(e,t,function(){return r[t]})}(o);var a=u("2877"),i=Object(a["a"])(r["default"],n["a"],n["b"],!1,null,"634ceeef",null);e["default"]=i.exports}}]);
(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-push-game_site"],{"3e55":function(t,e,n){"use strict";n.r(e);var u=n("63e0"),a=n("a76a");for(var o in a)"default"!==o&&function(t){n.d(e,t,(function(){return a[t]}))}(o);var i,r=n("f0c5"),d=Object(r["a"])(a["default"],u["b"],u["c"],!1,null,"283d5d22",null,!1,u["a"],i);e["default"]=d.exports},"63e0":function(t,e,n){"use strict";var u;n.d(e,"b",(function(){return a})),n.d(e,"c",(function(){return o})),n.d(e,"a",(function(){return u}));var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-uni-view",[n("v-uni-web-view",{attrs:{src:"https://api.9idudu.com/sdkweb/?appId=LIU_DA"}})],1)},o=[]},"7c15":function(t,e,n){"use strict";(function(t){var u=n("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=u(n("eefd")),o={components:{},data:function(){return{url:"https://api.9idudu.com/sdkweb/?appId=LIU_DA",agent_user_id:0}},onShow:function(){a.default.routeTabBarHook()},onReady:function(){setTimeout((function(){uni.hideLoading()}),1e3)},onLoad:function(t){uni.showLoading({title:null}),"url"in t&&(t.url=decodeURIComponent(t.url),/^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\*\+,;=.]+$/.test(t.url)&&(/^http/.test(t.url)||(t.url="http://"+t.url),this.url=t.url)),"agent_user_id"in t&&(this.agent_user_id=t.agent_user_id)},computed:{},methods:{},onNavigationBarButtonTap:function(e){switch(t.log(e.index),e.index){case 0:location.reload();break;case 1:location.reload();break;case 2:uni.switchTab({url:"../push/game"});break;case 3:uni.navigateBack();break;default:break}}};e.default=o}).call(this,n("5a52")["default"])},a76a:function(t,e,n){"use strict";n.r(e);var u=n("7c15"),a=n.n(u);for(var o in u)"default"!==o&&function(t){n.d(e,t,(function(){return u[t]}))}(o);e["default"]=a.a},eefd:function(t,e,n){"use strict";var u=n("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=u(n("e4f8")),o={routeTabBarHook:function(){a.default.routeTool(),a.default.setStatusTips()},routeSonHook:function(){a.default.routeTool()}};e.default=o}}]);
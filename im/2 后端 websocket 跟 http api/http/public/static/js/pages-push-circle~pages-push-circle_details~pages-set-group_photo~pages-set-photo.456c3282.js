(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-push-circle~pages-push-circle_details~pages-set-group_photo~pages-set-photo"],{"3b8d":function(t,e,i){"use strict";i.r(e),i.d(e,"default",function(){return r});var a=i("795b"),n=i.n(a);function s(t,e,i,a,s,r,o){try{var h=t[r](o),l=h.value}catch(c){return void i(c)}h.done?e(l):n.a.resolve(l).then(a,s)}function r(t){return function(){var e=this,i=arguments;return new n.a(function(a,n){var r=t.apply(e,i);function o(t){s(r,a,n,o,h,"next",t)}function h(t){s(r,a,n,o,h,"throw",t)}o(void 0)})}}},"4a44":function(t,e,i){"use strict";var a=i("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=a(i("1d68")),s={routeTabBarHook:function(){n.default.routeTool(),n.default.setStatusTips()},routeSonHook:function(){n.default.routeTool()}};e.default=s},"5fb3":function(t,e,i){"use strict";i.r(e);var a=i("dbfc"),n=i("a0d3");for(var s in n)"default"!==s&&function(t){i.d(e,t,function(){return n[t]})}(s);i("6a87");var r=i("2877"),o=Object(r["a"])(n["default"],a["a"],a["b"],!1,null,"12df1bec",null);e["default"]=o.exports},"6a87":function(t,e,i){"use strict";var a=i("da0f"),n=i.n(a);n.a},"96cf":function(t,e){!function(e){"use strict";var i,a=Object.prototype,n=a.hasOwnProperty,s="function"===typeof Symbol?Symbol:{},r=s.iterator||"@@iterator",o=s.asyncIterator||"@@asyncIterator",h=s.toStringTag||"@@toStringTag",l="object"===typeof t,c=e.regeneratorRuntime;if(c)l&&(t.exports=c);else{c=e.regeneratorRuntime=l?t.exports:{},c.wrap=b;var d="suspendedStart",f="suspendedYield",u="executing",p="completed",v={},x={};x[r]=function(){return this};var g=Object.getPrototypeOf,w=g&&g(g(D([])));w&&w!==a&&n.call(w,r)&&(x=w);var y=W.prototype=k.prototype=Object.create(x);S.prototype=y.constructor=W,W.constructor=S,W[h]=S.displayName="GeneratorFunction",c.isGeneratorFunction=function(t){var e="function"===typeof t&&t.constructor;return!!e&&(e===S||"GeneratorFunction"===(e.displayName||e.name))},c.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,W):(t.__proto__=W,h in t||(t[h]="GeneratorFunction")),t.prototype=Object.create(y),t},c.awrap=function(t){return{__await:t}},H(T.prototype),T.prototype[o]=function(){return this},c.AsyncIterator=T,c.async=function(t,e,i,a){var n=new T(b(t,e,i,a));return c.isGeneratorFunction(e)?n:n.next().then(function(t){return t.done?t.value:n.next()})},H(y),y[h]="Generator",y[r]=function(){return this},y.toString=function(){return"[object Generator]"},c.keys=function(t){var e=[];for(var i in t)e.push(i);return e.reverse(),function i(){while(e.length){var a=e.pop();if(a in t)return i.value=a,i.done=!1,i}return i.done=!0,i}},c.values=D,C.prototype={constructor:C,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=i,this.done=!1,this.delegate=null,this.method="next",this.arg=i,this.tryEntries.forEach(P),!t)for(var e in this)"t"===e.charAt(0)&&n.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=i)},stop:function(){this.done=!0;var t=this.tryEntries[0],e=t.completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function a(a,n){return o.type="throw",o.arg=t,e.next=a,n&&(e.method="next",e.arg=i),!!n}for(var s=this.tryEntries.length-1;s>=0;--s){var r=this.tryEntries[s],o=r.completion;if("root"===r.tryLoc)return a("end");if(r.tryLoc<=this.prev){var h=n.call(r,"catchLoc"),l=n.call(r,"finallyLoc");if(h&&l){if(this.prev<r.catchLoc)return a(r.catchLoc,!0);if(this.prev<r.finallyLoc)return a(r.finallyLoc)}else if(h){if(this.prev<r.catchLoc)return a(r.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<r.finallyLoc)return a(r.finallyLoc)}}}},abrupt:function(t,e){for(var i=this.tryEntries.length-1;i>=0;--i){var a=this.tryEntries[i];if(a.tryLoc<=this.prev&&n.call(a,"finallyLoc")&&this.prev<a.finallyLoc){var s=a;break}}s&&("break"===t||"continue"===t)&&s.tryLoc<=e&&e<=s.finallyLoc&&(s=null);var r=s?s.completion:{};return r.type=t,r.arg=e,s?(this.method="next",this.next=s.finallyLoc,v):this.complete(r)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),v},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var i=this.tryEntries[e];if(i.finallyLoc===t)return this.complete(i.completion,i.afterLoc),P(i),v}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var i=this.tryEntries[e];if(i.tryLoc===t){var a=i.completion;if("throw"===a.type){var n=a.arg;P(i)}return n}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,a){return this.delegate={iterator:D(t),resultName:e,nextLoc:a},"next"===this.method&&(this.arg=i),v}}}function b(t,e,i,a){var n=e&&e.prototype instanceof k?e:k,s=Object.create(n.prototype),r=new C(a||[]);return s._invoke=R(t,i,r),s}function m(t,e,i){try{return{type:"normal",arg:t.call(e,i)}}catch(a){return{type:"throw",arg:a}}}function k(){}function S(){}function W(){}function H(t){["next","throw","return"].forEach(function(e){t[e]=function(t){return this._invoke(e,t)}})}function T(t){function e(i,a,s,r){var o=m(t[i],t,a);if("throw"!==o.type){var h=o.arg,l=h.value;return l&&"object"===typeof l&&n.call(l,"__await")?Promise.resolve(l.__await).then(function(t){e("next",t,s,r)},function(t){e("throw",t,s,r)}):Promise.resolve(l).then(function(t){h.value=t,s(h)},function(t){return e("throw",t,s,r)})}r(o.arg)}var i;function a(t,a){function n(){return new Promise(function(i,n){e(t,a,i,n)})}return i=i?i.then(n,n):n()}this._invoke=a}function R(t,e,i){var a=d;return function(n,s){if(a===u)throw new Error("Generator is already running");if(a===p){if("throw"===n)throw s;return E()}i.method=n,i.arg=s;while(1){var r=i.delegate;if(r){var o=I(r,i);if(o){if(o===v)continue;return o}}if("next"===i.method)i.sent=i._sent=i.arg;else if("throw"===i.method){if(a===d)throw a=p,i.arg;i.dispatchException(i.arg)}else"return"===i.method&&i.abrupt("return",i.arg);a=u;var h=m(t,e,i);if("normal"===h.type){if(a=i.done?p:f,h.arg===v)continue;return{value:h.arg,done:i.done}}"throw"===h.type&&(a=p,i.method="throw",i.arg=h.arg)}}}function I(t,e){var a=t.iterator[e.method];if(a===i){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=i,I(t,e),"throw"===e.method))return v;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return v}var n=m(a,t.iterator,e.arg);if("throw"===n.type)return e.method="throw",e.arg=n.arg,e.delegate=null,v;var s=n.arg;return s?s.done?(e[t.resultName]=s.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=i),e.delegate=null,v):s:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,v)}function L(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function P(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function C(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(L,this),this.reset(!0)}function D(t){if(t){var e=t[r];if(e)return e.call(t);if("function"===typeof t.next)return t;if(!isNaN(t.length)){var a=-1,s=function e(){while(++a<t.length)if(n.call(t,a))return e.value=t[a],e.done=!1,e;return e.value=i,e.done=!0,e};return s.next=s}}return{next:E}}function E(){return{value:i,done:!0}}}(function(){return this||"object"===typeof self&&self}()||Function("return this")())},a0d3:function(t,e,i){"use strict";i.r(e);var a=i("fca2"),n=i.n(a);for(var s in a)"default"!==s&&function(t){i.d(e,t,function(){return a[t]})}(s);e["default"]=n.a},d6d3:function(t,e,i){e=t.exports=i("2350")(!1),e.push([t.i,".my-canvas[data-v-12df1bec]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;position:fixed!important;background:#000;left:0;z-index:100000;width:100%}.my-avatar[data-v-12df1bec]{width:%?150?%;height:%?150?%;border-radius:100%}.oper-canvas[data-v-12df1bec]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;position:fixed!important;left:0;z-index:100001;width:100%}.prv-canvas[data-v-12df1bec]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;position:fixed!important;background:#000;left:0;z-index:200000;width:100%}.oper-wrapper[data-v-12df1bec]{height:50px;position:fixed!important;-webkit-box-sizing:border-box;box-sizing:border-box;border:1px solid #f1f1f1;background:#fff;width:100%;left:0;bottom:0;z-index:100009;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row}.oper[data-v-12df1bec]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;padding:%?10?% %?20?%;width:100%;height:100%;-webkit-box-sizing:border-box;box-sizing:border-box;-webkit-align-self:center;-ms-flex-item-align:center;align-self:center}.btn-wrapper[data-v-12df1bec]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;\n\t\n\theight:50px;\n\t-webkit-box-pack:justify;-webkit-justify-content:space-between;-ms-flex-pack:justify;justify-content:space-between}.btn-wrapper uni-view[data-v-12df1bec]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;font-size:16px;color:#333;border:1px solid #f1f1f1;border-radius:6%}.hover[data-v-12df1bec]{background:#f1f1f1;border-radius:6%}.clr-wrapper[data-v-12df1bec]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-flex:1;-webkit-flex-grow:1;-ms-flex-positive:1;flex-grow:1}.clr-wrapper uni-view[data-v-12df1bec]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;font-size:16px;color:#333;border:1px solid #f1f1f1;border-radius:6%}.my-slider[data-v-12df1bec]{-webkit-box-flex:1;-webkit-flex-grow:1;-ms-flex-positive:1;flex-grow:1}",""])},da0f:function(t,e,i){var a=i("d6d3");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("3f11449e",a,!0,{sourceMap:!1,shadowMode:!1})},dbfc:function(t,e,i){"use strict";var a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("v-uni-image",{staticClass:"my-avatar",style:[t.imgStyle],attrs:{src:t.imgSrc.imgSrc},on:{click:function(e){e=t.$handleEvent(e),t.fSelect(e)}}}),i("v-uni-canvas",{staticClass:"my-canvas",style:{top:t.styleTop,height:t.cvsStyleHeight},attrs:{"canvas-id":"avatar-canvas",id:"avatar-canvas","disable-scroll":"false"}}),i("v-uni-canvas",{staticClass:"oper-canvas",style:{top:t.styleTop,height:t.cvsStyleHeight},attrs:{"canvas-id":"oper-canvas",id:"oper-canvas","disable-scroll":"false"},on:{touchstart:function(e){e=t.$handleEvent(e),t.fStart(e)},touchmove:function(e){e=t.$handleEvent(e),t.fMove(e)},touchend:function(e){e=t.$handleEvent(e),t.fEnd(e)}}}),i("v-uni-canvas",{staticClass:"prv-canvas",style:{height:t.cvsStyleHeight,top:t.prvTop},attrs:{"canvas-id":"prv-canvas",id:"prv-canvas","disable-scroll":"false"},on:{touchstart:function(e){e=t.$handleEvent(e),t.fHideImg(e)}}}),i("v-uni-view",{staticClass:"oper-wrapper",style:{display:t.styleDisplay}},[i("v-uni-view",{staticClass:"oper"},[t.showOper?i("v-uni-view",{staticClass:"btn-wrapper"},[i("v-uni-view",{style:{width:t.btnWidth},attrs:{"hover-class":"hover"},on:{click:function(e){e=t.$handleEvent(e),t.fSelect(e)}}},[i("v-uni-text",[t._v("重选")])],1),i("v-uni-view",{style:{width:t.btnWidth},attrs:{"hover-class":"hover"},on:{click:function(e){e=t.$handleEvent(e),t.fClose(e)}}},[i("v-uni-text",[t._v("关闭")])],1),i("v-uni-view",{style:{width:t.btnWidth,display:t.btnDsp},attrs:{"hover-class":"hover"},on:{click:function(e){e=t.$handleEvent(e),t.fRotate(e)}}},[i("v-uni-text",[t._v("旋转")])],1),i("v-uni-view",{style:{width:t.btnWidth},attrs:{"hover-class":"hover"},on:{click:function(e){e=t.$handleEvent(e),t.fPreview(e)}}},[i("v-uni-text",[t._v("预览")])],1),i("v-uni-view",{style:{width:t.btnWidth},attrs:{"hover-class":"hover"},on:{click:function(e){e=t.$handleEvent(e),t.fUpload(e)}}},[i("v-uni-text",[t._v("上传")])],1)],1):i("v-uni-view",{staticClass:"clr-wrapper"},[i("v-uni-slider",{staticClass:"my-slider",attrs:{"block-size":"25",value:"0",min:"-100",max:"100",activeColor:"red",backgroundColor:"green","block-color":"grey","show-value":""},on:{change:function(e){e=t.$handleEvent(e),t.fColorChange(e)}}}),i("v-uni-view",{style:{width:t.btnWidth},attrs:{"hover-class":"hover"},on:{click:function(e){e=t.$handleEvent(e),t.fPrvUpload(e)}}},[i("v-uni-text",[t._v("上传")])],1)],1)],1)],1)],1)},n=[];i.d(e,"a",function(){return a}),i.d(e,"b",function(){return n})},fca2:function(t,e,i){"use strict";var a=i("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("34ef"),i("4917"),i("6aa2"),i("96cf");var n=a(i("3b8d")),s=a(i("795b")),r=a(i("0a0d")),o=a(i("59ad")),h=a(i("5d73"));i("28a5");var l=a(i("e814")),c=50,d={name:"yq-avatar",data:function(){return{cvsStyleHeight:"0px",styleDisplay:"none",styleTop:"-10000px",prvTop:"-10000px",imgStyle:{},selStyle:{},showOper:!0,imgSrc:{imgSrc:""},btnWidth:"19%",btnDsp:"flex"}},watch:{avatarSrc:function(){this.imgSrc.imgSrc=this.avatarSrc}},props:{avatarSrc:"",avatarStyle:"",selWidth:"",selHeight:"",expWidth:"",expHeight:"",minScale:"",maxScale:"",canScale:"",canRotate:"",lockWidth:"",lockHeight:"",stretch:"",lock:"",noTab:"",inner:"",quality:"",index:""},created:function(){var t=this;this.ctxCanvas=uni.createCanvasContext("avatar-canvas",this),this.ctxCanvasOper=uni.createCanvasContext("oper-canvas",this),this.ctxCanvasPrv=uni.createCanvasContext("prv-canvas",this),this.qlty=(0,l.default)(this.quality)||.9,this.imgSrc.imgSrc=this.avatarSrc,this.letRotate="false"===this.canRotate||"true"===this.inner?0:1,this.letScale="false"===this.canScale?0:1,this.isin="true"===this.inner?1:0,this.indx=this.index||void 0,this.mnScale=this.minScale||.3,this.mxScale=this.maxScale||4,this.noBar="true"===this.noTab?1:0,this.stc=this.stretch,this.lck=this.lock,this.isin?(this.btnWidth="24%",this.btnDsp="none"):(this.btnWidth="19%",this.btnDsp="flex"),this.noBar?(this.moreHeight=0,this.fWindowResize()):uni.showTabBar({complete:function(e){t.moreHeight="showTabBar:ok"===e.errMsg?50:0,t.fWindowResize()}})},methods:{fWindowResize:function(){var t=uni.getSystemInfoSync();this.platform=t.platform,this.pixelRatio=t.pixelRatio,this.windowWidth=t.windowWidth,this.drawTop=t.windowTop,this.windowHeight=t.windowHeight+t.windowBottom,this.cvsStyleHeight=this.windowHeight-c+"px",this.pxRatio=this.windowWidth/750;var e=this.avatarStyle;if(e&&!0!==e&&(e=e.trim())){e=e.split(";");var i={},a=!0,n=!1,s=void 0;try{for(var r,d=(0,h.default)(e);!(a=(r=d.next()).done);a=!0){var f=r.value;if(f){if(f=f.trim().split(":"),f[1].indexOf("upx")>=0){var u=f[1].trim().split(" ");for(var p in u)u[p]&&u[p].indexOf("upx")>=0&&(u[p]=(0,o.default)(u[p])*this.pxRatio+"px");f[1]=u.join(" ")}i[f[0].trim()]=f[1].trim()}}}catch(v){n=!0,s=v}finally{try{a||null==d.return||d.return()}finally{if(n)throw s}}this.imgStyle=i}this.expWidth&&(this.exportWidth=this.expWidth.indexOf("upx")>=0?(0,l.default)(this.expWidth)*this.pxRatio:(0,l.default)(this.expWidth)),this.expHeight&&(this.exportHeight=this.expHeight.indexOf("upx")>=0?(0,l.default)(this.expHeight)*this.pxRatio:(0,l.default)(this.expHeight)),"flex"===this.styleDisplay&&this.fDrawInit(!0),this.fHideImg()},fSelect:function(){var t=this;this.fSelecting||(this.fSelecting=!0,setTimeout(function(){t.fSelecting=!1},500),uni.chooseImage({count:1,sizeType:["original","compressed"],sourceType:["album","camera"],success:function(e){uni.showLoading({mask:!0});var i=t.imgPath=e.tempFilePaths[0];uni.getImageInfo({src:i,success:function(e){if(t.imgWidth=e.width,t.imgHeight=e.height,t.path=i,!t.hasSel){var a=t.selStyle||{};if(!t.selWidth||!t.selHeight)return void uni.showModal({title:"裁剪框的宽或高没有设置",showCancel:!1});var n=t.selWidth.indexOf("upx")>=0?(0,l.default)(t.selWidth)*t.pxRatio:(0,l.default)(t.selWidth),s=t.selHeight.indexOf("upx")>=0?(0,l.default)(t.selHeight)*t.pxRatio:(0,l.default)(t.selHeight);a.width=n+"px",a.height=s+"px",a.top=(t.windowHeight-s-c)/2+"px",a.left=(t.windowWidth-n)/2+"px",t.selStyle=a}t.noBar?t.fDrawInit(!0):uni.hideTabBar({complete:function(){t.fDrawInit(!0)}})},fail:function(){uni.showToast({title:"error3",duration:2e3})},complete:function(){uni.hideLoading()}})}}))},fUpload:function(){var t=this;if(!this.fUploading){this.fUploading=!0,setTimeout(function(){t.fUploading=!1},1e3);var e=this.selStyle,i=(0,l.default)(e.left),a=(0,l.default)(e.top),n=(0,l.default)(e.width),s=(0,l.default)(e.height),r=this.exportWidth||n,o=this.exportHeight||s;i*=this.pixelRatio,a*=this.pixelRatio,r=n,o=s,uni.showLoading({mask:!0}),this.styleDisplay="none",this.styleTop="-10000px",this.hasSel=!1,this.fHideImg(),uni.canvasToTempFilePath({x:i,y:a,width:n,height:s,destWidth:r,destHeight:o,canvasId:"avatar-canvas",fileType:"png",quality:this.qlty,success:function(e){e=e.tempFilePath,t.btop(e).then(function(e){if(t.exportWidth&&t.exportHeight){var i=t.ctxCanvas;r=t.exportWidth,o=t.exportHeight,i.drawImage(e,0,0,r,o),i.draw(!1,function(){uni.canvasToTempFilePath({x:0,y:0,width:r,height:o,destWidth:r,destHeight:o,canvasId:"avatar-canvas",fileType:"png",quality:t.qlty,success:function(e){e=e.tempFilePath,t.btop(e).then(function(e){t.$emit("upload",{avatar:t.imgSrc,path:e,index:t.indx,data:t.rtn})})},fail:function(){uni.showToast({title:"error0",duration:2e3})}})})}else t.$emit("upload",{avatar:t.imgSrc,path:e,index:t.indx,data:t.rtn})})},fail:function(t){uni.showToast({title:"error1",duration:2e3})},complete:function(){uni.hideLoading(),t.noBar||uni.showTabBar()}},this)}},fPrvUpload:function(){var t=this;if(!this.fPrvUploading){this.fPrvUploading=!0,setTimeout(function(){t.fPrvUploading=!1},1e3);var e=this.selStyle,i=((0,l.default)(e.width),(0,l.default)(e.height),this.prvX),a=this.prvY,n=this.prvWidth,s=this.prvHeight,r=this.exportWidth||n,o=this.exportHeight||s;i*=this.pixelRatio,a*=this.pixelRatio,r=n,o=s,uni.showLoading({mask:!0}),this.styleDisplay="none",this.styleTop="-10000px",this.hasSel=!1,this.fHideImg(),uni.canvasToTempFilePath({x:i,y:a,width:n,height:s,destWidth:r,destHeight:o,canvasId:"prv-canvas",fileType:"png",quality:this.qlty,success:function(e){e=e.tempFilePath,t.btop(e).then(function(e){if(t.exportWidth&&t.exportHeight){var i=t.ctxCanvas;r=t.exportWidth,o=t.exportHeight,i.drawImage(e,0,0,r,o),i.draw(!1,function(){uni.canvasToTempFilePath({x:0,y:0,width:r,height:o,destWidth:r,destHeight:o,canvasId:"avatar-canvas",fileType:"png",quality:t.qlty,success:function(e){e=e.tempFilePath,t.btop(e).then(function(e){t.$emit("upload",{avatar:t.imgSrc,path:e,index:t.indx,data:t.rtn})})},fail:function(){uni.showToast({title:"error0",duration:2e3})}})})}else t.$emit("upload",{avatar:t.imgSrc,path:e,index:t.indx,data:t.rtn})})},fail:function(){uni.showToast({title:"error_prv",duration:2e3})},complete:function(){uni.hideLoading(),t.noBar||uni.showTabBar()}},this)}},fDrawInit:function(){var t=this,e=arguments.length>0&&void 0!==arguments[0]&&arguments[0],i=this.windowWidth,a=this.windowHeight,n=this.imgWidth,s=this.imgHeight,r=n/s,o=i-40,h=a-c-80,d=(this.pixelRatio,(0,l.default)(this.selStyle.width)),f=(0,l.default)(this.selStyle.height);switch(this.fixWidth=0,this.fixHeight=0,this.lckWidth=0,this.lckHeight=0,this.stc){case"x":this.fixWidth=1;break;case"y":this.fixHeight=1;break;case"long":r>1?this.fixWidth=1:this.fixHeight=1;break;case"short":r>1?this.fixHeight=1:this.fixWidth=1;break;case"longSel":d>f?this.fixWidth=1:this.fixHeight=1;break;case"shortSel":d>f?this.fixHeight=1:this.fixWidth=1;break}switch(this.lck){case"x":this.lckWidth=1;break;case"y":this.lckHeight=1;break;case"long":r>1?this.lckWidth=1:this.lckHeight=1;break;case"short":r>1?this.lckHeight=1:this.lckWidth=1;break;case"longSel":d>f?this.lckWidth=1:this.lckHeight=1;break;case"shortSel":d>f?this.lckHeight=1:this.lckWidth=1;break}this.fixWidth?(o=d,h=o/r):this.fixHeight?(h=f,o=h*r):r<1?s<h?(o=n,h=s):(h=h,o=h*r):n<o?(o=n,h=s):(o=o,h=o/r),this.isin&&(this.scaleWidth=0,this.scaleHeight=0,o<d&&(o=d,h=o/r,this.lckHeight=0),h<f&&(h=f,o=h*r,this.lckWidth=0)),this.scaleSize=1,this.rotateDeg=0,this.posWidth=(i-o)/2,this.posHeight=(a-h-c)/2,this.useWidth=o,this.useHeight=h;var u=this.selStyle,p=(0,l.default)(u.left),v=(0,l.default)(u.top),x=(0,l.default)(u.width),g=(0,l.default)(u.height),w=(this.canvas,this.canvasOper,this.ctxCanvas),y=this.ctxCanvasOper;y.setLineWidth(3),y.setStrokeStyle("grey"),y.setGlobalAlpha(.4),y.setFillStyle("black"),y.strokeRect(p,v,x,g),y.fillRect(0,0,this.windowWidth,v),y.fillRect(0,v,p,g),y.fillRect(0,v+g,this.windowWidth,this.windowHeight-g-v-c),y.fillRect(p+x,v,this.windowWidth-x-p,g),y.setStrokeStyle("red"),y.moveTo(p+20,v),y.lineTo(p,v),y.lineTo(p,v+20),y.moveTo(p+x-20,v),y.lineTo(p+x,v),y.lineTo(p+x,v+20),y.moveTo(p+20,v+g),y.lineTo(p,v+g),y.lineTo(p,v+g-20),y.moveTo(p+x-20,v+g),y.lineTo(p+x,v+g),y.lineTo(p+x,v+g-20),y.stroke(),y.draw(!1,function(){e&&(t.styleDisplay="flex",t.styleTop=t.drawTop+"px",w.setFillStyle("black"),t.fDrawImage())}),this.$emit("avtinit")},fDrawImage:function(){var t=(0,r.default)();if(!(t-this.drawTm<20)){this.drawTm=t;var e=this.ctxCanvas;e.fillRect(0,0,this.windowWidth,this.windowHeight-c),e.translate(this.posWidth+this.useWidth/2,this.posHeight+this.useHeight/2),e.scale(this.scaleSize,this.scaleSize),e.rotate(this.rotateDeg*Math.PI/180),e.drawImage(this.imgPath,-this.useWidth/2,-this.useHeight/2,this.useWidth,this.useHeight),e.draw(!1)}},fHideImg:function(){this.prvImg="",this.prvTop="-10000px",this.showOper=!0,this.prvImgData=null,this.target=null},fClose:function(){this.styleDisplay="none",this.styleTop="-10000px",this.hasSel=!1,this.fHideImg(),this.noBar||uni.showTabBar()},fPreview:function(){var t=this;if(!this.fPreviewing){this.fPreviewing=!0,setTimeout(function(){t.fPreviewing=!1},1e3);var e=this.selStyle,i=(0,l.default)(e.left),a=(0,l.default)(e.top),n=(0,l.default)(e.width),s=(0,l.default)(e.height);i*=this.pixelRatio,a*=this.pixelRatio,uni.showLoading({mask:!0}),uni.canvasToTempFilePath({x:i,y:a,width:n,height:s,canvasId:"avatar-canvas",fileType:"png",quality:this.qlty,success:function(e){t.prvImgTmp=e=e.tempFilePath;var i=t.ctxCanvasPrv,a=t.windowWidth,n=(0,l.default)(t.cvsStyleHeight),s=(0,l.default)(t.selStyle.width),r=(0,l.default)(t.selStyle.height),o=a-40,h=n-80,c=o/s,d=r*c;d<h?(s=o,r=d):(c=h/r,s*=c,r=h),i.setFillStyle("black"),i.fillRect(0,0,a,n),t.prvX=a=(a-s)/2,t.prvY=n=(n-r)/2,t.prvWidth=s,t.prvHeight=r,i.drawImage(e,a,n,s,r),i.draw(!1),t.btop(e).then(function(e){t.showOper=!1,t.prvTop=t.drawTop+"px"})},fail:function(){uni.showToast({title:"error2",duration:2e3})},complete:function(){uni.hideLoading()}},this)}},fChooseImg:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:void 0,e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:void 0,i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:void 0;if(e){var a=e.selWidth,n=e.selHeight,s=e.expWidth,r=e.expHeight,o=e.quality,h=e.canRotate,d=e.canScale,f=e.minScale,u=e.maxScale,p=e.stretch,v=e.inner,x=e.lock;s&&(this.exportWidth=s.indexOf("upx")>=0?(0,l.default)(s)*this.pxRatio:(0,l.default)(s)),r&&(this.exportHeight=r.indexOf("upx")>=0?(0,l.default)(r)*this.pxRatio:(0,l.default)(r)),this.letRotate="false"===h?0:1,this.letScale="false"===d?0:1,this.qlty=(0,l.default)(o)||.9,this.mnScale=f||.3,this.mxScale=u||4,this.stc=p,this.isin="true"===v?1:0,this.lck=x,this.isin?(this.btnWidth="24%",this.btnDsp="none"):(this.btnWidth="19%",this.btnDsp="flex"),a&&n&&(a=a.indexOf("upx")>=0?(0,l.default)(a)*this.pxRatio:(0,l.default)(a),n=n.indexOf("upx")>=0?(0,l.default)(n)*this.pxRatio:(0,l.default)(n),this.selStyle.width=a+"px",this.selStyle.height=n+"px",this.selStyle.top=(this.windowHeight-n-c)/2+"px",this.selStyle.left=(this.windowWidth-a)/2+"px",this.hasSel=!0)}this.rtn=i,this.indx=t,this.fSelect()},fRotate:function(){this.rotateDeg+=90-this.rotateDeg%90,this.fDrawImage()},fStart:function(t){var e=t.touches,i=e[0],a=e[1];if(this.touch0=i,this.touch1=a,a){var n=a.x-i.x,s=a.y-i.y;this.fgDistance=Math.sqrt(n*n+s*s)}},fMove:function(t){var e=t.touches,i=e[0],a=e[1];if(a){var n=a.x-i.x,s=a.y-i.y,r=Math.sqrt(n*n+s*s),o=.005*(r-this.fgDistance),h=this.scaleSize+o;do{if(!this.letScale)break;if(h<this.mnScale)break;if(h>this.mxScale)break;if(this.isin){var c=this.useWidth*h,d=this.useHeight*h,f=this.posWidth+this.useWidth/2,u=this.posHeight+this.useHeight/2,p=f-c/2,v=u-d/2,x=p+c,g=v+d,w=(0,l.default)(this.selStyle.left),y=(0,l.default)(this.selStyle.top),b=(0,l.default)(this.selStyle.width),m=(0,l.default)(this.selStyle.height);if(w<p||w+b>x||y<v||y+m>g)break;this.scaleWidth=(this.useWidth-c)/2,this.scaleHeight=(this.useHeight-d)/2}this.scaleSize=h}while(0);this.fgDistance=r,a.x!==i.x&&this.letRotate&&(n=(this.touch1.y-this.touch0.y)/(this.touch1.x-this.touch0.x),s=(a.y-i.y)/(a.x-i.x),this.rotateDeg+=180*Math.atan((s-n)/(1+n*s))/Math.PI,this.touch0=i,this.touch1=a),this.fDrawImage()}else if(this.touch0){var k=i.x-this.touch0.x,S=i.y-this.touch0.y,W=this.posWidth+k,H=this.posHeight+S;if(this.isin){var T=this.useWidth*this.scaleSize,R=this.useHeight*this.scaleSize,I=W+this.useWidth/2,L=H+this.useHeight/2,P=I-T/2,C=L-R/2,D=P+T,E=C+R,O=(0,l.default)(this.selStyle.left),_=(0,l.default)(this.selStyle.top),j=(0,l.default)(this.selStyle.width),z=(0,l.default)(this.selStyle.height);!this.lckWidth&&Math.abs(k)<100&&(O>=P&&O+j<=D?this.posWidth=W:O<P?this.posWidth=O-this.scaleWidth:O+j>D&&(this.posWidth=O-(T-j)-this.scaleWidth)),!this.lckHeight&&Math.abs(S)<100&&(_>=C&&_+z<=E?this.posHeight=H:_<C?this.posHeight=_-this.scaleHeight:_+z>E&&(this.posHeight=_-(R-z)-this.scaleHeight))}else Math.abs(k)<100&&!this.lckWidth&&(this.posWidth=W),Math.abs(S)<100&&!this.lckHeight&&(this.posHeight=H);this.touch0=i,this.fDrawImage()}},fEnd:function(t){var e=t.touches,i=e&&e[0];e&&e[1];i?this.touch0=i:(this.touch0=null,this.touch1=null)},fGetImgData:function(){var t=this;return new s.default(function(e,i){var a=t.prvX,n=t.prvY,s=t.prvWidth,r=t.prvHeight;a*=t.pixelRatio,n*=t.pixelRatio,s*=t.pixelRatio,r*=t.pixelRatio,uni.canvasGetImageData({canvasId:"prv-canvas",x:a,y:n,width:s,height:r,success:function(t){e(t.data)},fail:function(t){i(t)}},t)})},fColorChange:function(){var t=(0,n.default)(regeneratorRuntime.mark(function t(e){var i,a,n,s,o,h,l,c,d,f,u,p,v,x,g,w,y,b,m,k,S,W,H,T,R,I,L;return regeneratorRuntime.wrap(function(t){while(1)switch(t.prev=t.next){case 0:if(i=(0,r.default)(),!(i-this.prvTm<100)){t.next=3;break}return t.abrupt("return");case 3:if(this.prvTm=i,uni.showLoading({mask:!0}),this.prvImgData){t.next=11;break}return t.next=8,this.fGetImgData().catch(function(t){uni.showToast({title:"error_read",duration:2e3})});case 8:if(this.prvImgData=t.sent){t.next=10;break}return t.abrupt("return");case 10:this.target=new Uint8ClampedArray(this.prvImgData.length);case 11:if(a=this.prvImgData,n=this.target,s=e.detail.value,0===s)n=a;else for(s=(s+100)/200,s<.005&&(s=0),s>.995&&(s=1),S=a.length-1;S>=0;S-=4)o=a[S-3]/255,h=a[S-2]/255,l=a[S-1]/255,w=Math.max(o,h,l),g=Math.min(o,h,l),p=w-g,w===g?d=0:w===o&&h>=l?d=(h-l)/p*60:w===o&&h<l?d=(h-l)/p*60+360:w===h?d=(l-o)/p*60+120:w===l&&(d=(o-h)/p*60+240),u=(w+g)/2,0===u||w===g?f=0:0<u&&u<=.5?f=p/(2*u):u>.5&&(f=p/(2-2*u)),a[S]&&(c=a[S]),s<.5?f=f*s/.5:s>.5&&(f=2*f+2*s-f*s/.5-1),0===f?o=h=l=Math.round(255*u):(u<.5?x=u*(1+f):u>=.5&&(x=u+f-u*f),v=2*u-x,y=d/360,b=y+1/3,m=y,k=y-1/3,W=function(t){return t<0?t+1:t>1?t-1:t},H=function(t){return t<1/6?v+6*(x-v)*t:t>=1/6&&t<.5?x:t>=.5&&t<2/3?v+6*(x-v)*(2/3-t):v},o=b=Math.round(255*H(W(b))),h=m=Math.round(255*H(W(m))),l=k=Math.round(255*H(W(k)))),c&&(n[S]=c),n[S-3]=o,n[S-2]=h,n[S-1]=l;T=this.prvX,R=this.prvY,I=this.prvWidth,L=this.prvHeight,this.ctxCanvasPrv.setFillStyle("black"),this.ctxCanvasPrv.fillRect(T,R,I,L),this.ctxCanvasPrv.draw(!0),T*=this.pixelRatio,R*=this.pixelRatio,I*=this.pixelRatio,L*=this.pixelRatio,uni.canvasPutImageData({canvasId:"prv-canvas",x:T,y:R,width:I,height:L,data:n,fail:function(){uni.showToast({title:"error_put",duration:2e3})},complete:function(){uni.hideLoading()}},this);case 22:case"end":return t.stop()}},t,this)}));function e(e){return t.apply(this,arguments)}return e}(),btop:function(t){return new s.default(function(e,i){var a=t.split(","),n=a[0].match(/:(.*?);/)[1],s=atob(a[1]),r=s.length,o=new Uint8Array(r);while(r--)o[r]=s.charCodeAt(r);return e((window.URL||window.webkitURL).createObjectURL(new Blob([o],{type:n})))})}}};e.default=d}}]);
(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-c0734d00"],{"0434":function(t,a,e){},"37d6":function(t,a,e){},"3e4a":function(t,a,e){"use strict";var n=e("8d5d"),i=e.n(n);i.a},"55f1":function(t,a,e){"use strict";var n=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("van-tabbar",{style:"background-color:"+t.gcfg.BackgroundColor,model:{value:t.active,callback:function(a){t.active=a},expression:"active"}},[e("van-tabbar-item",{attrs:{icon:"shop",to:"/"}},[t._v("首页")]),e("van-tabbar-item",{attrs:{icon:"bars",to:"PageList"}},[t._v("搜索")]),e("van-tabbar-item",{attrs:{icon:"cart",to:"CartIndex"}},[t._v("购物车")]),e("van-tabbar-item",{attrs:{icon:"manager",to:"My"}},[t._v("我的")])],1)],1)},i=[],o=(e("c290"),{props:["curactive"],data:function(){return{active:this.curactive,gcfg:[]}},methods:{},created:function(){this.gcfg=this.$store.getters.getGcfg},watch:{"$store.state.gcfg":function(){this.gcfg=this.$store.getters.getGcfg}}}),s=o,r=(e("3e4a"),e("2877")),c=Object(r["a"])(s,n,i,!1,null,null,null);a["a"]=c.exports},"67a8":function(t,a,e){"use strict";var n=e("7961"),i=e.n(n);i.a},7961:function(t,a,e){},"7f12":function(t,a,e){"use strict";var n=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("footer",[t._v("─── Copyright 2016-2028 ® By.Hawk86104 ───")])},i=[],o=(e("d466"),e("2877")),s={},r=Object(o["a"])(s,n,i,!1,null,null,null);a["a"]=r.exports},"8d5d":function(t,a,e){},c153:function(t,a,e){"use strict";var n=e("37d6"),i=e.n(n);i.a},c612:function(t,a,e){"use strict";e.r(a);var n=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("div",{staticClass:"header"},[e("div",{staticStyle:{"text-align":"center","font-size":"0.8em",color:"white","padding-top":"1em","margin-bottom":"1.8em"}},[t._v("\n\t       个人中心\n\t    ")]),e("div",{staticClass:"avatar"},[e("img",{staticStyle:{width:"100%"},attrs:{src:t.user.avatar}})]),e("div",{staticClass:"account"},[null==t.third?e("van-button",{staticStyle:{"margin-bottom":"1em"},attrs:{plain:"",type:"primary",size:"small"},on:{click:t.binding_wx}},[t._v("绑定微信")]):e("div",{staticClass:"showname"},[t._v("\n\t          "+t._s(t.user.nickname)+"\n\t      ")])],1)]),e("van-cell-group",{staticClass:"buttons_froup"},[e("van-cell",{attrs:{title:"收货地址管理",icon:"location",to:"AdressList","is-link":""}}),e("van-cell",{attrs:{title:"全部订单",icon:"records",to:"./my/myorder?showType=0","is-link":""}}),e("van-cell",{attrs:{icon:"after-sale",to:"./my/myorder?showType=1","is-link":""}},[e("div",{attrs:{slot:"title"},slot:"title"},[e("span",[t._v("待付款订单")]),0!=t.datanum.NoPayNum?e("van-tag",{staticClass:"tag-c-c",attrs:{color:"#6d189e"}},[t._v(t._s(t.datanum.NoPayNum))]):t._e()],1)]),e("van-cell",{attrs:{icon:"free-postage",to:"./my/myorder?showType=2","is-link":""}},[e("div",{attrs:{slot:"title"},slot:"title"},[e("span",[t._v("待发货订单")]),0!=t.datanum.NoFreightNum?e("van-tag",{staticClass:"tag-c-c",attrs:{color:"#6d189e"}},[t._v(t._s(t.datanum.NoFreightNum))]):t._e()],1)]),e("van-cell",{attrs:{icon:"completed",to:"./my/myorder?showType=3","is-link":""}},[e("div",{attrs:{slot:"title"},slot:"title"},[e("span",[t._v("待收货订单")]),0!=t.datanum.NoReceiptNum?e("van-tag",{staticClass:"tag-c-c",attrs:{color:"#6d189e"}},[t._v(t._s(t.datanum.NoReceiptNum))]):t._e()],1)])],1),e("Copyright",{staticStyle:{"margin-top":"4em"}}),e("BottomTabbar",{attrs:{curactive:3}}),e("cube-view")],1)},i=[],o=(e("cadf"),e("551c"),e("f751"),e("097d"),e("ce11")),s=e("c290"),r=e("55f1"),c=e("7f12"),l={data:function(){return{id:this.$route.query.id,NewsData:[],user:[],third:null,datanum:[]}},components:{CubeView:o["a"],BottomTabbar:r["a"],Copyright:c["a"]},methods:{axios_Request:function(){var t="/addons/litestore/api.uservue/index",a=this;s["a"](t,{},function(t){console.log(t),a.user=t["data"]["user"],a.third=t["data"]["third"]})},binding_wx:function(){var t="http://"+window.location.host+"/addons/litestore/api.uservue/connect?platform=wechat&url=http://"+window.location.host+"/addons/litestore/octothorpe/My";window.location.href=t}},created:function(){this.axios_Request()},mounted:function(){var t="/addons/litestore/api.order/Get_order_num",a=this;s["a"](t,{},function(t){console.log(t),a.datanum=t["data"]})}},u=l,d=(e("67a8"),e("2877")),v=Object(d["a"])(u,n,i,!1,null,null,null);a["default"]=v.exports},ce11:function(t,a,e){"use strict";var n=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("transition",{attrs:{name:"page-move"}},[e("router-view",{staticClass:"cube-view"})],1)},i=[],o={methods:{}},s=o,r=(e("c153"),e("2877")),c=Object(r["a"])(s,n,i,!1,null,null,null);a["a"]=c.exports},d466:function(t,a,e){"use strict";var n=e("0434"),i=e.n(n);i.a}}]);
//# sourceMappingURL=chunk-c0734d00.c276a583.js.map
(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-58a8"],{"X/Oz":function(t,e,r){"use strict";r.r(e);var n=r("QbLZ"),o=r.n(n),a=r("P2sY"),s=r.n(a),i=r("L2JU"),u=r("tG6t"),l={question:"",answer:""},c={name:"CreateFaq",components:{},data:function(){var t=this,e=function(e,r,n){""===r?(t.$message({message:e.field.charAt(0).toUpperCase()+e.field.slice(1)+" is required",type:"error"}),n(new Error(e.field.charAt(0).toUpperCase()+e.field.slice(1)+" is required"))):n()};return{postForm:s()({},l),roles:null,loading:!1,rules:{question:[{validator:e}],answer:[{validator:e}]},tempRoute:{}}},computed:o()({},Object(i.b)(["userid","name","avatar","usertype","role","apiurl","token"])),watch:{$route:function(t,e){"CreateFaq"===t.name&&this.getRoleList()}},created:function(){this.getRoleList()},methods:{getRoleList:function(){},submitForm:function(){var t=this;this.$refs.postForm.validate(function(e){if(!e)return console.log("error submit!!"),!1;t.loading=!0,Object(u.c)(t.postForm).then(function(e){t.$message({title:"success",message:e.data.message,type:"success",duration:3e3}),t.loading=!1,t.$router.replace({path:"/faqs/index"})}).catch(function(e){t.loading=!1,console.log(e,"error")})})}}},d=(r("xn8q"),r("KHd+")),p=Object(d.a)(c,function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"createPost-container"},[r("el-form",{ref:"postForm",staticClass:"form-container",attrs:{model:t.postForm,rules:t.rules}},[r("div",{staticClass:"createPost-main-container"},[r("el-row",[r("el-col",{attrs:{span:24}},[r("el-form-item",{attrs:{prop:"question"}},[r("el-input",{attrs:{name:"question",placeholder:t.$t("faq.question"),required:""},model:{value:t.postForm.question,callback:function(e){t.$set(t.postForm,"question",e)},expression:"postForm.question"}})],1)],1),t._v(" "),r("el-col",{attrs:{span:24}},[r("el-form-item",{attrs:{prop:"answer"}},[r("el-input",{attrs:{type:"textarea",name:"answer",placeholder:t.$t("faq.answer"),required:""},model:{value:t.postForm.answer,callback:function(e){t.$set(t.postForm,"answer",e)},expression:"postForm.answer"}})],1)],1),t._v(" "),r("el-col",{attrs:{span:24}},[r("el-form-item",{attrs:{prop:"product_filter"}},[r("label",{staticStyle:{"padding-bottom":"5px"}},[t._v('\n              Dopo ogni id tour inserisci il ";".  Se è riferito a tutti i tour lascia il campo vuoto\n            ')]),t._v(" "),r("el-input",{attrs:{type:"text",name:"product_filter",placeholder:"Filtro tour"},model:{value:t.postForm.product_filter,callback:function(e){t.$set(t.postForm,"product_filter",e)},expression:"postForm.product_filter"}})],1)],1)],1)],1),t._v(" "),r("div",{staticClass:"btns"},[r("router-link",{attrs:{to:"/faqs/index"}},[r("el-button",{staticClass:"el-button el-button--danger el-button--medium",staticStyle:{padding:"10px"},attrs:{type:"primary",size:"small"}},[t._v(t._s(t.$t("table.cancel")))])],1),t._v(" "),r("el-button",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"el-button el-button--primary el-button--medium",on:{click:t.submitForm}},[t._v("\n        "+t._s(t.$t("user.add"))+"\n      ")])],1)])],1)},[],!1,null,"5f4b5f9d",null);p.options.__file="create.vue";e.default=p.exports},ZRf5:function(t,e,r){},tG6t:function(t,e,r){"use strict";r.d(e,"i",function(){return o}),r.d(e,"f",function(){return a}),r.d(e,"c",function(){return s}),r.d(e,"j",function(){return i}),r.d(e,"b",function(){return u}),r.d(e,"d",function(){return l}),r.d(e,"h",function(){return c}),r.d(e,"a",function(){return d}),r.d(e,"g",function(){return p}),r.d(e,"e",function(){return f});var n=r("t3Un");function o(t){return Object(n.a)({url:"/web/faqs",method:"get",params:t})}function a(t,e){return Object(n.a)({url:"/faqs/"+t,method:"put",data:e})}function s(t){return Object(n.a)({url:"/faqs",method:"post",data:t})}function i(t){return Object(n.a)({url:"/user/verify/email",method:"post",data:t})}function u(t){return Object(n.a)({url:"/user/signup/complete",method:"post",data:t})}function l(t){return Object(n.a)({url:"/faqs/"+t,method:"delete"})}function c(t){return Object(n.a)({url:"/faqs/"+t,method:"get"})}function d(t){return Object(n.a)({url:"/aboutus",method:"post",data:t})}function p(){return Object(n.a)({url:"/aboutus",method:"get"})}function f(t,e){return Object(n.a)({url:"/aboutus/"+t,method:"put",data:e})}},xn8q:function(t,e,r){"use strict";var n=r("ZRf5");r.n(n).a}}]);
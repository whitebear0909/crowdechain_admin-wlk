(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-6e38"],{"44Km":function(t,e,n){"use strict";n.r(e);var o=n("tG6t"),r={name:"Signup",components:{},data:function(){return{loginForm:{workstation:""},loginRules:{workstation:[{required:!0,message:"Workstation name is required",trigger:"blur"}]},loading:!1,token:"",userid:""}},computed:{},watch:{$route:"getData"},created:function(){this.getData()},methods:{getData:function(){this.token=this.$route.query.token,this.userid=this.$route.query.id},handleLogin:function(){var t=this;this.$refs.loginForm.validate(function(e){if(!(e&&t.token&&t.userid))return console.log("error submit!!"),!1;t.loading=!0;var n={workstation_name:t.loginForm.workstation,token:t.token,userid:t.userid};Object(o.b)(n).then(function(e){t.$message({title:"success",message:e.data.message,type:"success",duration:4e3}),t.loading=!1,t.$router.replace({path:"/login"})}).catch(function(e){t.loading=!1,t.$message({title:"Error",message:e.data.message,type:"error",duration:4e3})})})}}},i=(n("54Yy"),n("KHd+")),a=Object(i.a)(r,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"logincontainer"},[n("el-form",{ref:"loginForm",staticClass:"login-form",attrs:{model:t.loginForm,rules:t.loginRules,"auto-complete":"on","label-position":"left"}},[n("div",{staticClass:"title-container"},[n("h2",{staticClass:"title"},[t._v("Welcome to complete Signup!!")])]),t._v(" "),n("el-form-item",{attrs:{prop:"workstation"}},[n("el-input",{ref:"workstation",attrs:{placeholder:"Enter your workstation name",name:"workstation",type:"text","auto-complete":"on"},model:{value:t.loginForm.workstation,callback:function(e){t.$set(t.loginForm,"workstation",e)},expression:"loginForm.workstation"}})],1),t._v(" "),n("el-form-item",{staticClass:"textcenter"},[n("el-button",{staticStyle:{width:"150px","margin-bottom":"30px"},attrs:{loading:t.loading,type:"primary"},nativeOn:{click:function(e){return e.preventDefault(),t.handleLogin(e)}}},[t._v("\n        Submit\n      ")])],1)],1)],1)},[],!1,null,"1127bd47",null);a.options.__file="index.vue";e.default=a.exports},"54Yy":function(t,e,n){"use strict";var o=n("OdR6");n.n(o).a},OdR6:function(t,e,n){},tG6t:function(t,e,n){"use strict";n.d(e,"i",function(){return r}),n.d(e,"f",function(){return i}),n.d(e,"c",function(){return a}),n.d(e,"j",function(){return u}),n.d(e,"b",function(){return s}),n.d(e,"d",function(){return c}),n.d(e,"h",function(){return l}),n.d(e,"a",function(){return d}),n.d(e,"g",function(){return m}),n.d(e,"e",function(){return f});var o=n("t3Un");function r(t){return Object(o.a)({url:"/web/faqs",method:"get",params:t})}function i(t,e){return Object(o.a)({url:"/faqs/"+t,method:"put",data:e})}function a(t){return Object(o.a)({url:"/faqs",method:"post",data:t})}function u(t){return Object(o.a)({url:"/user/verify/email",method:"post",data:t})}function s(t){return Object(o.a)({url:"/user/signup/complete",method:"post",data:t})}function c(t){return Object(o.a)({url:"/faqs/"+t,method:"delete"})}function l(t){return Object(o.a)({url:"/faqs/"+t,method:"get"})}function d(t){return Object(o.a)({url:"/aboutus",method:"post",data:t})}function m(){return Object(o.a)({url:"/aboutus",method:"get"})}function f(t,e){return Object(o.a)({url:"/aboutus/"+t,method:"put",data:e})}}}]);
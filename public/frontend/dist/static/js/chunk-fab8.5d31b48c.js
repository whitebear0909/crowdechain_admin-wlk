(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-fab8"],{Tu6z:function(t,e,n){"use strict";var a=n("frzL");n.n(a).a},bqSz:function(t,e,n){"use strict";n.d(e,"d",function(){return l}),n.d(e,"a",function(){return r}),n.d(e,"e",function(){return i}),n.d(e,"b",function(){return o}),n.d(e,"c",function(){return s});var a=n("t3Un");function l(t){return Object(a.a)({url:"/halloffames",method:"get",params:t})}function r(t){return Object(a.a)({url:"/halloffame",method:"post",data:t})}function i(t){return Object(a.a)({url:"/halloffame",method:"put",data:t})}function o(t){return Object(a.a)({url:"/halloffame/"+t,method:"delete"})}function s(t){return Object(a.a)({url:"/halloffame/"+t,method:"get"})}},"e/Oi":function(t,e,n){"use strict";n.r(e);var a=n("bqSz"),l={name:"HallofameList",components:{},filters:{statusFilter:function(t){return"success"}},data:function(){return{list:null,total:0,listLoading:!0,listQuery:{page:1,limit:20}}},watch:{$route:function(t,e){"HallofameList"===t.name&&this.getList()}},created:function(){this.getList()},mounted:function(){},methods:{getList:function(){var t=this;this.listLoading=!0,Object(a.d)(this.listQuery).then(function(e){t.list=e.data.data,t.total=e.data.total,t.listLoading=!1})},removeHalloffame:function(t){var e=this;this.$confirm("This will permanently delete this record. Continue?","Warning",{confirmButtonText:"OK",cancelButtonText:"Cancel",type:"warning"}).then(function(){Object(a.b)(t).then(function(t){e.$message({title:"success",message:t.data.message,type:"success",duration:4e3}),e.getList()}).catch(function(t){e.$message({title:"error",message:t.message,type:"error",duration:4e3})})}).catch(function(){})}}},r=(n("Tu6z"),n("KHd+")),i=Object(r.a)(l,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"app-container tablehover"},[n("router-link",{staticClass:"createbtn",attrs:{to:"/halloffame/add"}},[n("el-button",{attrs:{type:"primary",size:"small",icon:"el-icon-plus"}},[t._v("Create")])],1),t._v(" "),n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],staticClass:"tablelayout",attrs:{data:t.list,border:"",fit:"","highlight-current-row":"",width:"100%"}},[n("el-table-column",{attrs:{align:"center",label:"Id"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.id))])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"Order in home page"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.home_order))])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"Title"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.title))])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"Author"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.author))])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"Image"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[e.row.fullimgurl?n("img",{staticClass:"avatar",attrs:{src:e.row.fullimgurl,width:"50px"}}):t._e()])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"Actions"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("router-link",{staticClass:"actionhoverbtn",attrs:{to:"/halloffame/edit/"+e.row.id}},[n("el-button",{attrs:{type:"primary",size:"small",icon:"el-icon-edit"}})],1),t._v(" "),n("el-button",{staticClass:"actionhoverbtn",attrs:{type:"primary",size:"small",icon:"el-icon-delete"},on:{click:function(n){t.removeHalloffame(e.row.id)}}})]}}])})],1)],1)},[],!1,null,"b1b9cbc2",null);i.options.__file="index.vue";e.default=i.exports},frzL:function(t,e,n){}}]);
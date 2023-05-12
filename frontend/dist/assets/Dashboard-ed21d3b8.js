import{A as x}from"./AssignmentTile-cbb54f60.js";import{a as b}from"./apiService-46e5fd51.js";import{_ as $,r as s,o as i,c as d,a as e,w as n,b as r,t as l,d as o,F as j,e as w,f as N,g as A}from"./index-38e85aaa.js";import"https://unpkg.com/mathlive@0.90.10/dist/mathlive.min.js";import"https://unpkg.com/mathlive@0.90.10/dist/vue-mathlive.mjs";const B={name:"ActiveAssignmentsTab",components:{AssignmentTile:x},props:{variant:{type:String,required:!0},title:{required:!0}},data(){return{assignments:[]}},methods:{async getAssignments(){this.variant==="active"?b.get("/api/assigments/active").then(t=>{this.assignments=t.data}):this.variant==="done"?b.get("api/assigments/done").then(t=>{this.assignments=t.data}):b.get("/api/assigments/pastdue").then(t=>{this.assignments=t.data})}},mounted(){this.getAssignments()}},C={class:"py-4"},D={class:"d-flex flex-wrap h-limit-max-height"},S={key:0,class:"d-flex justify-center py-8 w-100"},V={class:"d-flex justify-center mb-2 hk-big-icon-2 py-4"},q=r("mdi-robot-happy-outline"),F={class:"d-flex justify-center"};function z(t,k,v,T,u,c){const _=s("v-card-title"),a=s("v-divider"),h=s("AssignmentTile"),p=s("v-icon"),m=s("v-card-subtitle"),g=s("v-card");return i(),d("div",C,[e(g,null,{default:n(()=>[e(_,null,{default:n(()=>[r(l(v.title),1)]),_:1}),e(a),o("div",D,[(i(!0),d(j,null,w(u.assignments,(f,y)=>(i(),A(h,{key:y,data:f,variant:v.variant},null,8,["data","variant"]))),128)),u.assignments.length?N("",!0):(i(),d("div",S,[o("div",null,[o("div",V,[e(p,{size:"large",color:"grey-lighten-1"},{default:n(()=>[q]),_:1})]),o("div",F,[e(m,null,{default:n(()=>[r(l(t.$t("titles.noData")),1)]),_:1})])])]))])]),_:1})])}const E=$(B,[["render",z]]),L={name:"Dashboard",components:{AssignmentsTab:E},computed:{store(){return this.$store.state}}},G={class:"pt-6 px-0 d-flex justify-center"},H={class:"v-col-12 px-0"},I={class:"d-flex justify-end"},J={class:"pt-6"},K={key:0},M={key:1},O={class:"text-right"},P=r("mdi-plus-thick"),Q={key:2},R={class:"pa-4"};function U(t,k,v,T,u,c){const _=s("v-card-title"),a=s("AssignmentsTab"),h=s("v-icon"),p=s("v-chip"),m=s("router-link"),g=s("v-btn"),f=s("v-card");return i(),d("div",G,[o("div",H,[o("div",I,[e(_,{class:"px-0 text-h4"},{default:n(()=>[r(l(t.$t("dashboard.greetingTitle")),1)]),_:1})]),o("div",J,[c.store.role==="student"?(i(),d("div",K,[e(a,{title:t.$t("dashboard.activeAssignment"),active:!0,variant:"active"},null,8,["title"]),e(a,{title:t.$t("dashboard.doneAssignment"),active:!1,variant:"done"},null,8,["title"]),e(a,{title:t.$t("dashboard.historyAssignment"),active:!1,variant:"pastdue"},null,8,["title"])])):c.store.role==="teacher"||c.store.role==="admin"?(i(),d("div",M,[o("div",O,[e(m,{to:"/create-assignment"},{default:n(()=>[e(p,{outlined:"",round:"",color:"primary",onClick:y=>({}),class:"mr-3"},{default:n(()=>[e(h,{small:"",class:"mr-2"},{default:n(()=>[P]),_:1}),r(" "+l(t.$t("button.createNewAssignment")),1)]),_:1})]),_:1})]),e(a,{title:t.$t("dashboard.activeAssignment"),variant:"active"},null,8,["title"]),e(a,{title:t.$t("dashboard.historyAssignment"),variant:"pastdue"},null,8,["title"])])):c.store.role==="admin"?(i(),d("div",Q,[e(a,{title:t.$t("dashboard.activeAssignment"),variant:"active"},null,8,["title"]),e(a,{title:t.$t("dashboard.historyAssignment"),variant:"pastdue"},null,8,["title"])])):(i(),A(f,{key:3},{default:n(()=>[e(_,null,{default:n(()=>[r(l(t.$t("dashboard.expiredSession")),1)]),_:1}),o("div",R,[e(m,{to:"/login"},{default:n(()=>[e(g,{color:"primary"},{default:n(()=>[r(l(t.$t("login.title")),1)]),_:1})]),_:1})])]),_:1}))])])])}const et=$(L,[["render",U]]);export{et as default};

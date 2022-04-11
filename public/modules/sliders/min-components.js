(self.webpackChunk=self.webpackChunk||[]).push([['sliders'],{'sliders_component':(e,t,n)=>{Vue.component("image-slider",n(7670).Z)},4395:(e,t,n)=>{"use strict";n.d(t,{Z:()=>o});var i=n(3645),r=n.n(i)()((function(e){return e[1]}));r.push([e.id,".image-slider img{--webkit-border-radius:8px;border-radius:8px;height:100%;width:100%}.mobile-theme .mdi-circle:before{font-size:10px!important}.mobile-theme .v-btn--icon.v-size--small{height:18px;margin:0;padding:0;width:18px}.mobile-theme .v-window__next,.mobile-theme .v-window__prev{display:none;left:0!important}.v-skeleton-loader__image{height:100%}",""]);const o=r},3645:e=>{"use strict";e.exports=function(e){var t=[];return t.toString=function(){return this.map((function(t){var n=e(t);return t[2]?"@media ".concat(t[2]," {").concat(n,"}"):n})).join("")},t.i=function(e,n,i){"string"==typeof e&&(e=[[null,e,""]]);var r={};if(i)for(var o=0;o<this.length;o++){var s=this[o][0];null!=s&&(r[s]=!0)}for(var a=0;a<e.length;a++){var l=[].concat(e[a]);i&&r[l[0]]||(n&&(l[2]?l[2]="".concat(n," and ").concat(l[2]):l[2]=n),t.push(l))}},t}},3379:(e,t,n)=>{"use strict";var i,r=function(){return void 0===i&&(i=Boolean(window&&document&&document.all&&!window.atob)),i},o=function(){var e={};return function(t){if(void 0===e[t]){var n=document.querySelector(t);if(window.HTMLIFrameElement&&n instanceof window.HTMLIFrameElement)try{n=n.contentDocument.head}catch(e){n=null}e[t]=n}return e[t]}}(),s=[];function a(e){for(var t=-1,n=0;n<s.length;n++)if(s[n].identifier===e){t=n;break}return t}function l(e,t){for(var n={},i=[],r=0;r<e.length;r++){var o=e[r],l=t.base?o[0]+t.base:o[0],c=n[l]||0,d="".concat(l," ").concat(c);n[l]=c+1;var u=a(d),f={css:o[1],media:o[2],sourceMap:o[3]};-1!==u?(s[u].references++,s[u].updater(f)):s.push({identifier:d,updater:v(f,t),references:1}),i.push(d)}return i}function c(e){var t=document.createElement("style"),i=e.attributes||{};if(void 0===i.nonce){var r=n.nc;r&&(i.nonce=r)}if(Object.keys(i).forEach((function(e){t.setAttribute(e,i[e])})),"function"==typeof e.insert)e.insert(t);else{var s=o(e.insert||"head");if(!s)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");s.appendChild(t)}return t}var d,u=(d=[],function(e,t){return d[e]=t,d.filter(Boolean).join("\n")});function f(e,t,n,i){var r=n?"":i.media?"@media ".concat(i.media," {").concat(i.css,"}"):i.css;if(e.styleSheet)e.styleSheet.cssText=u(t,r);else{var o=document.createTextNode(r),s=e.childNodes;s[t]&&e.removeChild(s[t]),s.length?e.insertBefore(o,s[t]):e.appendChild(o)}}function h(e,t,n){var i=n.css,r=n.media,o=n.sourceMap;if(r?e.setAttribute("media",r):e.removeAttribute("media"),o&&"undefined"!=typeof btoa&&(i+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(o))))," */")),e.styleSheet)e.styleSheet.cssText=i;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(i))}}var m=null,p=0;function v(e,t){var n,i,r;if(t.singleton){var o=p++;n=m||(m=c(t)),i=f.bind(null,n,o,!1),r=f.bind(null,n,o,!0)}else n=c(t),i=h.bind(null,n,t),r=function(){!function(e){if(null===e.parentNode)return!1;e.parentNode.removeChild(e)}(n)};return i(e),function(t){if(t){if(t.css===e.css&&t.media===e.media&&t.sourceMap===e.sourceMap)return;i(e=t)}else r()}}e.exports=function(e,t){(t=t||{}).singleton||"boolean"==typeof t.singleton||(t.singleton=r());var n=l(e=e||[],t);return function(e){if(e=e||[],"[object Array]"===Object.prototype.toString.call(e)){for(var i=0;i<n.length;i++){var r=a(n[i]);s[r].references--}for(var o=l(e,t),c=0;c<n.length;c++){var d=a(n[c]);0===s[d].references&&(s[d].updater(),s.splice(d,1))}n=o}}}},7670:(e,t,n)=>{"use strict";n.d(t,{Z:()=>l});const i={name:"ImageSlider",data:function(){return{sliders:[],model:0,sendRequest:!0}},mounted:function(){var e=this,t=this.$siteUrl+"/api/app/sliders";this.axios.get(t).then((function(t){e.sliders=t.data.original,e.sendRequest=!1})),window.innerWidth<769&&document.querySelector(".image-slider").classList.add("mobile-theme")},methods:{getUrl:function(e){return window.innerWidth<769?this.$siteUrl+"/files/slider/"+e.mobile_image_url:this.$siteUrl+"/files/slider/"+e.image_url}}};var r=n(3379),o=n.n(r),s=n(4395),a={insert:"head",singleton:!1};o()(s.Z,a);s.Z.locals;const l=(0,n(1900).Z)(i,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"image-slider",staticStyle:{height:"inherit"}},[e.sendRequest?n("v-skeleton-loader",{attrs:{type:"image",height:"100%"}}):n("v-carousel",{attrs:{"hide-delimiter-background":"",height:"100%",cycle:""},model:{value:e.model,callback:function(t){e.model=t},expression:"model"}},e._l(e.sliders,(function(t,i){return n("v-carousel-item",{key:i},[n("a",{attrs:{target:"_blank",href:t.url}},[n("img",{attrs:{src:e.getUrl(t)}})])])})),1)],1)}),[],!1,null,null,null).exports},1900:(e,t,n)=>{"use strict";function i(e,t,n,i,r,o,s,a){var l,c="function"==typeof e?e.options:e;if(t&&(c.render=t,c.staticRenderFns=n,c._compiled=!0),i&&(c.functional=!0),o&&(c._scopeId="data-v-"+o),s?(l=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),r&&r.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(s)},c._ssrRegister=l):r&&(l=a?function(){r.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:r),l)if(c.functional){c._injectStyles=l;var d=c.render;c.render=function(e,t){return l.call(t),d(e,t)}}else{var u=c.beforeCreate;c.beforeCreate=u?[].concat(u,l):[l]}return{exports:e,options:c}}n.d(t,{Z:()=>i})}}]);
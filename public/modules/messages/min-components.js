(self.webpackChunk=self.webpackChunk||[]).push([['messages'],{'messages_component':(e,t,n)=>{Vue.component("panel-message",n(523).Z)},7506:(e,t,n)=>{"use strict";n.d(t,{Z:()=>i});var r=n(3645),o=n.n(r)()((function(e){return e[1]}));o.push([e.id,".form_link{background-color:#f4516c}.form_link,.to_link{border-radius:15px;-webkit-border-radius:15px;color:#fff!important;font-size:14px;padding:4px 15px}.to_link{background-color:#34bfa3}.messages a{text-decoration:none}.message_content_div{border-radius:4px;-webkit-border-radius:4px;box-shadow:0 2px 3px rgba(0,0,0,.09);color:#444d4d;font-size:15px;margin-top:20px;min-height:160px}.message_content_header{background-color:#f6f8fa;border-top-left-radius:4px;-webkit-border-top-left-radius:4px;border-top-right-radius:4px;-webkit-border-top-right-radius:4px;color:#000;cursor:pointer;display:inline-flex;justify-content:space-between;padding:18px;width:100%}.message_content_div .content{line-height:30px;list-style:none;padding:18px}.mobile-message-box{background-color:#fff;border-radius:9px;-webkit-border-radius:9px;box-shadow:0 2px 4px 2px rgba(0,0,0,.09);-webkit-box-shadow:0 2px 4px 2px rgba(0,0,0,.09);margin-bottom:10px;padding:5px 15px}.user_message_div{border-radius:4px;-webkit-border-radius:4px;box-shadow:0 2px 3px rgba(0,0,0,.09);color:#444d4d;font-size:15px;margin-top:20px;min-height:160px}.user_message_div_header{background-color:rgba(232,249,249,.68);border-top-left-radius:4px;-webkit-border-top-left-radius:4px;border-top-right-radius:4px;-webkit-border-top-right-radius:4px;color:#000;cursor:pointer;display:inline-flex;justify-content:space-between;padding:18px;width:100%}.message_content{line-height:30px;list-style:28px;padding:18px}",""]);const i=o},3645:e=>{"use strict";e.exports=function(e){var t=[];return t.toString=function(){return this.map((function(t){var n=e(t);return t[2]?"@media ".concat(t[2]," {").concat(n,"}"):n})).join("")},t.i=function(e,n,r){"string"==typeof e&&(e=[[null,e,""]]);var o={};if(r)for(var i=0;i<this.length;i++){var a=this[i][0];null!=a&&(o[a]=!0)}for(var s=0;s<e.length;s++){var d=[].concat(e[s]);r&&o[d[0]]||(n&&(d[2]?d[2]="".concat(n," and ").concat(d[2]):d[2]=n),t.push(d))}},t}},3379:(e,t,n)=>{"use strict";var r,o=function(){return void 0===r&&(r=Boolean(window&&document&&document.all&&!window.atob)),r},i=function(){var e={};return function(t){if(void 0===e[t]){var n=document.querySelector(t);if(window.HTMLIFrameElement&&n instanceof window.HTMLIFrameElement)try{n=n.contentDocument.head}catch(e){n=null}e[t]=n}return e[t]}}(),a=[];function s(e){for(var t=-1,n=0;n<a.length;n++)if(a[n].identifier===e){t=n;break}return t}function d(e,t){for(var n={},r=[],o=0;o<e.length;o++){var i=e[o],d=t.base?i[0]+t.base:i[0],c=n[d]||0,u="".concat(d," ").concat(c);n[d]=c+1;var l=s(u),p={css:i[1],media:i[2],sourceMap:i[3]};-1!==l?(a[l].references++,a[l].updater(p)):a.push({identifier:u,updater:x(p,t),references:1}),r.push(u)}return r}function c(e){var t=document.createElement("style"),r=e.attributes||{};if(void 0===r.nonce){var o=n.nc;o&&(r.nonce=o)}if(Object.keys(r).forEach((function(e){t.setAttribute(e,r[e])})),"function"==typeof e.insert)e.insert(t);else{var a=i(e.insert||"head");if(!a)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");a.appendChild(t)}return t}var u,l=(u=[],function(e,t){return u[e]=t,u.filter(Boolean).join("\n")});function p(e,t,n,r){var o=n?"":r.media?"@media ".concat(r.media," {").concat(r.css,"}"):r.css;if(e.styleSheet)e.styleSheet.cssText=l(t,o);else{var i=document.createTextNode(o),a=e.childNodes;a[t]&&e.removeChild(a[t]),a.length?e.insertBefore(i,a[t]):e.appendChild(i)}}function f(e,t,n){var r=n.css,o=n.media,i=n.sourceMap;if(o?e.setAttribute("media",o):e.removeAttribute("media"),i&&"undefined"!=typeof btoa&&(r+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(i))))," */")),e.styleSheet)e.styleSheet.cssText=r;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(r))}}var h=null,b=0;function x(e,t){var n,r,o;if(t.singleton){var i=b++;n=h||(h=c(t)),r=p.bind(null,n,i,!1),o=p.bind(null,n,i,!0)}else n=c(t),r=f.bind(null,n,t),o=function(){!function(e){if(null===e.parentNode)return!1;e.parentNode.removeChild(e)}(n)};return r(e),function(t){if(t){if(t.css===e.css&&t.media===e.media&&t.sourceMap===e.sourceMap)return;r(e=t)}else o()}}e.exports=function(e,t){(t=t||{}).singleton||"boolean"==typeof t.singleton||(t.singleton=o());var n=d(e=e||[],t);return function(e){if(e=e||[],"[object Array]"===Object.prototype.toString.call(e)){for(var r=0;r<n.length;r++){var o=s(n[r]);a[o].references--}for(var i=d(e,t),c=0;c<n.length;c++){var u=s(n[c]);0===a[u].references&&(a[u].updater(),a.splice(u,1))}n=i}}}},523:(e,t,n)=>{"use strict";n.d(t,{Z:()=>d});const r={name:"PanelMessage"};var o=n(3379),i=n.n(o),a=n(7506),s={insert:"head",singleton:!1};i()(a.Z,s);a.Z.locals;const d=(0,n(1900).Z)(r,(function(){var e=this,t=e.$createElement;return(e._self._c||t)("div",{staticClass:"messages"},[e._t("default")],2)}),[],!1,null,null,null).exports},1900:(e,t,n)=>{"use strict";function r(e,t,n,r,o,i,a,s){var d,c="function"==typeof e?e.options:e;if(t&&(c.render=t,c.staticRenderFns=n,c._compiled=!0),r&&(c.functional=!0),i&&(c._scopeId="data-v-"+i),a?(d=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),o&&o.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(a)},c._ssrRegister=d):o&&(d=s?function(){o.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:o),d)if(c.functional){c._injectStyles=d;var u=c.render;c.render=function(e,t){return d.call(t),u(e,t)}}else{var l=c.beforeCreate;c.beforeCreate=l?[].concat(l,d):[d]}return{exports:e,options:c}}n.d(t,{Z:()=>r})}}]);

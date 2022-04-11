import Vue from 'vue';
window.Vue=Vue;
import axios from 'axios';
import VueAxsio from 'vue-axios';
Vue.use(VueAxsio,axios);

import {store} from "./store";
window.store=store;


//import(/* webpackChunkName:'users' */'../../modules/users/resource/js/components.js');
//
import(/* webpackChunkName:'themes' */'../../modules/themes/resource/js/components.js');
//
import(/* webpackChunkName:'front-theme' */'../../modules/themes/resource/js/front-components');
//
// import(/* webpackChunkName:'shop' */'../../modules/shop/resource/js/components.js');
//
// import(/* webpackChunkName:'productPriceChanges' */'../../modules/productPriceChanges/resource/js/components.js');
//
//import(/* webpackChunkName:'items' */'../../modules/items/resource/js/components.js');
//
// import(/* webpackChunkName:'gallery' */'../../modules/gallery/resource/js/components.js');
//
// import(/* webpackChunkName:'panel-gallery' */'../../modules/gallery/resource/js/panel-components.js');
//
// import(/* webpackChunkName:'priceVariation' */'../../modules/priceVariation/resource/js/components.js');
//
//import(/* webpackChunkName:'cart' */'../../modules/cart/resource/js/components.js');
//
// import(/* webpackChunkName:'panelTheme' */'../../modules/panelTheme/resource/js/components.js');
//
// import(/* webpackChunkName:'address' */'../../modules/address/resource/js/components.js');
//
// import(/* webpackChunkName:'sliders' */'../../modules/sliders/resource/js/components.js');
//
// import(/* webpackChunkName:'faq' */'../../modules/faq/resource/js/components.js');
//
// import(/* webpackChunkName:'orders' */'../../modules/orders/resource/js/components.js');
//
// import(/* webpackChunkName:'messages' */'../../modules/messages/resource/js/components.js');
//
// import(/* webpackChunkName:'filters' */'../../modules/filters/resource/js/components.js');
//
// import(/* webpackChunkName:'address' */'../../modules/address/resource/js/components.js');
//
// import(/* webpackChunkName:'colors' */'../../modules/colors/resource/js/components.js');
//
// import(/* webpackChunkName:'favourite' */'../../modules/favourite/resource/js/components.js');
//
// import(/* webpackChunkName:'incredibleOffers' */'../../modules/incredibleOffers/resource/js/components.js');
//
// import(/* webpackChunkName:'fileManager' */'../../modules/fileManager/resource/js/components.js');
//
// import(/* webpackChunkName:'sellers' */'../../modules/sellers/resource/js/components.js');
//
//import(/* webpackChunkName:'seller-panel' */'../../modules/sellers/resource/js/panel.js');
//
// import(/* webpackChunkName:'comments' */'../../modules/comments/resource/js/components.js');
//
// import(/* webpackChunkName:'questions' */'../../modules/questions/resource/js/components.js');
//
// import(/* webpackChunkName:'salesReport' */'../../modules/salesReport/resource/js/components.js');
//
// import(/* webpackChunkName:'blog' */'../../modules/blog/resource/js/components.js');
//
// import(/* webpackChunkName:'visitStatistics' */'../../modules/visitStatistics/resource/js/components.js');
//
// import(/* webpackChunkName:'discount' */'../../modules/discount/resource/js/components.js');
//
// import(/* webpackChunkName:'pages' */'../../modules/pages/resource/js/components.js');
//
// import(/* webpackChunkName:'brands' */'../../modules/brands/resource/js/components.js');
//
// import(/* webpackChunkName:'productStatusNotification' */'../../modules/productStatusNotification/resource/js/components.js');

import(/* webpackChunkName:'productComparison' */'../../modules/productComparison/resource/js/components.js');

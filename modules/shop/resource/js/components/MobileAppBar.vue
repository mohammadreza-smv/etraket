<template>
    <div>

        <v-app-bar
            elevation="0"
            class="shop-header"
            color="light-blue lighten-1"
        >
            <v-app-bar-nav-icon @click.stop="showDrawer()"></v-app-bar-nav-icon>

            <v-toolbar-title @click="$root.$emit('send_get_request',$siteUrl)">{{ shop_name }}</v-toolbar-title>

            <v-spacer></v-spacer>

            <slot name="items">

            </slot>

        </v-app-bar>

        <v-navigation-drawer
            v-model="drawer"
            right
            fixed
            app
            class="category-navigation"
        >

            <slot name="cat_list"></slot>

        </v-navigation-drawer>

    </div>
</template>

<script>
    export default {
        name: "MobileAppBar",
        props:['shop_name'],
        data(){
            return {
                drawer:false
            }
        },
        mounted() {
            const self=this;
            this.$nextTick(function () {

                const parent_cat=document.getElementsByClassName('parent_cat');

                const li_div=document.getElementsByClassName('li_div');

                const child_cat=document.getElementsByClassName('child_cat');

                for (let i = 0; i <parent_cat.length ; i++) {
                    parent_cat[i].addEventListener('click',function () {
                        self.setDefault(parent_cat,li_div,child_cat);
                        self.addParentElEvent( parent_cat[i]);
                    });
                }

                for (let i = 0; i <child_cat.length ; i++) {
                    child_cat[i].addEventListener('click',function () {

                        if(child_cat[i].parentElement.querySelector('ul').style.display==='block'){
                            child_cat[i].parentElement.querySelector('ul').style.display='none';
                            child_cat[i].querySelector('a .mdi-chevron-up')
                                .classList.add('mdi-chevron-down');
                            child_cat[i].querySelector('a .mdi-chevron-up')
                                .classList.remove('mdi-chevron-up');
                        }
                        else{
                            child_cat[i].parentElement.querySelector('ul').style.display='block';
                            child_cat[i].querySelector('a .mdi-chevron-down')
                                .classList.add('mdi-chevron-up');
                            child_cat[i].querySelector('a .mdi-chevron-down')
                                .classList.remove('mdi-chevron-down');
                        }

                    });
                }

            });

            this.$root.$on('show_progress',function () {
                if(self.drawer===true){
                    self.drawer=false;
                }
            });

            setTimeout(function () {
                self.$root.$emit('addLoadEvent','shop-header');
            },100);
        },
        methods:{
            showDrawer:function () {
                this.drawer = !this.drawer;
                const li_div=document.getElementsByClassName('li_div');
                const parent_cat=document.getElementsByClassName('parent_cat');
                const child_cat=document.getElementsByClassName('child_cat');
                this.setDefault(parent_cat,li_div,child_cat);
            },
            addParentElEvent:function (el) {
                if(el.querySelector('.mdi-chevron-down')!==null){
                    el.parentElement.querySelector('.li_div').style.display='block';
                    el.querySelector('.mdi-chevron-down').classList
                        .add('mdi-chevron-up');
                    el.querySelector('.mdi-chevron-up')
                        .classList.remove('mdi-chevron-down');
                }
                else{
                    el.parentElement.querySelector('.li_div').style.display='none';
                    el.querySelector('.mdi-chevron-up').classList
                        .add('mdi-chevron-down');
                    el.querySelector('.mdi-chevron-up')
                        .classList.remove('mdi-chevron-up');
                }
            },
            setDefault:function (parent_cat,li_div,child_cat) {
                for (let j = 0; j <li_div.length ; j++) {
                    li_div[j].style.display='none';
                }

                for (let i = 0; i <parent_cat.length ; i++) {
                    if(parent_cat[i].querySelector('.mdi-chevron-up')!==null){
                        parent_cat[i].parentElement.querySelector('.li_div').style.display='none';
                        parent_cat[i].querySelector('.mdi-chevron-up').classList
                            .add('mdi-chevron-down');
                        parent_cat[i].querySelector('.mdi-chevron-up')
                            .classList.remove('mdi-chevron-up');
                    }
                }

                for (let i = 0; i <child_cat.length ; i++) {
                    if(child_cat[i].parentElement.querySelector('ul').style.display==='block'){
                        child_cat[i].parentElement.querySelector('ul').style.display='none';
                        child_cat[i].querySelector('a .mdi-chevron-up')
                            .classList.add('mdi-chevron-down');
                        child_cat[i].querySelector('a .mdi-chevron-up')
                            .classList.remove('mdi-chevron-up');
                    }
                }
            }
        }
    }
</script>

<style>

</style>

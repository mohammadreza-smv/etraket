<template>
    <v-navigation-drawer
        class="navigation-drawer"
        width="270"
        dark
        app
        right
        permanent
        absolute
        :mini-variant.sync="mini"
        id="admin-panel-navigation"
        height="auto"
        style="bottom: 0px"
    >

        <div class="search-box" v-if="mini===false">
            <v-text-field v-model="searchText" placeholder="جست و جو ..."></v-text-field>
        </div>

        <v-list class="panel-menu" dense>

            <v-list-group v-for="(item,key) in menus"
                        :key="key"
                        @click="setActiveMenu(key,item)"
                        :append-icon="item.child==undefined ? '' : '$expand'"
                        v-model="item.active"
                        no-action
                        color="rebeccapurple"
            >

                <template v-slot:activator>

                    <v-list-item-icon class="admin_menu_icon">
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title v-if="item.child==undefined">
                            <a :href="item.url" class="router-link">
                                {{ item.label }}
                            </a>
                        </v-list-item-title>
                        <v-list-item-title v-else>{{ item.label }}</v-list-item-title>
                    </v-list-item-content>

                </template>

                <v-list-item v-for="(child,key2) in item.child" :key="key2">

                    <v-list-item-content>
                        <v-list-item-title><a :href="child.url" :class="[ child.target===undefined ? 'router-link' : '' ]">{{ child.label }}</a></v-list-item-title>
                    </v-list-item-content>

                </v-list-item>

            </v-list-group>

        </v-list>

    </v-navigation-drawer>

</template>

<script>
    export default {
        name: "drawer",
        props:['items'],
        data(){
            return {
                searchText:'',
                miniStatus:false,
                miniManual:false,
                default:0
            }
        },
        mounted() {
            const self=this;
            this.setDefaultActiveItem();
            window.addEventListener('resize', this.setHeight);
            this.$root.$on('changeNavigation', () => {
                self.mini=!self.mini;
            });
            this.$nextTick(function () {
                this.$root.$emit('addLoadEvent','navigation-drawer');
            });
            this.$nextTick(function () {
                this.$root.$emit('addLoadEvent','navigation-drawer');
            });
        },
        computed:{
            menus(){
                const list=[];
                const keys=Object.keys(this.items);
                for (let i = 0; i <keys.length ; i++) {
                    if(this.items[keys[i]].label.toString().indexOf(this.searchText)!==-1){
                        list.push(this.items[keys[i]]);
                    }
                }
                return list;
            },
            mini:{
                get:function () {
                    switch (this.$vuetify.breakpoint.name) {
                        case 'xs':
                            return  this.miniManual ? this.miniStatus : true;
                        case 'sm':
                            return  this.miniManual ? this.miniStatus : true;
                        case 'md':
                            return  this.miniManual ? this.miniStatus : true;
                        case 'lg':
                            return  this.miniManual ? this.miniStatus : false;
                        case 'xl':
                            return  this.miniManual ? this.miniStatus : false;
                    }
                },
                set:function (newValue) {
                    this.miniManual=true;
                    this.miniStatus=newValue;
                }
            }
        },
        methods:{
            setActiveMenu:function (key,item) {
                const self=this;
                setTimeout(function () {
                    self.$root.$emit('addLoadEvent','navigation-drawer');
                    self.setHeight();
                },400);
            },
            setHeight:function () {
                 const drawerHeight=document.querySelector('.v-navigation-drawer__content').scrollHeight;
                 document.querySelector('.navigation-drawer').style.minHeight=drawerHeight+'px';
            },
            setDefaultActiveItem:function () {
                const keys=Object.keys(this.items);
                const pageUrl=window.location.href;
                for (let i = 0; i <keys.length ; i++) {
                    if(this.items[keys[i]].url!==undefined){
                        if(this.items[keys[i]].url===pageUrl){
                            this.items[keys[i]].active=true;
                        }
                    }
                    else if(this.items[keys[i]].child!==undefined){
                        const child=this.items[keys[i]].child;
                        for (let j = 0; j <child.length ; j++) {
                            if(child[j].url===pageUrl){
                                this.items[keys[i]].active=true;
                            }
                        }
                    }
                }
                this.$forceUpdate();
            }
        }
    }
</script>

<style>
    @import "../style.css";
</style>

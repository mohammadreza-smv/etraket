<template>

    <v-app class="app-style content-box">

        <div style="height: 100%">

            <div v-if="$store.state.widget.page_state=='load-data'" class="row" style="height: 100%">


                <v-navigation-drawer width="300" class="widget-navigation-drawer" app permanent right :mini-variant="miniVariant">

                    <div style="display:flex;justify-content: left">
                       <span v-if="miniVariant" @click="miniVariant=!miniVariant" >
                           <v-icon>mdi-arrow-left</v-icon>
                       </span>
                       <span v-else @click="miniVariant=!miniVariant" >
                              <v-icon>mdi-arrow-right</v-icon>
                       </span>
                    </div>

                    <div v-if="!miniVariant">
                        <widget-positions/>
                        <widget-list/>
                        <html-elements/>
                    </div>

                </v-navigation-drawer>

                <v-main>

                    <v-app-bar color="white" height="60" elevation="0" class="app-bar">

                        <v-text-field
                            class="page-width-style"
                            v-model="$store.state.widget.inputPageWidth"
                            style="margin-top: 25px"
                            label="عرض صفحه"
                            outlined
                            @input="$store.commit('widget/change_page_width')"
                            dense
                            :value="get_content_width()"
                        ></v-text-field>

                        <v-btn color="success"
                               v-on:click="$store.dispatch('widget/send_widget_data')">ذخیره</v-btn>

                    </v-app-bar>

                    <div style="width: 100%;position:relative;overflow-x:auto;padding: 10px">
                        <div :style="{width:page_width+'px',margin:'auto'}" v-if="page_width>300">

                            <div v-for="(row,key) in $store.state.widget.rows"
                                 draggable="true"
                                 @dragstart="$store.commit('widget/rowDragstart',key)"
                                 @drop="$store.commit('widget/rowDropFinish',key)"
                                 :style="{
                                     marginBottom:$store.state.widget.style[row.id].marginBottom,
                                 }"
                            >

                                <div class="row-setting-items">
                                    <div>
                                        <span class="row_id">#{{ row.id }}</span>
                                    </div>
                                    <div>
                                        <ul>
                                            <li v-on:click="newBox(row.id,key)">
                                                <v-icon>mdi-view-list</v-icon>
                                            </li>
                                            <li v-on:click="$store.dispatch('widget/show_style_box',{id:row.id})">
                                                <v-icon>mdi-cogs</v-icon>
                                            </li>
                                            <li v-on:dblclick="$store.dispatch('widget/removeBox',row.id)">
                                                <v-icon>mdi-delete-outline</v-icon>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="widget-row">
                                    <div :id="row.id"
                                         @dragover.prevent
                                         @drop="$store.commit('widget/dropFinish',{key:key,id:row.id})"
                                         :style="[getStyle(row.id),{marginBottom:'0px'}]"
                                    >

                                        <template v-for="(child,key1) in row['child']" >

                                            <box-view v-if="child['type']==='box'"
                                                      :data="child"
                                                      :box_key="key1"
                                                      :parent_key="key"
                                                      dropFunction="dropFinish"
                                            ></box-view>

                                            <html-tag-view
                                                v-else-if="child['type']==='html'"
                                                :data="child"
                                                :el-key="key1"
                                            ></html-tag-view>

                                            <widget-view
                                                v-else-if="child['type']=='widget'"
                                                :data="child"
                                                :key="key1"
                                            />

                                        </template>

                                    </div>
                                </div>

                            </div>

                            <p class="new-line" v-on:click="newLine" v-if="$store.state.widget.position!=''">
                                <v-icon>mdi-plus</v-icon>
                                <span>افزودن سطر جدید</span>
                            </p>

                        </div>
                    </div>


                    <widget-setting/>

                    <new-box></new-box>

                    <style-box>

                        <template  v-slot:setting_box v-if="$store.state.widget.setting_box!=''">
                            <component :is="$store.state.widget.setting_box"/>
                        </template>

                    </style-box>

                </v-main>

            </div>

            <div v-else-if="$store.state.widget.page_state=='get-data'" style="height: 100%;display: flex;align-items: center;justify-content: center;">
                <v-progress-circular
                    indeterminate
                    color="red"
                ></v-progress-circular>
            </div>
        </div>
    </v-app>

</template>

<script>
    import NewBox from "./NewBox";
    import Widget from '../store/Widget';
    import StyleBox from "./StyleBox";
    import BoxView from "./BoxView";
    import HtmlElements from "./HtmlElements";
    import HtmlTagView from "./HtmlTagView";
    import ImageAttribute from "./ImageAttribute";
    import CodeAttribute from "./CodeAttribute";
    import CardAttribute from "./CardAttribute";
    import SlideAttribute from "./SlideAttribute";
    import UlAttribute from "./UlAttribute";
    import PAttribute from "./PAttribute";
    import WidgetList from "./WidgetList";
    import WidgetView from "./WidgetView";
    import WidgetPositions from "./WidgetPositions";
    import ServerErrorMessage from "./ServerErrorMessage";
    import WidgetSetting from "./WidgetSetting";
    import {mapState} from 'vuex';
    import mixins from "../mixins";
    export default {
        name: "ThemeWidgets",
        mixins:[mixins],
        components:{
            NewBox,
            WidgetPositions,
            StyleBox,
            BoxView,
            HtmlElements,
            HtmlTagView,
            ImageAttribute,
            SlideAttribute,
            WidgetList,
            WidgetView,
            ServerErrorMessage,
            WidgetSetting,
            CardAttribute,
            UlAttribute,
            CodeAttribute,
            PAttribute
        },
        data(){
            return {
                miniVariant:false
            }
        },
        mounted() {
            this.setAppBoxHeight();
            this.$store.dispatch('widget/get_widgets');
        },
        computed:mapState('widget',[
            'page_width',
            'show_right_box',
            'styleId'
        ]),
        created() {
            this.$store.registerModule('widget',Widget);
        }
    }
</script>

<style>
    @import '../../assets/css/widgets.css';
</style>

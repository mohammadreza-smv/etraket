<template>

    <div :style="{
        width:$store.state.widget.style[data.id].width,
        marginRight:$store.state.widget.style[data.id].marginRight!=='' ? $store.state.widget.style[data.id].marginRight : '',
        marginTop:$store.state.widget.style[data.id].marginTop!=='' ? $store.state.widget.style[data.id].marginTop : '',
        marginLeft:$store.state.widget.style[data.id].marginLeft!=='' ? $store.state.widget.style[data.id].marginLeft : '',
        marginBottom:$store.state.widget.style[data.id].marginBottom!=='' ? $store.state.widget.style[data.id].marginBottom : ''

    }">
        <div class="row-setting-items" style="width: auto">
            <div>
                <span class="row_id">#{{ data.id }}</span>
            </div>
            <div>
                <ul>
                    <li v-if="remove_new_child===undefined" v-on:click="addChildBox(parent_key+'@'+box_key,data.id)">
                        <v-icon>mdi-view-list</v-icon>
                    </li>
                    <li  v-on:click="$store.dispatch('widget/show_style_box',{id:data.id})">
                        <v-icon>mdi-cogs</v-icon>
                        <span class="fa fa-cogs"></span>
                    </li>
                    <li v-on:dblclick="$store.dispatch('widget/removeBox',data.id)">
                        <v-icon>mdi-delete-outline</v-icon>
                    </li>
                </ul>
            </div>
        </div>

        <div  class="widget-row" style="width: auto"
              @dragstart="$store.commit('widget/boxDragstart',parent_key+'_'+box_key)"
              draggable="true"
              @dragover.prevent
              @drop="$store.commit('widget/'+dropFunction,{
                     key:box_key,
                     id:data.id,
                     parent_key:parent_key,
                     box_key:box_key
                 })"
        >

            <div :id="data.id"
                 :style="[getStyle(data.id),{width:'100%',margin:'0px'}]"
            >

                <template v-for="(child,key1) in data['child']" >

                    <html-tag-view
                        v-if="child['type']==='html'"
                        :data="child"
                        :el-key="key1"
                    ></html-tag-view>

                    <widget-view
                        v-else-if="child['type']==='widget'"
                        :data="child"
                        :key="key1"
                    />

                    <box-view v-else-if="child['type']==='box'"
                              :data="child"
                              :box_key="key1"
                              :parent_key="parent_key+'@'+box_key"
                              remove_new_child="true"
                              dropFunction="dropFinish2"
                    >

                    </box-view>


                </template>

            </div>

        </div>

    </div>

</template>

<script>
    import mixins from "../mixins";
    import HtmlTagView from './HtmlTagView'
    import WidgetView from "./WidgetView";
    export default {
        name: "BoxView",
        props:['data','box_key','parent_key','remove_new_child','dropFunction','dropFunction'],
        components:{
            HtmlTagView,
            WidgetView
        },
        mixins:[mixins]
    }
</script>


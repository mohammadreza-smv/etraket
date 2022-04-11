<template>

    <div>
        <div>
             <span v-on:dblclick="$store.dispatch('widget/removeBox',data.id)">
                  <v-icon size="20">mdi-delete-outline</v-icon>
             </span>
        </div>
        <div :style="{
        width:style[data.id].width,
        marginRight:$store.state.widget.style[data.id].marginRight!=='' ? $store.state.widget.style[data.id].marginRight : '',
        marginTop:$store.state.widget.style[data.id].marginTop!=='' ? $store.state.widget.style[data.id].marginTop : '',
        marginLeft:$store.state.widget.style[data.id].marginLeft!=='' ? $store.state.widget.style[data.id].marginLeft : '',
        marginTop:$store.state.widget.style[data.id].marginTop!=='' ? $store.state.widget.style[data.id].marginTop : ''

    }" class="tagView">



            <p v-if="tagData.p[this.data.id].content===''"
               v-on:dblclick="$store.dispatch('widget/show_style_box',{
                     id:data.id,
                     setting_box:'p-attribute'
            })">

                برای وارد کردن متن دلخواه کلیک کنید
            </p>

            <p v-html="tagData.p[this.data.id].content"
                 :style="[getStyle(data.id)]"
               v-on:dblclick="$store.dispatch('widget/show_style_box',{
                     id:data.id,
                     setting_box:'p-attribute'
            })"
            >

            </p>

        </div>
    </div>

</template>

<script>
    import mixins from "../mixins";
    import {mapState} from "vuex";
    export default {
        name: "pTag",
        props:['data'],
        mixins:[mixins],
        computed:mapState('widget',[
            'style',
            'tagData'
        ]),
        methods:{
            getDefaultStyle:function (id) {
                const defaultStyle=this.getStyle(id);
                let style={};
                if(defaultStyle['width']!==undefined){
                    style['width']=defaultStyle['width'];
                }
                else {
                    style['width']='120px';
                }

                if(defaultStyle['paddingTop']===undefined || defaultStyle['paddingRight']===undefined
                    || defaultStyle['paddingLeft']===undefined  || defaultStyle['paddingBottom']===undefined ){
                    style['padding']='10px 15px';
                }

                if(defaultStyle['backgroundColor']===undefined){
                    style['backgroundColor']='white';
                }

                return style;
            }
        }
    }
</script>

<style scoped>

</style>

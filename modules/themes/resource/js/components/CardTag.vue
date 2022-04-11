<template>
    <div :style="{width:style[data.id].width,
       marginRight:getStyle(data.id).marginRight!=='' ? getStyle(data.id).marginRight : '',
        marginTop:getStyle(data.id).marginTop!=='' ? getStyle(data.id).marginTop : '',
        marginLeft:getStyle(data.id).marginLeft!=='' ? getStyle(data.id).marginLeft : '',
        marginTop:getStyle(data.id).marginTop!=='' ? getStyle(data.id).marginTop : ''
    }" class="tagView">

        <span v-on:dblclick="$store.dispatch('widget/removeBox',data.id)">
                 <v-icon style="right: 10px;top:10px">mdi-delete-outline</v-icon>
        </span>

        <div
              :style="[getStyle(data.id),{margin:'0px'}]"
                v-on:dblclick="$store.dispatch('widget/show_style_box',{
                     id:data.id,
                     setting_box:'card-attribute'
                 })"
        >
            <img v-if="tagData.card[data.id]['img']!==''"
                 :src="tagData.card[data.id]['img']"
                 :style="{
                     margin:tagData.card[data.id]['imageMargin'],
                     width:tagData.card[data.id]['imgWidth'],
                     height:tagData.card[data.id]['imgWidth'],
                 }"
            />

            <v-icon v-else-if="tagData.card[data.id]['icon']"
                    :size="getIconSize(tagData.card[data.id]['imgWidth'])"
                    :color="tagData.card[data.id]['iconColor']"
            >
                mdi-{{ tagData.card[data.id]['icon'] }}
            </v-icon>

            <div :style="{
                      color:tagData.card[data.id]['titleColor'],
                      padding:tagData.card[data.id]['titlePadding'],
                      fontSize:tagData.card[data.id]['titleSize'],
            }">
                {{ tagData.card[data.id]['title'] }}
            </div>

            <div
                v-html="getContent(tagData.card[data.id]['content'])"
                :style="{
                      padding:tagData.card[data.id]['contentPadding'],
                      fontSize:tagData.card[data.id]['contentSize'],
                }"
            >
            </div>

        </div>

    </div>
</template>

<script>
    import {mapState} from "vuex";
    import mixins from "../mixins";
    export default {
        name: "CardTag",
        props:['data'],
        mixins:[mixins],
        computed:mapState('widget',[
            'style',
            'tagData'
        ]),
        methods:{
            getContent:function (content) {
                var re = new RegExp('__','g');
                content = content.replace(re, '&nbsp;');

                return content;
            },
            getIconSize:function (size) {
                size=size.toString().replace('px','');
                return size;
            },
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



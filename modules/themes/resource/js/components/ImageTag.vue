<template>
    <div :style="{
        width:style[data.id].width,
        marginRight:getStyle(data.id).marginRight!=='' ? getStyle(data.id).marginRight : '',
        marginTop:getStyle(data.id).marginTop!=='' ? getStyle(data.id).marginTop : '',
        marginLeft:getStyle(data.id).marginLeft!=='' ? getStyle(data.id).marginLeft : '',
        marginBottom:getStyle(data.id).marginBottom!=='' ? getStyle(data.id).marginBottom : ''
    }" class="tagView">

        <span v-on:dblclick="$store.dispatch('widget/removeBox',data.id)">
                 <v-icon size="20">mdi-delete-outline</v-icon>
        </span>
        <a>
            <img :src="getSrc()"
                :style="[getStyle(data.id),{margin:'0px'}]"
                 v-on:dblclick="$store.dispatch('widget/show_style_box',{
                     id:data.id,
                     setting_box:'image-attribute'
                 })"
            />
        </a>
    </div>

</template>

<script>
    import mixins from "../mixins";
    import {mapState} from 'vuex';
    export default {
        mixins:[mixins],
        name: "ImageTag",
        props:['data'],
        computed:mapState('widget',[
            'style',
            'tagData'
        ]),
        methods:{
            getSrc:function () {
                if(this.tagData.img[this.data.id].src==''){
                    return this.$siteUrl+"/modules/themes/default.png";
                }
                else{
                    return  this.tagData.img[this.data.id].src;
                }
            }
        }
    }
</script>


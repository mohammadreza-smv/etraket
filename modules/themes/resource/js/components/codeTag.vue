<template>

    <div>
        <div>
             <span v-on:dblclick="$store.dispatch('widget/removeBox',data.id)">
                  <v-icon size="20">mdi-delete-outline</v-icon>
             </span>

            <span v-on:dblclick="$store.dispatch('widget/show_style_box',{
                     id:data.id,
                     setting_box:'code-attribute'
            })">

                 <v-icon size="20">mdi-cogs</v-icon>

            </span>
        </div>
        <div :style="{
        width:style[data.id].width,
        marginRight:$store.state.widget.style[data.id].marginRight!=='' ? $store.state.widget.style[data.id].marginRight : '',
        marginTop:$store.state.widget.style[data.id].marginTop!=='' ? $store.state.widget.style[data.id].marginTop : '',
        marginLeft:$store.state.widget.style[data.id].marginLeft!=='' ? $store.state.widget.style[data.id].marginLeft : '',
        marginTop:$store.state.widget.style[data.id].marginTop!=='' ? $store.state.widget.style[data.id].marginTop : ''

    }" class="tagView">



            <p v-if="tagData.code[this.data.id].content===''"
               v-on:dblclick="$store.dispatch('widget/show_style_box',{
                     id:data.id,
                     setting_box:'code-attribute'
            })">

                برای وارد کردن کد html کلیک کنید
            </p>

            <div v-html="tagData.code[this.data.id].content"
                 :style="[getStyle(data.id)]"
            >

            </div>

        </div>
    </div>

</template>

<script>
    import {mapState} from "vuex";
    import mixins from "../mixins";

    export default {
        name: "codeTag",
        props:['data'],
        mixins:[mixins],
        computed:mapState('widget',[
            'style',
            'tagData'
        ]),
    }
</script>

<style>
    img[referrerpolicy='origin']{
        width: 100% !important;
        height:100% !important;
    }
</style>

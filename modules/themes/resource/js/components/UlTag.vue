<template>
    <div :style="[getStyle(data.id)]" class="tagView">
            <span v-on:dblclick="$store.dispatch('widget/removeBox',data.id)">
                 <v-icon>mdi-delete-outline</v-icon>
            </span>

        <div
            v-on:dblclick="$store.dispatch('widget/show_style_box',{
                     id:data.id,
                     setting_box:'ul-attribute'
                 })"
        >
            <p v-if="tagData.ul[data.id]['title']===''">
                ابزارک ساخت لیست
            </p>

            <p v-if="tagData.ul[data.id]['title']!==''"
               :style="{
                     fontSize:tagData.ul[data.id]['titleSize'],
                     color:tagData.ul[data.id]['titleColor'],
                     margin:'0px'
               }"
            >
                <v-icon v-if="tagData.ul[data.id]['titleIcon']!==''">
                    mdi-{{ tagData.ul[data.id]['titleIcon'] }}
                </v-icon>
                {{ tagData.ul[data.id]['title'] }}

            </p>

            <ul>
                <li  v-for="item in tagData.ul[data.id]['items']" v-if="item.title!==''"
                     :style="{
                     padding:tagData.ul[data.id]['itemPadding'],
                     listStyle:'none'
               }">
                    <span>{{ item.title }}</span>
                </li>
            </ul>

        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";
    import mixins from "../mixins";

    export default {
        name: "UlTag",
        props:['data'],
        mixins:[mixins],
        computed:mapState('widget',[
            'style',
            'tagData'
        ]),
    }
</script>


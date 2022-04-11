<template>
    <div>

        <img v-if="img!==undefined" :src="img"
             :style="{
                   width:imgWidth!==undefined ? imgWidth :'',
                   margin:imageMargin!==undefined ? imageMargin :'',
           }"
        />

        <div
            :style="{
                   color:titleColor!==undefined ? titleColor :'black',
                   fontSize:titleSize!==undefined ? titleSize :'',
                   padding:titlePadding!==undefined ? titlePadding :''
           }">
            <slot name="title"></slot>
        </div>

        <div :style="{
                   color:contentColor!==undefined ? contentColor :'black',
                   fontSize:contentSize!==undefined ? contentSize :'',
                   padding:contentPadding!==undefined ? contentPadding :''
           }">
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ThemeCard",
        data(){
            return {
                'titleColor':undefined,
                'titleSize':undefined,
                'titlePadding':undefined,
                'contentSize':undefined,
                'contentPadding':undefined,
                'contentColor':undefined,
                'img':undefined,
                'imgWidth':undefined,
                'imageMargin':undefined
            }
        },
        props:[
            'tag_id'
        ],
        mounted() {
            const detail=widgetData[this.tag_id];
            if(detail!==undefined){
                const keys=Object.keys(detail);
                for (let i = 0; i <keys.length ; i++) {
                    if(detail[keys[i]]!==''){
                        this[keys[i]]=detail[keys[i]];
                    }
                }
            }
        }
    }
</script>
<style>
    @import "../theme.css";
</style>



<template>

    <image-tag :data="data" v-if="data.tag==='img'"></image-tag>

    <card-tag :data="data" v-else-if="data.tag==='card'"></card-tag>

    <ul-tag :data="data" v-else-if="data.tag==='ul'"></ul-tag>

    <code-tag :data="data" v-else-if="data.tag==='code'"></code-tag>

    <p-tag :data="data" v-else-if="data.tag==='p'"></p-tag>

    <slide-tag :data="data" v-else-if="data.tag==='slide'"></slide-tag>

</template>

<script>
    import ImageTag from "./ImageTag";
    import CardTag from "./CardTag";
    import UlTag from "./UlTag";
    import CodeTag from "./CodeTag";
    import pTag from "./pTag";
    import SlideTag from "./SlideTag";
    export default {
        name: "HtmlTagView",
        props:['data','el-key'],
        components:{
            ImageTag,
            CardTag,
            UlTag,
            CodeTag,
            pTag,
            SlideTag
        }
    }
</script>





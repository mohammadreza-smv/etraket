<template>
   <div>
       <v-textarea
           label="متن"
           outlined
           v-model="$store.state.widget.tagData.p[$store.state.widget.styleId].content"
           dense
           style="margin-left: 15px;margin-right:15px"
       ></v-textarea>

       <v-checkbox
           v-model="$store.state.widget.tagData.p[$store.state.widget.styleId].showMore"
           dense
           label="نمایش بخش از متن در صورت طولانی بودن"
       ></v-checkbox>
   </div>
</template>

<script>
    export default {
        name: "PAttribute"
    }
</script>

<style scoped>

</style>

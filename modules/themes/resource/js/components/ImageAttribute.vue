<template>
    <div>
        <v-text-field
            label="آدرس تصویر"
            outlined
            v-model="$store.state.widget.tagData.img[$store.state.widget.styleId].src"
            dense
            style="margin-left: 15px;margin-right:15px"
        ></v-text-field>

        <v-text-field
            label="لینک تصویر"
            outlined
            v-model="$store.state.widget.tagData.img[$store.state.widget.styleId].link"
            dense
            style="margin-left: 15px;margin-right:15px"
        ></v-text-field>

        <v-text-field
            label="آدرس تصویر موقع hover"
            outlined
            v-model="$store.state.widget.tagData.img[$store.state.widget.styleId].hoverSrc"
            dense
            style="margin-left: 15px;margin-right:15px"
        ></v-text-field>

    </div>
</template>

<script>
    export default {
        name: "ImageAttribute"
    }
</script>


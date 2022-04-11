<template>
    <div>

        <v-textarea
            label="کد html"
            outlined
            v-model="$store.state.widget.tagData.code[$store.state.widget.styleId].content"
            dense
            style="margin-left: 15px;margin-right:15px"
        ></v-textarea>

    </div>
</template>

<script>
    export default {
        name: "CodeAttribute"
    }
</script>

<style scoped>

</style>

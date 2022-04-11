<template>
    <div @click="$root.$emit('add_new_item_input',item.id)">
        <v-icon>mdi-plus</v-icon>
    </div>
</template>

<script>
    export default {
        name: "AddItemInput",
        props:['item']
    }
</script>

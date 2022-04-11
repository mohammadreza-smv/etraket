<template>
    <div v-if="variation.param2_type==='Modules\\warranty\\Models\\Warranty'">
        <v-icon>mdi-shield-check</v-icon>
        <span>{{ variation.param2.name }}</span>
    </div>
</template>

<script>
export default {
    name: "WarrantyVariationDetail",
    props:['variation']
}
</script>


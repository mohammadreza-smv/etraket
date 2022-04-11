<template>
    <div>
        <v-file-input
            :label="label"
            outlined
            dense
            :class="className"
            :name="name"
        ></v-file-input>
    </div>
</template>

<script>
    export default {
        name: "FileInput",
        props:['label','name','value'],
        data(){
            return {
                className:'c-field'
            }
        }
    }
</script>

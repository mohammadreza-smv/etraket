<template>

    <v-btn :color="type==='edit' ? 'primary' : 'success'" @click="validate()">
        {{ text }}
    </v-btn>

</template>

<script>
    export default {
        name: "FormBtn",
        props:['text','type','form_id'],
        methods:{
            validate () {
                const validate=this.form_id+"_validate";
                this.$root.$emit(validate);
            }
        }
    }
</script>

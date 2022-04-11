<template>
    <div class="c-combobox">
        <v-combobox
            v-model="select"
            :items="items"
            :label="label"
            outlined
            dense
            item-value="name"
            item-text="name"
            return-object
            item-color="white"
            class="c-field"
            @input="change"
        >
            <template v-slot:item="{ index, item }">

                <v-chip
                    :color="'#'+item.code"

                    label
                    small
                >
                    {{ item.name }}
                </v-chip>

            </template>

        </v-combobox>
        <input type="hidden" :name="name" :value="inputValue">
    </div>
</template>

<script>
    export default {
        name: "ColorCombobox",
        props:['label','items','name','default'],
        data(){
            return {
                select:null,
                inputValue:null
            }
        },
        mounted() {
            for (let i = 0; i <this.items.length ; i++) {
                if(this.items[i].id==this.default){
                    this.select=this.items[i]['name'];
                    this.inputValue=this.items[i]['id'];
                }
            }
        },
        methods:{
            change:function (value) {
                this.inputValue=value['id'];
            },
        }
    }
</script>


<template>
    <div>
        <div class="row">

            <div class="col-6">

                <v-text-field
                    label="عنوان"
                    outlined
                    v-model="$store.state.widget.tagData.ul[$store.state.widget.styleId].title"
                    dense
                    style="margin-left: 15px;margin-right:15px"
                    hide-details
                ></v-text-field>

            </div>

            <div class="col-6" style="display: flex">
                <v-menu offset-x>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-bind="attrs"
                            v-on="on"
                        >
                            انتخاب رنگ عنوان
                        </v-btn>
                    </template>
                    <v-color-picker
                        dot-size="25"
                        swatches-max-height="200"
                        show-swatches
                        v-model="$store.state.widget.tagData.ul[$store.state.widget.styleId].titleColor"
                    ></v-color-picker>
                </v-menu>
                <div>
                    <div
                        :style="{backgroundColor:$store.state.widget.tagData.ul[$store.state.widget.styleId].titleColor}"
                        class="selected-color">

                    </div>
                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-6">

                <v-text-field
                    label="اندازه عنوان"
                    outlined
                    v-model="$store.state.widget.tagData.ul[$store.state.widget.styleId].titleSize"
                    dense
                    placeholder="14px"
                    style="margin-left: 15px;margin-right:15px"
                    hide-details
                ></v-text-field>

            </div>


            <div class="col-6">

                <v-text-field
                    label="ایکون"
                    outlined
                    v-model="$store.state.widget.tagData.ul[$store.state.widget.styleId].titleIcon"
                    dense
                    style="margin-left: 15px;margin-right:15px"
                    hide-details
                ></v-text-field>

            </div>

        </div>

        <div class="row">

            <div class="col-6">

                <v-text-field
                    label="فاصله داخلی ایتم ها"
                    outlined
                    v-model="$store.state.widget.tagData.ul[$store.state.widget.styleId].itemPadding"
                    dense
                    style="margin-left: 15px;margin-right:15px"
                    hide-details
                    placeholder="10px 20px"
                ></v-text-field>

            </div>

            <div class="col-6" style="display: flex">
                <v-menu offset-x>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-bind="attrs"
                            v-on="on"
                        >
                            رنگ ایتم موقع hover
                        </v-btn>
                    </template>
                    <v-color-picker
                        dot-size="25"
                        swatches-max-height="200"
                        show-swatches
                        v-model="$store.state.widget.tagData.ul[$store.state.widget.styleId].hoverColor"
                    ></v-color-picker>
                </v-menu>
                <div>
                    <div
                        :style="{backgroundColor:$store.state.widget.tagData.ul[$store.state.widget.styleId].hoverColor}"
                        class="selected-color">

                    </div>
                </div>

            </div>

        </div>

        <p style="padding-right: 15px;margin: 0px">
            ایتم های لیست
        </p>

        <template v-for="(item,key) in $store.state.widget.tagData.ul[$store.state.widget.styleId]['items']">

            <div  class="row">

                <div class="col-6">

                    <v-text-field
                        label="عنوان"
                        outlined
                        v-model="item['title']"
                        dense
                        hide-details
                        style="margin-left: 15px;margin-right:15px"
                    ></v-text-field>

                </div>

                <div class="col-6" style="display: flex">

                    <v-text-field
                        label="url"
                        outlined
                        v-model="item['link']"
                        dense
                        placeholder="14px"
                        style="margin-left: 15px;margin-right:15px;"
                        hide-details
                    ></v-text-field>

                    <v-icon color="red" @click="removeItem(key)">
                        mdi-delete-outline
                    </v-icon>
                </div>

            </div>

        </template>

        <div  style="padding-right: 15px;">
            <v-icon color="red" @click="addNewItems()">
                mdi-plus
            </v-icon>
        </div>


    </div>
</template>

<script>
    export default {
        name: "UlAttribute",
        methods:{
            addNewItems:function () {
                this.$store.state.widget.tagData.ul[this.$store.state.widget.styleId]['items'].push(
                    {
                        title:'',
                        link:''
                    }
                )
            },
            removeItem:function (key)
            {
                this.$delete(
                    this.$store.state.widget.tagData.ul[this.$store.state.widget.styleId]['items'],
                    key
                );
            }
        }
    }
</script>

<style scoped>

</style>

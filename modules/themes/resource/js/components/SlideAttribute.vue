<template>
    <div>
        <p style="padding-right: 15px;margin: 0px">
            اسلاید ها
        </p>

        <template v-for="(item,key) in $store.state.widget.tagData.slide[$store.state.widget.styleId]['items']">

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

            <div  class="row">
                <div class="col-12">

                    <v-text-field
                        label="url تصویر"
                        outlined
                        v-model="item['src']"
                        dense
                        hide-details
                        style="margin-left: 40px;"
                    ></v-text-field>

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
        name: "SlideAttribute",
        methods:{
            addNewItems:function () {
                this.$store.state.widget.tagData.slide[this.$store.state.widget.styleId]['items'].push(
                    {
                        title:'',
                        link:'',
                        src:''
                    }
                )
            },
            removeItem:function (key)
            {
                this.$delete(
                    this.$store.state.widget.tagData.slide[this.$store.state.widget.styleId]['items'],
                    key
                );
            }
        }
    }
</script>

<style scoped>

</style>

<template>

    <v-dialog
        v-model="$store.state.widget.widgetDialog"
        width="500">

        <v-card>

            <v-card-title class="text-h5 lighten-2 header-dialog">
                <h6>تنظیمات ابزارک</h6>
                <v-icon @click="$store.state.widget.widgetDialog=false">mdi-close</v-icon>
            </v-card-title>

            <v-card-text style="padding-top: 20px">

                <template v-if="widgetTag!='' && widgetData[widgetTag].setting!=undefined && widgetData[widgetTag]['setting']['list']!=undefined">

                    <template v-for="(item,key) in widgetData[widgetTag].setting.list">

                        <div class="form-group">
                            <template v-if="item.type==='string'">

                                <v-text-field
                                  :label="item.label"
                                  outlined
                                  v-model="tagData[widgetTag][widgetId][key]"
                                  dense
                                >

                                </v-text-field>

                            </template>
                            <template v-else-if="item.type==='checkbox'">
                                <v-checkbox
                                    :label="item.label"
                                    dense
                                    v-model="tagData[widgetTag][widgetId][key]"
                                ></v-checkbox>
                            </template>
                            <template v-else>
                                <v-select
                                    :label="item.label"
                                    dense
                                    outlined
                                    :items="getItems(widgetData[widgetTag]['setting']['data'][key])"
                                    v-model="tagData[widgetTag][widgetId][key]"
                                    item-value="id"
                                    item-text="value"
                                >
                                </v-select>
                            </template>
                        </div>

                    </template>


                </template>

            </v-card-text>

        </v-card>

    </v-dialog>

</template>

<script>
    import {mapState} from 'vuex';
    export default {
        name: "WidgetSetting",
        computed:mapState('widget',[
            'tagData',
            'widgetTag',
            'widgetId',
            'widgetData'
        ]),
        methods:{
            getItems:function (item) {
                const newArray=[];
                for (let i = 0; i <item.length ; i++) {
                    newArray.push({
                        'id':i,
                        'value':item[i]
                    });
                }
                return newArray;
            }
        }
    }
</script>


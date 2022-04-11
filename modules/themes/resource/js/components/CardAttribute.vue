<template>
    <div>
        <div class="row">

            <div class="col-6">

                <v-text-field
                    label="عنوان"
                    outlined
                    v-model="$store.state.widget.tagData.card[$store.state.widget.styleId].title"
                    dense
                    style="margin-left: 15px;margin-right:15px"
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
                        v-model="$store.state.widget.tagData.card[$store.state.widget.styleId].titleColor"
                    ></v-color-picker>
                </v-menu>
                <div>
                    <div
                        :style="{backgroundColor:$store.state.widget.tagData.card[$store.state.widget.styleId].titleColor}"
                        class="selected-color">

                    </div>
                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-6">
                <v-text-field
                    label="فاصله داخلی عنوان"
                    outlined
                    v-model="$store.state.widget.tagData.card[$store.state.widget.styleId]['titlePadding']"
                    dense
                    style="margin-left: 15px;margin-right:15px"
                    placeholder="10px 20px"
                ></v-text-field>
            </div>

            <div class="col-6">
                <v-text-field
                    label="سایز نمایش عنوان"
                    outlined
                    v-model="$store.state.widget.tagData.card[$store.state.widget.styleId]['titleSize']"
                    dense
                    style="margin-left: 15px;margin-right:15px"
                    placeholder="16px"
                ></v-text-field>
            </div>
        </div>

        <div class="row">

            <v-textarea
                outlined
                height="120px"
                label="توضیحات"
                style="padding:0px 15px;"
                dense
                v-model="$store.state.widget.tagData.card[$store.state.widget.styleId].content"
            >
            </v-textarea>

        </div>

        <div class="row">

            <div class="col-6">
                <v-text-field
                    label="فاصله داخلی توضیحات"
                    outlined
                    v-model="$store.state.widget.tagData.card[$store.state.widget.styleId]['contentPadding']"
                    dense
                    style="margin-left: 15px;margin-right:15px"
                    placeholder="10px 20px"
                ></v-text-field>
            </div>

            <div class="col-6">
                <v-text-field
                    label="سایز نمایش توضیحات"
                    outlined
                    v-model="$store.state.widget.tagData.card[$store.state.widget.styleId]['contentSize']"
                    dense
                    style="margin-left: 15px;margin-right:15px"
                    placeholder="16px"
                ></v-text-field>
            </div>
        </div>

        <div class="row">

            <v-text-field
                outlined
                label="url"
                style="padding:0px 15px;"
                dense
                v-model="$store.state.widget.tagData.card[$store.state.widget.styleId].link"
            >
            </v-text-field>

        </div>

        <div class="row">

            <v-text-field
                outlined
                label="آدرس تصویر"
                style="padding:0px 15px"
                dense
                v-model="$store.state.widget.tagData.card[$store.state.widget.styleId].img"
            >
            </v-text-field>

        </div>

        <div class="row">

            <div class="col-6">
                <v-text-field
                    label="سایز نمایش تصویر"
                    outlined
                    v-model="$store.state.widget.tagData.card[$store.state.widget.styleId]['imgWidth']"
                    dense
                    style="margin-left: 15px;margin-right:15px"
                    placeholder="50px"
                ></v-text-field>
            </div>

            <div class="col-6">
                <v-text-field
                    label="فاصله خارجی تصویر"
                    outlined
                    v-model="$store.state.widget.tagData.card[$store.state.widget.styleId]['imageMargin']"
                    dense
                    style="margin-left: 15px;margin-right:15px"
                    placeholder="16px"
                ></v-text-field>
            </div>
        </div>

        <div class="row">

            <div class="col-6">
                <v-text-field
                    label="ایکون"
                    outlined
                    v-model="$store.state.widget.tagData.card[$store.state.widget.styleId]['icon']"
                    dense
                    style="margin-left: 15px;margin-right:15px"

                ></v-text-field>
            </div>

            <div class="col-6" style="display: flex">
                <v-menu offset-x>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-bind="attrs"
                            v-on="on"
                        >
                            انتخاب رنگ ایکون
                        </v-btn>
                    </template>
                    <v-color-picker
                        dot-size="25"
                        swatches-max-height="200"
                        show-swatches
                        v-model="$store.state.widget.tagData.card[$store.state.widget.styleId].iconColor"
                    ></v-color-picker>
                </v-menu>
                <div>
                    <div
                        :style="{backgroundColor:$store.state.widget.tagData.card[$store.state.widget.styleId].iconColor}"
                        class="selected-color">

                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "CardAttribute"
    }
</script>

<style scoped>

</style>

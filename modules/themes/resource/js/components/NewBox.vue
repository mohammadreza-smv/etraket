<template>
    <v-dialog
        width="500"
        v-model="$store.state.widget.newBoxDialog"
        content-class="new-box-dialog"
    >
        <v-card>

            <v-card-title class="text-h6">
                <span>{{ $store.state.widget.BoxLabel }}</span>
                <div @click="$store.commit('widget/changeNewBoxDialogStatus')"><v-icon>mdi-close</v-icon></div>
            </v-card-title>

            <v-card-text>

                <v-text-field
                    label="شناسه"
                    outlined
                    v-model="$store.state.widget.boxTitle"
                    style="margin-top: 30px"
                >

                </v-text-field>

                <p v-if="$store.state.widget.newBoxError" class="error">
                    {{ $store.state.widget.newBoxError }}
                </p>

            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                 <v-btn
                     color="success"
                     v-on:click="$store.state.widget.parentId==0 ? addNewLine() : addNewBox()"
                 >افزودن</v-btn>
            </v-card-actions>

        </v-card>

    </v-dialog>
</template>

<script>
    import mixins from "../mixins";
    export default {
        name: "NewBox",
        mixins:[mixins],
    }
</script>

<style scoped>
    .new-box-dialog .text-h6{
        font-family: BYekan !important;
        display: flex;
        justify-content: space-between;
    }
    .new-box-dialog .v-text-field__details{
        display: none !important;
    }
</style>

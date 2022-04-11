<template>
    <div class="widget-box" style="width:100%">
        <v-icon style="margin:20px"
              v-on:dblclick="$store.dispatch('widget/removeBox',data.id)">
            mdi-delete-outline
        </v-icon>
        <p v-on:dblclick="$store.commit('widget/show_widget_setting_box',{tag:data.tag,id:data.id})">
            {{ $store.state.widget.widgetData[data.tag]['title'] }}
        </p>

    </div>
</template>

<script>
    export default {
        name: "WidgetView",
        props:['data']
    }
</script>

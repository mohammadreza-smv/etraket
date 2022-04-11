<template>
    <div :style="[getStyle(data.id)]" class="tagView">

        <span v-on:dblclick="$store.dispatch('widget/removeBox',data.id)">
                 <v-icon>mdi-delete-outline</v-icon>
        </span>

        <div
            v-on:dblclick="$store.dispatch('widget/show_style_box',{
                     id:data.id,
                     setting_box:'slide-attribute'
                 })"
            style="border-radius: inherit;height:100%;width:100%"
        >

            <p v-if="tagData.slide[data.id]['items'][0]['src']===''">
                  برای اضافه کردن اسلاید کلیک کنید
            </p>

            <div v-else style="border-radius: inherit;height:100%;width:100%">


                <v-carousel
                    v-model="model"
                    hide-delimiter-background
                    height="100%"
                    cycle
                    class="theme-slide"
                >
                    <v-carousel-item
                        v-for="(slide,key) in tagData.slide[data.id]['items']"
                        :key="key"
                        style="width: 100%"
                    >
                        <a style="width: 100%">
                            <img
                                 :style="{backgroundImage:'url('+slide.src+')'}"
                            />
                        </a>

                    </v-carousel-item>

                </v-carousel>

            </div>

        </div>
    </div>
</template>

<script>
    import mixins from "../mixins";
    import {mapState} from "vuex";

    export default {
        name: "SlideTag",
        props:['data'],
        mixins:[mixins],
        computed:mapState('widget',[
            'style',
            'tagData'
        ]),
        data(){
            return {
                model:0,
            }
        }
    }
</script>

<style>
    .theme-slide img{
        width:100%;
        height:100%;
        background-repeat: no-repeat;
        background-position: 50%;
        background-size: cover;
    }
    .theme-slide{
        border-radius: inherit;
    }
</style>

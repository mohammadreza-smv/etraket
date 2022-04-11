<template>
    <div class="html-elements">
        <p>المان های html</p>
        <ul class="elements_ul">

            <li
                draggable="true"
                @dragstart="$store.commit('widget/dragstart',
                {
                    type:'html',
                    tag:'img',
                    defaultValue:{
                        src:'',
                        link:'',
                        hoverSrc:''
                    }
                })"
            >
                <v-icon>mdi-picture-in-picture-top-right-outline</v-icon>
                <span>تصویر</span>
            </li>

            <li
                draggable="true"
                @dragstart="$store.commit('widget/dragstart',
                {
                    type:'html',
                    tag:'card',
                    defaultValue:{
                        title:'عنوان',
                        content:'توضیحات',
                        img:'',
                        titleColor:'',
                        titlePadding:'',
                        titleSize:'',
                        contentPadding:'',
                        contentSize:'',
                        link:'',
                        icon:'',
                        iconColor:'',
                        imgWidth:'',
                        imageMargin:''
                    }
                })"
            >
                <v-icon>mdi-view-agenda-outline</v-icon>
                <span>ایتم باکس</span>
            </li>

            <li
                draggable="true"
                @dragstart="$store.commit('widget/dragstart',
                {
                    type:'html',
                    tag:'ul',
                    defaultValue:{
                        title:'',
                        titleColor:'',
                        titleSize:'',
                        titleIcon:'',
                        items:[{title:'',link:''}],
                        itemPadding:'',
                        hoverColor:''
                    }
                })"
            >
                <v-icon>mdi-format-list-bulleted-square</v-icon>
                <span>لیست</span>
            </li>

            <li
                draggable="true"
                @dragstart="$store.commit('widget/dragstart',
                {
                    type:'html',
                    tag:'code',
                    defaultValue:{
                        content:'',
                    }
                })"
            >
                <v-icon>mdi-code-not-equal-variant</v-icon>
                <span>کد html</span>
            </li>

            <li
                draggable="true"
                @dragstart="$store.commit('widget/dragstart',
                {
                    type:'html',
                    tag:'p',
                    defaultValue:{
                        content:'',
                        showMore:''
                    }
                })"
            >
                <v-icon>mdi-card-text-outline</v-icon>
                <span>پاراگراف</span>
            </li>

            <li
                draggable="true"
                @dragstart="$store.commit('widget/dragstart',
                {
                    type:'html',
                    tag:'slide',
                    defaultValue:{
                        items:[
                            {
                                title:'',
                                link:'',
                                src:''
                            }
                        ],
                    }
                })"
            >
                <v-icon>mdi-play-box-outline</v-icon>
                <span>اسلاید</span>
            </li>

        </ul>
    </div>
</template>

<script>
    export default {
        name: "HtmlElements"
    }
</script>


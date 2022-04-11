<template>

    <div class="important-item-box">
        <div v-if="items.length>0">

            <div style="display: flex;justify-content: space-between">
                <h4 style="margin-right:-15px">ویژگی های محصول</h4>
                <div class="show_more_important_item"
                     @click="$root.$emit('show_item_box')"
                     v-if="theme==='mobile'"
                > بیشتر</div>
            </div>

            <ul class="important_item_ul">
                <template v-for="item in items">

                    <template v-for="(child,key) in item['get_child']">

                        <template v-if="child.show_item==1 && child['get_value'].length>0">

                            <li>
                                <span>{{ child.title }} : </span>

                                <span>
                                <template v-for="value in child['get_value']">

                                    <template v-if="value['item_value'].length>30">
                                        <br/>
                                    </template>
                                    {{ value['item_value'] }} <br/>
                                </template>
                            </span>

                            </li>

                        </template>

                    </template>

                </template>
            </ul>

            <div v-if="more" class="show_more_important_item">

                <div @click="changeStatus()" v-if="show_more_item">
                    <v-icon>mdi-plus</v-icon>
                    <span> موارد بیشتر</span>
                </div>

                <div @click="changeStatus()" v-else>
                    <v-icon>mdi-minus</v-icon>
                    <span>موارد کمتر</span>
                </div>

            </div>

        </div>
    </div>


</template>

<script>
    export default {
        name: "ImportantItem",
        props:['theme'],
        data(){
            return {
                items:[],
                more:false,
                show_more_item:true
            }
        },
        mounted() {
            this.$root.$on('showImportant', (data) => {
                this.items=data;
                this.showItems();
            });
        },
        methods:{
            showItems:function () {
                this.$nextTick(function () {

                    const li=document.querySelectorAll('.important_item_ul li');
                    if(li.length>3 && this.theme!=='mobile'){
                        this.more=true;
                        for (let i = 0; i <li.length ; i++) {
                            if(i>3){
                                li[i].style.display='none';
                            }
                        }
                    }
                });
            },
            changeStatus:function () {
                const li=document.querySelectorAll('.important_item_ul li');
                for (let i = 0; i <li.length ; i++) {
                    if(i>3){
                        if(this.show_more_item){
                            li[i].style.display='block';
                        }
                        else{
                            li[i].style.display='none';
                        }
                    }
                }
                this.show_more_item=!this.show_more_item;
            }
        }
    }
</script>

<style>
    .show_more_important_item {
        color: #1ca2bd !important;
        cursor: pointer;
        font-weight: bold;
    }
    .important_item_ul li{
        list-style: disc !important;
    }
    .show_more_important_item .v-icon{
        color: #1ca2bd !important;
    }
    @media (max-width:960px) {
        .important-item-box{
            padding:30px;
        }
    }
</style>

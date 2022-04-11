<template>
    <div style="position: relative" class="theme-p">

        <div class="content">
            <slot></slot>
        </div>

        <p class="more-content short-content">
            <span>{{ text }}</span>
        </p>

        <div style="padding-top: 10px"></div>
    </div>
</template>

<script>
    export default {
        name: "MoreContentBox",
        props:['el_id'],
        data(){
            return {
                text:'نمایش بیشتر'
            }
        },
        mounted() {
            const self=this;
            document.querySelector('#'+this.el_id+' .more-content').addEventListener('click',function () {

                if(document.querySelector('#'+self.el_id+' .more-content span').parentElement.classList.contains('short-content')){
                    self.text='نمایش کمتر';
                    document.querySelector('#'+self.el_id+' .content').style.maxHeight='none';
                    document.querySelector('#'+self.el_id+' .more-content span').parentElement.classList.remove('short-content');
                }
                else{
                    self.text='نمایش بیشتر';
                    document.querySelector('#'+self.el_id+' .content').style.maxHeight='250px';
                    document.querySelector('#'+self.el_id+' .more-content span').parentElement.classList.add('short-content');
                }

            });

            const content=document.querySelector('#'+self.el_id+' .content');
            if(content!==undefined && content.scrollHeight<250){
                document.querySelector('#'+self.el_id+'.more-content').style.display='none';
            }
        }
    }
</script>

<style>
    @import "../theme.css";
</style>

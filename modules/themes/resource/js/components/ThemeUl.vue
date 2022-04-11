<template>
    <div :id="id">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "ThemeUl",
        props:['id','tag_id'],
        data(){
            return {
                itemPadding:'',
                hoverColor:'',
                titleColor:'',
                titleSize:''
            }
        },
        mounted() {

            this.setDefaultData();

            const hover_color=this.hoverColor;
            const lis=document.querySelectorAll('#'+this.tag_id+' li');
            const aTag=document.querySelectorAll('#'+this.tag_id+' li a');
            if(this.itemPadding!=='' && this.itemPadding!==undefined){
                for (let i = 0; i <lis.length ; i++) {
                    lis[i].style.padding=this.itemPadding;
                }
            }
            for (let i = 0; i <aTag.length ; i++) {
                aTag[i].style.color='inherit';
                if(hover_color!=='' && hover_color!==undefined){
                    aTag[i].addEventListener('mouseover', function hover() {

                        aTag[i].style.color = hover_color;

                    });
                    aTag[i].addEventListener('mouseleave', function hover() {
                        aTag[i].style.color = 'inherit';
                    });
                }

            }

            const title=document.querySelector('#'+this.tag_id+' .ul-title');
            if(title!==null){
                if(this.titleColor!=='' && this.titleColor!==undefined){
                    title.style.color=this.titleColor;
                }
                if(this.titleSize!=='' && this.titleSize!==undefined){
                    title.style.fontSize=this.titleSize;
                }
            }

            document.querySelector('#'+this.tag_id+' ul').style.padding='0px';
            document.querySelector('#'+this.tag_id+' ul').style.listStyle='none';
        },
        methods:{
            setDefaultData:function (){
                const detail=widgetData[this.tag_id];
                if(detail!==undefined){
                    const keys=Object.keys(detail);
                    for (let i = 0; i <keys.length ; i++) {
                        if(detail[keys[i]]!==''){
                            this[keys[i]]=detail[keys[i]];
                        }
                    }
                }
            }
        }
    }
</script>

<template>
    <div>
        <slot v-if="template===''"></slot>
        <dynamic-component v-else :template="template"></dynamic-component>
    </div>
</template>

<script>
    const dynamicComponent={
        template:'',
        props:['template'],
        functional:true,
        render:function (h,context) {
            let template=context.props.template;
            template='<div>'+template+'</div>';
            const component={ template };
            return h(component);
        }
    };
    export default {
        name: "PriceVariationParamsBox",
        props:['ev'],
        data(){
            return {
                template:''
            }
        },
        mounted() {
            const self=this;
            this.$root.$on(this.ev,(html)=>{
                self.template=html;
            });
        },
        components:{
            dynamicComponent
        }
    }
</script>


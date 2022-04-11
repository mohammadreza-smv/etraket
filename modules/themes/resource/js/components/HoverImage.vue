<template>

</template>

<script>
    export default {
        name: "HoverImage",
        props:['id','src'],
        data(){
           return {
               default:''
           }
        },
        mounted() {
            const img=document.querySelector('#'+this.id)
            if(img){
                const self=this;
                this.default=img.getAttribute('src');

                img.addEventListener('mouseover', function hover() {
                    img.setAttribute('src',self.src);
                });
                img.addEventListener('mouseleave', function hover() {
                    img.setAttribute('src',self.default);
                });
            }
        }
    }
</script>



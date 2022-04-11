<template>
    <div class="mobile-theme">
        <slot/>
    </div>
</template>

<script>
    export default {
        name: "Faq",
        mounted() {
            const el=document.querySelectorAll('.common_question_header .v-icon');
            for (let i = 0; i <el.length ; i++) {
                el[i].addEventListener('click',function () {
                     if( el[i].classList.contains('mdi-chevron-down')){
                         el[i].classList.add('mdi-chevron-up');
                         el[i].classList.remove('mdi-chevron-down');
                         const  small_answer=el[i].parentElement.parentElement.parentElement.getElementsByClassName('small_answer');
                         if(small_answer.length===1){
                             small_answer[0].style.display='block';
                         }
                     }
                     else{
                         el[i].classList.add('mdi-chevron-down');
                         el[i].classList.remove('mdi-chevron-up');
                         const  small_answer=el[i].parentElement.parentElement.parentElement.getElementsByClassName('small_answer');
                         if(small_answer.length===1){
                             small_answer[0].style.display='none';
                         }
                     }
                });
            }
        }
    }
</script>

<style scoped>
    @import "../mobile.css";
</style>

<template>
    <div>
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "MenuList",
    mounted() {
        this.$nextTick(function (){

            const lis=document.querySelectorAll('.blog-categories .parent-li');
            for (let i = 0; i <lis.length ; i++) {
                lis[i].addEventListener('mouseover',function (){
                    const ul=lis[i].querySelector('.child-menu');
                    if(ul){
                        ul.style.display='block';
                    }
                    lis[i].style.backgroundColor='#24a57f';
                });

                lis[i].addEventListener('mouseleave',function (){
                    const ul=lis[i].querySelector('.child-menu');
                    if(ul){
                        ul.style.display='none';
                    }
                    lis[i].style.backgroundColor='#3f3f90';
                });
            }

            const child_menu_li=document.querySelectorAll('.child-menu li');
            for (let i = 0; i < child_menu_li.length; i++) {
                child_menu_li[i].addEventListener('mouseover',function (){
                    child_menu_li[i].querySelector('a').classList.add('active-child-li');
                });
                child_menu_li[i].addEventListener('mouseleave',function (){
                    child_menu_li[i].querySelector('a').classList.remove('active-child-li');
                });
            }

        });
    }
}
</script>



<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            absolute
            temporary
            right
        >
            <slot></slot>
        </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    name: "CategoryNavigationDrawer",
    data(){
        return {
            drawer:false
        }
    },
    mounted() {
        this.$root.$on('show_navigation_drawer',()=>{
            this.drawer=true;
        });

        this.$root.$on('show_progress',()=>{
            this.drawer=false;
        });

        this.$nextTick(function (){
            const mainCats=document.querySelectorAll('.nav-parent-li .parent-link');
            for (let i = 0; i <mainCats.length ; i++) {
                mainCats[i].addEventListener('click',function (){
                    const ul=mainCats[i].parentElement.querySelector('.nav-child-cat');
                    if(ul.style.display==='block'){
                        ul.style.display='none';
                        mainCats[i].querySelector('.mdi-chevron-up')
                            .classList.add('mdi-chevron-down');
                        mainCats[i].querySelector('.mdi-chevron-up')
                            .classList.remove('mdi-chevron-up');
                    }
                    else{
                        ul.style.display='block';
                        mainCats[i].querySelector('.mdi-chevron-down')
                            .classList.add('mdi-chevron-up');
                        mainCats[i].querySelector('.mdi-chevron-down')
                            .classList.remove('mdi-chevron-down');
                    }

                });
            }

        });
    },
    watch:{
        drawer:function (value){
            if(value){
                const nav_child_menu=document.querySelectorAll('.nav-child-cat');
                for (let j = 0; j <nav_child_menu.length ; j++) {
                    nav_child_menu[j].style.display='none';
                }

                const icons=document.querySelectorAll('.nav-parent-li .v-icon');
                for (let i = 0; i <icons.length ; i++) {
                    icons[i].classList.add('mdi-chevron-down');
                    icons[i].classList.remove('mdi-chevron-up');
                }
            }
        }
    }
}
</script>


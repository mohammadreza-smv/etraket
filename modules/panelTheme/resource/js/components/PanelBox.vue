<template>
    <div>
        <v-card
            elevation="1"
            :loading="loading"
            class="panel"
            :disabled="loading"
        >
            <slot></slot>
        </v-card>
    </div>
</template>

<script>
    export default {
        name: "PanelBox",
        props:['progress_param'],
        data(){
            return {
                loading:false,
                destroy:false
            }
        },
        mounted() {
            this.$root.$on('show_progress',()=>{
                if(this.progress_param!==undefined && window.location.href.toString().indexOf(this.progress_param)>0
                    && window.location.href.toString().indexOf(this.progress_param+'/')===-1
                    && !this.destroy
                ){
                    this.$root.$emit('hide_layout_progress');
                    this.loading=true;
                }
            });
            this.$root.$on('hide_progress',(data)=>{
                if(this.progress_param!==undefined && window.location.href.toString().indexOf(this.progress_param)>0){
                    this.loading=false;
                }
            });
        },
        beforeDestroy() {
            this.destroy=true;
        }
    }
</script>



<template>
    <v-dialog
        v-model="progress"
        persistent
        max-width="400px"
    >
        <v-card  class="layout-progress">

            <v-card-text>

                <slot name="loading_box"></slot>

                <div style="padding:30px 0px 10px 0px">
                    <v-progress-linear
                        color="red darken-1"
                        indeterminate
                        rounded
                        height="6"
                    ></v-progress-linear>
                </div>


            </v-card-text>

        </v-card>
    </v-dialog>

</template>

<script>
export default {
    name: "LayoutProgress",
    data(){
        return {
            progress:false,
            run:true
        }
    },
    mounted() {

        this.$root.$on('hide_layout_progress',()=>{
            this.progress=false;
            this.run=false;
        });

        this.$root.$on('show_progress',()=>{
            if(this.run){
                this.progress=true;
            }
        });

        this.$root.$on('hide_progress',(data)=>{
            this.run=true;
            this.progress=false;
        });

    }
}
</script>


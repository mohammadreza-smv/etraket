<template>
    <div>
        <v-navigation-drawer
            width="300"
            app
            permanent
            right
            class="right_box"
            v-if="showDrawer"
        >
            <div class="login_right_box">
                <slot name="login-right-box"></slot>
            </div>
        </v-navigation-drawer>


        <v-main>
            <div class="register_form_box" style="flex-direction: column;">
                <v-card style="width:400px;text-align: center;background:transparent" elevation="0" :disabled="showLoading" >
                    <v-alert type="error" v-if="server_error">
                        {{ server_error }}
                    </v-alert>
                    <slot name="content"></slot>
                </v-card>
                <div style="margin-top:20px" v-if="showLoading">

                    <v-progress-circular
                        indeterminate
                        color="red"
                    ></v-progress-circular>

                    <span style="font-size:13px">در حال ارسال اطلاعات</span>
                </div>
            </div>
        </v-main>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data(){
            return {
                showLoading:false,
                server_error:false,
                showDrawer:true
            }
        },
        mounted() {
            this.$root.$on('show_progress',()=>{
                this.server_error=false;
                this.showLoading=true;
            });
            this.$root.$on('hide_progress',(data)=>{
                if(data!==undefined){
                    this.showLoading=false;
                    if(data['errors']!==undefined){
                        this.server_error=data['errors']['lockoutResponse'][0];
                    }
                    else if(data['message']!==undefined){
                        this.server_error=data['message'];
                    }
                }
            });
            if(window.innerWidth<1000){
                this.showDrawer=false;
            }
        },
    }
</script>



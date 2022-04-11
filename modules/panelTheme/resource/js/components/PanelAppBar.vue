<template>
    <div>
        <v-app-bar absolute color="white" elevate-on-scroll height="60">

            <v-app-bar-nav-icon @click="$root.$emit('changeNavigation')" />

            <v-toolbar-title>پنل مدیریت</v-toolbar-title>

            <v-spacer></v-spacer>

            <ul class="app-bar-ul">
                <li>
                    <v-icon @click="showDialog">mdi-logout</v-icon>
                </li>
            </ul>



        </v-app-bar>

        <v-dialog v-model="dialog" width="400">
            <v-card class="logout-dialog">
                <v-card-text>
                    <p style="font-weight: bold">آیا از خروج از پنل مدیریت مطمین هستین ؟</p>

                    <v-btn color="success" text @click="approve">
                        بله
                    </v-btn>

                    <v-btn color="error" text @click="dialog=false">
                        خیر
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    export default {
        name: "PanelAppBar",
        data(){
            return {
                dialog:false
            }
        },
        methods:{
            showDialog:function(){
                this.dialog=true;
            },
            approve:function (){
                this.dialog=false;
                this.$root.$emit('send_post_request',this.$siteUrl+'/logout',{});
            }
        }
    }
</script>


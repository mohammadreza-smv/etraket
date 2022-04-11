<template>

    <v-dialog
        v-model="dialog"
        width="450"
    >
        <v-card :loading="loading" :disabled="loading">
            <v-card-title style="font-size:16px">
                <v-btn
                    icon
                    @click="dialog = false"
                >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                نام و نام خانوادگی
            </v-card-title>

            <v-card-text style="padding-top:20px">

                <v-form   ref="form" v-model="valid">

                    <v-alert type="error" v-if="error">
                        {{ error }}
                    </v-alert>

                    <v-text-field
                        outlined
                        label="نام"
                        v-model="first_name"
                        :rules="firstNameRules"
                    >

                    </v-text-field>

                    <v-text-field
                        outlined
                        label="نام خانوادگی"
                        v-model="last_name"
                        :rules="lastNameRules"
                    >

                    </v-text-field>
                </v-form>


            </v-card-text>


            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="success"
                    @click="updateName()"
                >
                   ثبت
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "UserEditName",
        data(){
            return {
                last_name:'',
                first_name:'',
                dialog:false,
                firstNameRules: [
                    v => !!v || 'نام نمی تواند خالی باشد',
                ],
                lastNameRules: [
                    v => !!v || 'نام خانوادگی نمی تواند خالی باشد',
                ],
                valid:false,
                loading:false,
                error:false
            }
        },
        mounted() {
            this.$root.$on('edit_user_name',(value)=>{
                if(value!=='-'){
                    const name=value.toString().split('-');
                    if(name.length===2){
                        this.first_name=name[0];
                        this.last_name=name[1];
                    }
                }
                this.dialog=true;
            });
        },
        methods:{
            updateName:function () {
                this.$refs.form.validate();
                if(this.valid){
                    this.loading=true;
                    this.error=false;
                    const formData=new FormData();
                    formData.append('first_name',this.first_name);
                    formData.append('last_name',this.last_name);
                    const url=this.$siteUrl+'/user/add/register_detail';
                    this.axios.post(url,formData).then(response=>{
                        this.loading=false;
                        if(response.data==='ok'){
                            this.dialog=false;
                            this.$root.$emit('send_get_request',window.location.href);
                        }
                        else{
                            this.error='خطا در ارسال اطلاعات،مجددا تلاش نمایید';
                        }
                    }).catch(error=>{
                        this.loading=false;
                        this.error='خطا در ارسال اطلاعات،مجددا تلاش نمایید';
                    });
                }
            }
        }
    }
</script>

<style scoped>

</style>

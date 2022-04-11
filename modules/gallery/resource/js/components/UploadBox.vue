<template>
    <div>
        <vue-dropzone ref="myVueDropzone"
                      @vdropzone-success="uploadSuccess"
                      id="dropzone"
                      :options="dropzoneOptions">
        </vue-dropzone>

        <div style="margin-top:20px">

            <v-card    :loading="loading" :disabled="loading" elevation="0">
                <v-data-table
                    hide-default-footer
                    :headers="headers"
                    :items="gallery"
                    class="data-table"
                >

                    <template v-slot:item="{item,index}">

                        <tr
                            draggable="true"
                            @dragover.prevent
                            @dragstart="dragStart(index,item.id)"
                            @drop="drop(index,item.id)"
                        >
                            <td style="text-align:center">
                                {{ replaceNumber(++index) }}
                            </td>
                            <td style="text-align:center">
                                <img
                                    :src="$siteUrl+'/files/gallery/'+item.image_url" style="width:150px;margin:20px">
                            </td>
                            <td style="text-align:center">
                                <v-icon color="red" @click="removeImage(item.id,index)">
                                    mdi-delete
                                </v-icon>
                            </td>
                        </tr>

                    </template>

                </v-data-table>
            </v-card>


        </div>

        <v-dialog
            v-model="dialog"
            width="450"
        >
            <v-card>
                <v-card-text>

                    <div  class="alert-div">
                        <span>آیا از حذف این تصویر مطمئن هستین؟ </span>
                    </div>

                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="success"
                        @click="sendRequest()"
                        class="action-btn"
                        text
                    >
                        بله
                    </v-btn>

                    <v-btn
                        color="error"
                        @click="dialog = false"
                        class="action-btn"
                        text
                    >
                        خیر
                    </v-btn>


                </v-card-actions>

            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';
    export default {
        name: "UploadBox",
        props:['product_id','product_gallery','url_param'],
        components: {
            vueDropzone: vue2Dropzone
        },
        data(){
            return {
                dropzoneOptions: {
                    url:this.$siteUrl+'/'+this.url_param+'/products/gallery_upload/'+this.product_id,
                    thumbnailWidth:200,
                    maxFilesize:1,
                    acceptedFiles:'.png,.jpg,.jpeg',
                    addRemoveLinks: true,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    dictDefaultMessage:'با کشیدن فایل و انداختن در این قسمت میتواند تصاویر خود را اپلود کنید'
                },
                headers: [
                    { text: 'ردیف', align: 'center', sortable: false, value: 'row',},
                    { text: 'تصویر', value: 'img',align: 'center',sortable: false },
                    { text: 'عملیات', value: 'action',align: 'center',sortable: false }
                ],
                gallery:[],
                dialog:false,
                id:0,
                select_key:0,
                loading:false,
                startKey:'',
                endKey:'',
                startId:'',
                endId:''
            }
        },
        mounted() {
            this.gallery=this.product_gallery;
        },
        methods: {
            uploadSuccess: function (file, response) {
                if(response!==undefined)
                {
                   this.gallery.push({id:response['id'],'image_url':response['image_url']});
                }
            },
            replaceNumber: function (n) {
                if (n != undefined) {
                    n = n.toString();
                    const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                    const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                    for (let i = 0; i < find.length; i++) {
                        n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                    }
                    return n;
                }
            },
            removeImage:function (item_id,key) {
                this.id=item_id;
                this.dialog=true;
                this.select_key=(key-1);
            },
            sendRequest:function () {
                this.dialog=false;
                this.loading=true;
                const url=this.$siteUrl+'/'+this.url_param+'/products/gallery/'+this.id+'/'+this.product_id;
                this.axios.delete(url).then(
                    response=>{
                        if(response.data.status==='ok'){
                            this.$root.$emit('showResponse','حذف با موفقیت انجام شد','success');
                        }
                        else{
                            this.$root.$emit('showResponse','خطا در اجرای درخواست،مجددا تلاش نمایید','error');
                        }
                        this.loading=false;
                        this.$delete(this.gallery,this.select_key);
                        delete this.gallery[this.select_key];
                    }
                ).catch(error=>{
                    this.$root.$emit('showResponse','خطا در اجرای درخواست،مجددا تلاش نمایید','error');
                    this.loading=false;
                });
            },
            dragStart:function (index,id) {
                this.startKey=index;
                this.startId=id;
            },
            drop:function (index,id) {
                this.endKey=index;
                this.endId=id;
                this.loading=true;
                const url=this.$siteUrl+'/'+this.url_param+'/products/change_images_status/'+this.id+'/'+this.product_id;
                this.axios.post(url,{
                    'position1':this.startKey,
                    'position2':this.endKey,
                    'id1':this.startId,
                    'id2':this.endId
                }).then(
                    response=>{
                        if(response.data==='ok'){
                            this.$root.$emit('showResponse','درخواست با موفقیت انجام شد','success');
                            this.gallery.splice((this.endKey-1),0,this.gallery.splice((this.startKey-1),1)[0]);
                        }
                        else{
                            this.$root.$emit('showResponse','خطا در اجرای درخواست،مجددا تلاش نمایید','error');
                        }
                        this.loading=false;
                    }
                ).catch(error=>{
                    this.$root.$emit('showResponse','خطا در اجرای درخواست،مجددا تلاش نمایید','error');
                    this.loading=false;
                });
            }
        }
    }
</script>

<style>
    .vue-dropzone{
        font-family:inherit !important;
    }
</style>

<template>

    <div style="padding:20px">

        <v-card :loading="loading" :disabled="loading">

           <v-container>

               <v-row>
                   <v-col cols="3" class="folder-list">

                       <v-list dense color="transparent">
                           <v-list-item-group
                               v-model="selectedItem"
                               color="primary"
                           >
                               <v-list-item
                                  v-for="(dir,key) in dirList"
                                  :key="key"
                                  @click="getFileList(dir)"
                               >
                                   <v-list-item-icon>
                                       <v-icon>mdi-folder-outline</v-icon>
                                   </v-list-item-icon>

                                   <v-list-item-content>
                                       <v-list-item-title v-text="dir"></v-list-item-title>
                                   </v-list-item-content>

                               </v-list-item>

                           </v-list-item-group>
                       </v-list>

                   </v-col>

                   <v-col cols="9"  style="height:500px;overflow: auto;padding:0px">

                       <v-toolbar dense elevation="1">
                           <v-text-field
                               outlined
                               hide-details
                               dense
                               placeholder="جست و جو ..."
                               style="max-width:250px"
                               v-model="searchFile"
                           ></v-text-field>
                           <v-spacer></v-spacer>
                           <v-icon @click="showUploadBox()">mdi-upload</v-icon>
                       </v-toolbar>

                       <div class="file-list">
                           <template v-for="(file,key) in fileList">
                               <div style="position: relative" v-if="checkImage(file) && file.toString().indexOf(searchFile)>-1">
                                   <v-icon color="red"
                                           style="position: absolute;z-index:100"
                                           @click="removeImage(dir+'/'+selectDir+'/'+file,key)"
                                   >
                                       mdi-delete-outline
                                   </v-icon>
                                   <v-img
                                       cover
                                       max-height="80"
                                       max-width="80"
                                       :src="$siteUrl+'/'+dir+'/'+selectDir+'/'+file"
                                       @click="showImage($siteUrl+'/'+dir+'/'+selectDir+'/'+file)"
                                   ></v-img>

                               </div>
                           </template>
                       </div>
                   </v-col>

               </v-row>

           </v-container>

        </v-card>

        <v-dialog
            v-model="dialog"
            width="800"
        >

            <v-card>

                <v-text-field :value="imagePath" solo class="url-input"></v-text-field>
                <v-card-text>

                   <div style="display:flex;justify-content: center;padding:20px">
                       <img
                           :width="imageWidth"
                           :src="imagePath"
                           @load="setImageWidth"
                       ></img>
                   </div>

                </v-card-text>

            </v-card>

        </v-dialog>

        <v-dialog v-model="uploadBox" width="450px">
            <v-card :loading="uploadLoading" :disabled="uploadLoading">
                <v-card-text style="padding:30px 20px">

                    <div style="padding:10px" v-if="fileUpload">

                        <v-icon color="green" size="25">mdi-check</v-icon>
                        <span>فایل انتخابی با نام {{  fileUpload }} اپلود شد</span>

                    </div>

                    <ul v-if="errors!==undefined && errors.length>0" class="error_ul">
                        <li v-for="e in errors" class="error-li">
                            <span>{{ e }}</span>
                        </li>
                    </ul>

                    <v-file-input
                        v-model="file"
                        color="red"
                        placeholder="انتخاب فایل"
                        prepend-icon="mdi-paperclip"
                        outlined
                    >
                    </v-file-input>

                    <v-btn color="success" @click="uploadFile()">اپلود فایل</v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog
            v-model="deleteDialog"
            width="450"
        >
            <v-card>
                <v-card-text>

                    <div class="alert-div">
                        <span>آیا از حذف فایل انتخابی </span>
                        <span>مطمئن هستین؟ </span>
                    </div>

                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>

                    <v-spacer></v-spacer>

                    <v-btn
                        color="success"
                        @click="deleteFile()"
                        class="action-btn"
                        text
                    >
                        بله
                    </v-btn>

                    <v-btn
                        color="error"
                        @click="deleteDialog = false"
                        class="action-btn"
                        text
                    >
                        خیر
                    </v-btn>


                </v-card-actions>

            </v-card>
        </v-dialog>

        <v-snackbar
            v-model="snackbar"
            :timeout="3000"
        >
            {{ deleteMessage }}
        </v-snackbar>
    </div>

</template>

<script>
    export default {
        name: "FileManager",
        data(){
            return {
                selectedItem:null,
                loading:false,
                dirList:[],
                fileList:false,
                selectDir:'',
                dialog:false,
                deleteDialog:false,
                imagePath:'',
                imageWidth:'70%',
                uploadBox:false,
                uploadLoading:false,
                file:null,
                errors:[],
                errorMessage:'',
                fileUpload:'',
                searchFile:'',
                deletePath:'',
                deleteFileKey:'',
                deleteMessage:'',
                snackbar:false
            }
        },
        props:['dir'],
        mounted() {
            this.getDirList();
        },
        methods:{
            getDirList:function () {
                this.loading=true;
                const url=this.$siteUrl+'/admin/filemanager/dirList/'+this.dir;
                this.axios.get(url).then(response=>{
                    this.loading=false;
                    this.dirList=response.data;
                })
                .catch(error=>{
                    this.loading=false;
                })
            },
            getFileList:function (dirName) {
                this.loading=true;
                this.selectDir=dirName;
                this.deleteFileKey='';
                const path=this.dir+"/"+dirName;
                const url=this.$siteUrl+'/admin/filemanager/fileList';
                this.axios.post(url,{'path':path}).then(response=>{
                    this.loading=false;
                    this.fileList=response.data;
                    const self=this;
                    setTimeout(function () {
                        self.$forceUpdate();
                    },300);
                })
                .catch(error=>{
                    this.loading=false;
                })
            },
            checkImage:function (file) {
                if(file.toString().indexOf('.png')>-1 ||
                    file.toString().indexOf('.jpg')>-1 ||
                    file.toString().indexOf('.jpeg')>-1 ||
                    file.toString().indexOf('.gif')>-1 ||
                    file.toString().indexOf('.svg')>-1
                ){
                    return true;
                }
                else {
                    return false;
                }
            },
            showImage:function (path) {
                this.imagePath=path;
                this.dialog=true;

            },
            setImageWidth:function (el) {
                const selected_img=el.target;
                if(selected_img.naturalHeight>selected_img.naturalWidth)
                {
                     this.imageWidth='60%';
                }
                else if(selected_img.naturalWidth>600 && selected_img.naturalHeight<720)
                {
                    this.imageWidth='100%';
                }
                else if(selected_img.naturalWidth<250){
                    this.imageWidth='auto';
                }
                else{
                    this.imageWidth='70%';
                }
            },
            uploadFile:function () {
                this.errors=[];
                this.fileUpload='';
                if(this.file!==''){
                    this.uploadLoading=true;
                    const url=this.$siteUrl+'/admin/filemanager/upload';
                    const formData=new FormData();
                    formData.append('file',this.file);
                    formData.append('dir',this.dir+'/'+this.selectDir);
                    this.axios.post(url,formData,{
                        headers:{
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response=>{
                        this.uploadLoading=false;
                        if(response.data.status==='success'){
                            this.fileUpload=response.data.fileName;
                            this.file=null;
                        }
                        else{
                            this.errors.push('خطا در اجرای درخواست،مجددا تلاش نمایید');
                        }

                    }).catch(error=>{
                        if(error.response.status===422 && error.response.data!==undefined && error.response.data['errors']!==undefined){
                            const keys=Object.keys(error.response.data['errors']);
                            for (let i = 0; i <keys.length ; i++) {
                                if(error.response.data['errors'][keys[i]][0]!==undefined){
                                    this.errors.push(error.response.data['errors'][keys[i]][0]);
                                }
                            }
                        }
                        else{
                            this.errors.push('خطا در اجرای درخواست،مجددا تلاش نمایید');
                        }
                        this.uploadLoading=false;
                    });
                }
            },
            showUploadBox:function () {
                if(this.selectDir!=='')
                {
                    this.uploadBox=true;
                }
            },
            removeImage:function (path,key) {
                this.deleteDialog=true;
                this.deletePath=path;
                this.deleteFileKey=key;
            },
            deleteFile:function () {
                this.loading=true;
                this.deleteDialog=false;
                const url=this.$siteUrl+'/admin/filemanager/removeFile';
                const formData=new FormData();
                formData.append('path',this.deletePath);
                this.axios.post(url,formData).then(response=>{
                    this.loading=false;
                    this.snackbar=false;
                    let msg='خطا در اجرای درخواست،مجددا تلاش نمایید';
                    if(response.data==='ok'){
                        if(this.deleteFileKey!==''){
                            this.$delete(this.fileList,this.deleteFileKey);
                            msg='حذف با موفقیت انجام شد';
                        }
                    }
                    this.deleteMessage=msg;

                }).catch(error=>{
                    this.loading=false;
                    this.deleteMessage='خطا در اجرای درخواست،مجددا تلاش نمایید';
                    this.snackbar=false;
                });
            }
        }
    }
</script>

<style>
    .folder-list{
        background-color: rgba(245, 245, 245, 0.69);
        min-height:500px;
    }
    .file-list{
        display: flex;
        flex-wrap: wrap;
    }
    .file-list div{
        width:100px;
        height:100px;
        margin:10px auto;
        display: block;
        cursor:pointer;
    }
    .url-input .v-text-field__slot input{
        text-align: left !important;
    }
</style>

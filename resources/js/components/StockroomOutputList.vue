<template>
     <div>
         <div class="loading_box2" v-if="show_loading">
            <div class="spinner">
                <div class="b1"></div>
                <div class="b2"></div>
                <div class="b3"></div>
            </div>
         </div>
         <div class="alert alert-warning" v-if="errors.length>0">
             <ul class="error_ul">
                 <li v-for="(msg,key) in errors" v-bind:key="key">
                     {{ msg }}
                 </li>
             </ul>
         </div>
         <div style="padding-bottom:20px">
             <div class="form-group">
                 <label for="stockroom">انتخاب انبار</label>
                 <select id="stockroom" v-model="stockroom_id" class="selectpicker">
                     <option value="0">انتخاب انبار</option>
                     <option v-for="row in stockroom" v-bind:key="row.id" v-bind:value="row.id">{{ row.name }}</option>
                 </select>
             </div>
             <div class="form-group">
                 <textarea v-model="tozihat" placeholder="توضیحات" style="width:100%;height:170px" class="form-control"></textarea>
             </div>

             <a data-toggle="modal" data-target=".product_list" class="alert alert-success select_product_btn" >
                 افزودن محصول
             </a>
         </div>

         <p style="margin-top:30px;margin-bottom:20px">محصولات انتخاب شده</p> 
         <table class="table table-bordered">
             <thead>
                 <tr>
                     <th>ردیف</th>
                     <th>تصویر محصول</th>
                     <th>عنوان محصول</th>
                     <th>فروشنده</th>
                     <th>گارانتی</th>
                     <th>رنگ</th>
                     <th>تعداد</th>
                     <th>عملیات</th> 
                 </tr>
             </thead>
             <tbody>
                 <tr v-for="(item,key) in selected_product" v-bind:key="key">
                      <td>
                         {{ getRow(key) }}
                      </td>
                      <td>
                           <img v-bind:src="$siteUrl+'/files/thumbnails/'+item.get_product_warranty.get_product.image_url" class="product_pic stockroom_product">
                      </td>
                      <td>
                           <span>{{ item.get_product_warranty.get_product.title }}</span>
                      </td>
                      <td>
                            <span>{{ item.get_product_warranty.get_seller.brand_name }}</span>
                      </td>
                      <td style="font-size:14px">
                            <span>{{ item.get_product_warranty.get_warranty.name }}</span>
                      </td>
                      <td style="width:150px">
                            <span v-if="item.get_product_warranty.get_color.id>0" :style="[{ background:'#'+item.get_product_warranty.get_color.code }]" class="color_td">
                                 <span style="color:white">{{ item.get_product_warranty.get_color.name}}</span>
                            </span>
                      </td>
                      <td style="width:70px">
                            <input type="text" v-model="selected_product[key].product_number" placeholder="تعداد"  class="form-control" style="width:70px;text-align:center">
                       </td>
                       <td style="width:100px">
                            <span class="remove_item" v-on:click="removeOfList(key)">حذف</span>
                       </td>
                  </tr>
                  <tr v-if="selected_product.length==0">
                      <td colspan="8">هیچ محصولی انتخاب نشده</td>
                  </tr>
             
             </tbody>
         </table> 

         <button class="btn btn-success" style="border-radius:0px" v-on:click="send_data()">
             ثبت نهایی
         </button>
         <div class="modal fade product_list" role="modal">
             <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                      <div class="loading_box2" v-if="get_data">
                         <div class="spinner">
                           <div class="b1"></div>
                           <div class="b2"></div>
                           <div class="b3"></div>
                         </div>
                      </div>

                     <div class="box_header">
                         <div class="input_div">
                             <input type="text" class="form-control" v-model="search_text" placeholder="نام محصول .."><a class="btn btn-primary" v-on:click="getList(1)" style="color:white">جست و جو</a>
                         </div>

                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div> 
                     <table class="table table-bordered">
                         <tbody>
                             <tr v-for="(item,key) in ProductList.data" v-bind:key="key">
                                 <td>
                                     {{ getRow(key) }}
                                 </td>
                                 <td>
                                     <img v-bind:src="$siteUrl+'/files/thumbnails/'+item.get_product_warranty.get_product.image_url" class="product_pic stockroom_product_pic">
                                 </td>
                                 <td>
                                     <span>{{ item.get_product_warranty.get_product.title }}</span>
                                 </td>
                                 <td>
                                     <span>{{ item.get_product_warranty.get_seller.brand_name }}</span>
                                 </td>
                                 <td style="font-size:14px">
                                     <span>{{ item.get_product_warranty.get_warranty.name }}</span>
                                 </td>
                                 <td style="width:150px">
                                     <span v-if="item.get_product_warranty.get_color.id>0" :style="[{ background:'#'+item.get_product_warranty.get_color.code }]" class="color_td">
                                         <span style="color:white">{{ item.get_product_warranty.get_color.name}}</span>
                                     </span>
                                 </td>
                                 <td style="width:70px">
                                     <input type="text" v-model="product_count[key]" placeholder="تعداد"  class="form-control" style="width:70px;text-align:center">
                                 </td>
                                 <td style="width:130px">
                                     <span v-if="checkInList(item.id)" style="color:#ef5661">اضافه شد</span>
                                     <span v-else class="select_item" v-on:click="add_product(item.get_product_warranty.id,key)">افزودن به لیست</span>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                     <pagination :data="ProductList" @pagination-change-page="getList"></pagination>

                 </div>
             </div>
         </div>


         <div class="message_div" v-if="show_messag_box" style="display:block">
           <div class="message_box">
            <p id="msg">{{msg }}</p>
            <a class="alert alert-success" v-on:click="add_product_to_stockroom()">بله</a>
            <a class="alert alert-danger" v-on:click="show_messag_box=false">خیر</a>
          </div>
        </div>

     </div>
</template>
<script>
import myMixin from '../myMixin';
export default({
    name:"StockroomOutputList",
    props:['stockroom'],
    mixins:[myMixin],
    data(){
        return {
            stockroom_id:0,
            tozihat:'',
            ProductList:{data:[]},
            page:1,
            product_count:[],
            selected_product:[],
            show_messag_box:false,
            select_id:0,
            select_key:0,
            msg:'ایا از خروج این محصول از انبار مطمئن هستین؟',
            get_data:false,
            search_text:'',
            errors:[],
            show_loading:false
        }
    },
    methods:{
        getList:function(page=1)
        {
            this.page=page;
            this.get_data=true;
            const url=this.$siteUrl+"/admin/stockroom/getInventory?page="+page+'&search_text='+this.search_text+"&stockroom_id="+this.stockroom_id;
            this.axios.get(url).then(response=>{
                for(let i=0;i<response.data.data.length;i++)
                {
                    this.product_count[i]=response.data.data[i].product_count;
                }
                this.ProductList=response.data;
                this.get_data=false;
            }).catch(error=>{
                this.get_data=false;
            })
        },
        getRow:function(key)
        {
            ++key;
            let k=(this.page-1)*5;
            k=k+key;
            return this.replaceNumber(k);
        },
        checkInList:function(id)
        {
            let result=false;
            this.selected_product.forEach(function(row){
                if(row.id==id)
                {
                    result=true;
                }
            });
            return result;
        },
        add_product:function(id,key)
        {
            this.show_messag_box=true;
            this.select_id=id;
            this.select_key=key;
        },
        add_product_to_stockroom:function(){
             this.show_messag_box=false;
             const n=this.product_count[this.select_key];
             const maxCount=this.ProductList.data[this.select_key].product_count;
             if(parseInt(n)>0)
             {
                 const count= n<=maxCount ? n : maxCount;
                 let item=this.ProductList.data[this.select_key];
                 item.product_number=count;
                 this.selected_product.push(item);
             }
        },
        removeOfList:function(key){
            this.$delete(this.selected_product,key);
        },
        send_data:function()
        {
            this.errors=[];
            let send=true;
            if(this.stockroom_id==0)
            {
                send=false;
                this.errors.push('لطفا انبار ارسال محصول را انتخاب نمایید');
            }
            if(this.selected_product.length==0)
            {
                send=false;
                this.errors.push('لطفا محصولاتی که باید به انبار اضافه شود را انتخاب نمایید');
            }
            if(send)
            {
                this.show_loading=true;
                let string='';
                this.selected_product.forEach(function(row){
                    string=string+"@"+row.get_product_warranty.id+"_"+row.product_number;
                });
                const url=this.$siteUrl+"/admin/stockroom/add_product";
                const formData=new FormData();
                formData.append('list',string);
                formData.append('stockroom_id',this.stockroom_id);
                formData.append('tozihat',this.tozihat);
                formData.append('type',"output");
                this.axios.post(url,formData).then(response=>{
                    this.show_loading=false;
                    if(response.data=='ok')
                    {
                        window.location=this.$siteUrl+"/admin/stockroom/output";
                    }
                    else{
                        $("#server_error_box").show();
                        setTimeout(function(){
                            $("#server_error_box").hide();
                        },5000);
                    }
                }).catch(error=>{
                    this.show_loading=false;
                    $("#server_error_box").show();
                    setTimeout(function(){
                        $("#server_error_box").hide();
                    },5000);
                });
            }
        }
    },
    watch:{
        stockroom_id:function(){
            this.getList();
        }
    }
   
})
</script>
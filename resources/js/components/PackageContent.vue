<template>
  <div>
    <div class="loading_box2" v-if="show_loading">
      <div class="spinner">
        <div class="b1"></div>
        <div class="b2"></div>
        <div class="b3"></div>
      </div>
    </div>
    <div class="search_form order_search">
      <input
        type="text"
        v-model="title"
        placeholder="عنوان محصول"
        class="form-control"
        style="margin-left:20px"
      />
    </div>
    <div class="tozihat" v-if="this.seller_tozihat.trim().length>0">
      <span>توضیحات فروشنده</span>
      <span v-html="this.seller_tozihat"></span>
    </div>
    <div class="form-group">
      <textarea
        v-model="tozihat"
        placeholder="توضیحات"
        style="width:100%;height:170px"
        class="form-control"
      ></textarea>
    </div>
    <div class="form-group">
      <label>وضعیت محموله</label>
      <select v-model="package_status" class="selectpicker auto_width">
        <option value="-2">ارسال ناقص</option>
        <option value="-1">عدم ارسال</option>
        <option value="1">ارسال شده</option>
        <option value="0">آماده ارسال</option>
      </select>
    </div>
    <div class="form-group">
      <label>انبار ارسال محموله</label>
      <span>{{ stockroom }}</span>
    </div>
    <p>محصولات انتخاب شده</p>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ردیف</th>
          <th>تصویر محصول</th>
          <th>عنوان محصول</th>
          <th>گارانتی</th>
          <th>رنگ</th>
          <th>تعداد</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row,key) in getProductList" :key="key">
          <td>{{ getRow(key) }}</td>
          <td>
            <img
              v-bind:src="$siteUrl+'/files/thumbnails/'+row.get_product_warranty.get_product.image_url"
              class="product_pic stockroom_product"
            />
          </td>
          <td>
            <span>{{ row.get_product_warranty.get_product.title }}</span>
          </td>
          <td>{{ row.get_product_warranty.get_warranty.name }}</td>
          <td style="width:150px">
            <span
              v-if="row.get_product_warranty.get_color.id>0"
              :style="[{ background:'#'+row.get_product_warranty.get_color.code }]"
              class="color_td"
            >
              <span style="color:white">{{ row.get_product_warranty.get_color.name}}</span>
            </span>
          </td>
          <td style="width:140px">
            <input
              type="text"
              v-model="row.product_count"
              placeholder="تعداد"
              class="form-control"
              style="width:70px;text-align:center"
            />
            <div
              style="color:red;font-size:14px;padding-top:10px"
              v-if="row.real_count!=null && row.real_count!=row.product_count"
            >
              <span>تعداد دریافت شده توسط انباردار</span> :
              <span>{{ replaceNumber(row.real_count) }}</span>
            </div>
          </td>
        </tr>
        <tr v-if="list.length==0">
          <td colspan="6">رکوردی یافت نشد</td>
        </tr>
      </tbody>
    </table>
    <div class="form-group">
      <input type="checkbox" v-model="addProduct" /> افزودن محصولات به انبار
    </div>
    <button class="btn btn-success" style="border-radius:0px" v-on:click="send_data()">ثبت نهایی</button>
  </div>
</template>

<script>
import myMinix from "../myMixin";
export default {
  mixins: [myMinix],
  data() {
    return {
      title: "",
      list: [],
      send: true,
      show_loading: false,
      tozihat: "",
      package_status: 0,
      addProduct: false
    };
  },
  props: [
    "package_id",
    "stockroom_id",
    "seller_tozihat",
    "status",
    "stockroom"
  ],
  mounted() {
    this.package_status = this.status;
    this.getList();
  },
  methods: {
    getList: function() {
      this.show_loading = true;
      const url =
        this.$siteUrl + "/admin/package/getContent/" + this.package_id;
      this.axios
        .get(url)
        .then(response => {
          this.show_loading = false;
          this.list = response.data;
        })
        .catch(error => {
          this.show_loading = false;
          $("#server_error_box").show();
          setTimeout(function() {
            $("#server_error_box").hide();
          }, 5000);
        });
    },
    getRow: function(key) {
      key = key + 1;
      return this.replaceNumber(key);
    },
    send_data: function() {
      if (this.send) {
        this.send = false;
        let string = "";
        this.list.forEach(function(row) {
          if (parseInt(row.product_count) > 0) {
            string = string + "@" + row.warranty_id + "_" + row.product_count;
          }
        });
        const url = this.$siteUrl + "/admin/package/stockroom/add_product";
        const formData = new FormData();
        formData.append("list", string);
        formData.append("stockroom_id", this.stockroom_id);
        formData.append("addProduct", this.addProduct);
        formData.append("package_id", this.package_id);
        formData.append("tozihat", this.tozihat);
        formData.append("status", this.package_status);
        this.axios
          .post(url, formData)
          .then(response => {
            this.show_loading = false;
            if (response.data == "ok") {
              window.location = this.$siteUrl + "/admin/stockroom/input";
            } else if (response.data == "add") {
              window.location = this.$siteUrl + "/admin/packages";
            } else {
              this.send = true;
              $("#server_error_box").show();
              setTimeout(function() {
                $("#server_error_box").hide();
              }, 5000);
            }
          })
          .catch(error => {
            this.send = true;
            this.show_loading = false;
            $("#server_error_box").show();
            setTimeout(function() {
              $("#server_error_box").hide();
            }, 5000);
          });
      }
    }
  },
  computed: {
    getProductList() {
      return this.list.filter(item => {
        return (
          item.get_product_warranty.get_product.title.indexOf(this.title) > -1
        );
      });
    }
  }
};
</script>

<style>
</style>
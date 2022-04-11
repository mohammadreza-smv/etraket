export default {
    methods:{
        searchAddress:function () {
            if(!this.searchRequest){
                const text=this.newSearchText==='' ? this.searchText : this.newSearchText;
                if(text.length>0){

                    this.searchAddressLoading=true;
                    this.searchRequest=true;
                    const url ="https://map.ir/search/v2/autocomplete?text="+text+"&x-api-key="+this.apiKey+"&\$select=roads,poi";

                    this.axios.get(url).then(response=>{
                        this.searchRequest=false;
                        this.searchAddressLoading=false;
                        if(response.data!==undefined){
                            this.areas=response.data.value;
                        }
                        this.closeSearchBox=false;
                    }).catch(error=>{
                        this.searchRequest=false;
                        this.searchAddressLoading=false;
                    });
                }
            }
            else{
                this.newSearchText=this.searchText;
            }
        },
        setLocation:function (area) {
            const latLng=area.geom.coordinates;
            this.center=[latLng[1],latLng[0]];
            this.center2=[latLng[1],latLng[0]];
            this.closeSearchBox=true;
        },
        setLocation2:function (area) {
            const latLng=area.geom.coordinates;
            this.center=[latLng[1],latLng[0]];
            this.center2=[latLng[1],latLng[0]];
            this.searchBox=false;
            this.step=1;
            this.$nextTick(function () {
                this.show_address_dialog=true;
            });
        },
        get_my_location:function () {
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(this.set_my_location);
            }
        },
        set_my_location:function (position) {
            let lat=position.coords.latitude;
            let lng=position.coords.longitude;
            this.center=[lat,lng];
            this.center2=[lat,lng];
        },
        set_address_detail:function () {
            if(this.step===1){
                this.step=2;
                if(this.getAddressDetail){
                    this.getAddressDetail=false;
                    this.getAddress();
                }
            }
            else{
                this.add_address();
            }
        },
        getAddress:function () {
            const lat=this.center2[0];
            const lon=this.center2[1];
            var url ="https://map.ir/reverse/no?lat="+lat+"&lon="+lon+"&x-api-key="+this.apiKey;
            this.axios.get(url).then(response=>{
                if(response.data!==undefined){
                    this.address=response.data.address;
                }
            });
        },
        getProvince() {
            this.city_select=null;
            this.city_id=null;
            this.axios.get(this.$siteUrl+'/api/app/provinces').then(response=>{
                this.province=response.data.original;
            });
        },
        getCity:function (province,province_id) {
            this.province_id=province_id===undefined ? province['id'] : province_id;
            this.city=[];
            this.axios.get(this.$siteUrl+'/api/get_city/'+this.province_id).then(response=>{
                this.city=response.data.original;
                if(this.city_id>0){
                    for (let i = 0; i < this.city.length ; i++) {
                        if(this.city[i]['id']===this.city_id){
                            this.city_select=this.city[i]['name'];
                        }
                    }
                }
            });
        },
        set_city_id:function(city){
            if(city['id']!==undefined){
                this.city_id=city['id'];
            }
        },
        add_address:function () {
            this.$refs.form.validate();
            if(this.valid)
            {
                this.loading=true;
                const lat=this.center2[0]
                const lng=this.center2[1];

                const formData=new FormData();
                formData.append('id',this.id);
                formData.append('name',this.name);
                formData.append('mobile',this.mobile);
                formData.append('address',this.address);
                formData.append('zip_code',this.zip_code);
                formData.append('city_id',this.city_id);
                formData.append('province_id',this.province_id);
                formData.append('lat',lat);
                formData.append('lng',lng);
                formData.append('paginate',this.get_page);
                const url=this.$siteUrl+'/user/addAddress';
                this.server_error=false;
                this.axios.post(url,formData).then(response=>{
                    this.loading=false;
                    if(response.data!=="error")
                    {
                        this.$emit('setData',response.data);
                        this.loading=false;
                        this.show_address_dialog=false;
                    }
                    else {
                        this.server_error=true;
                    }
                }).catch(error=>{
                    this.loading=false;
                    this.server_error=true;
                });
            }
        },
        validateMobileNumber:function (val) {
            if(val.toString().trim()==="")
            {
                return 'لطفا شماره موبایل خود را وارد نمایید';
            }
            else if(this.check_mobile_number())
            {
                return 'شماره موبایل وارد شده معتبر نمی باشد';
            }
            else{
                return  true;
            }
        },
        validateZipCode:function (val) {
            if(val.toString().trim().length<10 || isNaN(this.zip_code) || this.zip_code.toString().trim().length>10)
            {
                return 'کد پستی معتبر نمی باشد';
            }
            else{
                return  true;
            }
        },
        validateProvince:function () {
            if(this.province_id.toString().trim()=="")
            {
                this.error_province_id_message='لطفا استان را انتخاب کنید';
                return false;
            }
            else{
                this.error_province_id_message=false;
                return  true;
            }
        },
        validateCity:function () {
            if(this.city_id.toString().trim()=="")
            {
                this.error_city_id_message='لطفا شهر را انتخاب کنید';
                return false;
            }
            else{
                this.error_city_id_message=false;
                return  true;
            }
        },
        showModalBox: function () {
            this.$refs.data.setTitle('افزودن آدرس جدید');
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
        changeMorkerPosition:function(){
            const latlng=this.$refs.myMap.mapObject.getCenter();
            this.center2=[latlng.lat,latlng.lng];
        },
        updateRow: function (address) {
            this.$refs.data.setUpdateData(address, 'ویرایش آدرس');
        },
        remove_address: function (address) {
            this.remove_address_id = address.id;
            this.show_dialog_box = true;
        },
        delete_address: function (paginate) {
            const string = paginate == undefined ? '' : "?paginate=ok";
            this.loading=true;
            this.show_dialog_box = false;
            const url = this.$siteUrl + "/user/removeAddress/" + this.remove_address_id + string;
            this.axios.delete(url).then(response => {
                this.loading=false;
                if (response.data !== "error") {
                    this.AddressLists = response.data;
                }
            }).catch(error => {
                this.loading=false;
            });
        },
        hide_transition_box: function () {
            this.show_box = false;
            $('body').css('overflow-y', 'auto');
        },
        check_mobile_number() {
            if (isNaN(this.mobile)) {
                return true;
            }
            else {
                if (this.mobile.toString().trim().length === 11) {
                    if (this.mobile.toString().charAt(0) === '0' && this.mobile.toString().charAt(1) === '9') {
                        return false;
                    } else {
                        return true;
                    }
                } else if (this.mobile.toString().trim().length === 10) {
                    if (this.mobile.toString().charAt(0) === '9') {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            }
        }
    }
}

export default {
    methods:{
        get_content_width:function () {
            if(this.$store.state.widget.page_width==''){
                let width=document.body.offsetWidth;
                width=width-60;
                if(this.$store.state.widget.show_right_box){
                    width=(3*width)/4;
                }
                width=parseInt(width);
                this.$store.state.widget.page_width=width;
                this.$store.state.widget.inputPageWidth=width;
                return width;
            }
            else{
                return this.$store.state.widget.page_width;
            }
        },
        newLine:function () {
            this.$store.state.widget.BoxLabel='افزودن سطر جدید';
            this.$store.state.widget.boxTitle='';
            this.$store.state.widget.newBoxError=false;
            this.$store.state.widget.parentId=0;
            this.$store.commit('widget/changeNewBoxDialogStatus');
        },
        addNewLine:function () {
            if(this.validateBoxName()){
                this.$store.commit('widget/addNewRow',this.$store.state.widget.boxTitle);
                this.setAppBoxHeight();
            }
        },
        newBox:function(parentId,key){
            this.$store.state.widget.BoxLabel='افزودن باکس جدید';
            this.$store.state.widget.boxTitle='';
            this.$store.state.widget.newBoxError=false;
            this.$store.state.widget.parentId=parentId;
            this.$store.state.widget.parentKey=key;
            this.$store.commit('widget/changeNewBoxDialogStatus');
        },
        addChildBox:function(key,parentId){
            this.$store.state.widget.BoxLabel='افزودن باکس جدید';
            this.$store.state.widget.boxTitle='';
            this.$store.state.widget.newBoxError=false;
            this.$store.state.widget.parentId=parentId;
            this.$store.state.widget.parentKey=key;
            this.$store.commit('widget/changeNewBoxDialogStatus');
        },
        addNewBox:function(){
            if(this.validateBoxName()){
                this.$store.commit('widget/addNewBox',{
                    parentId:  this.$store.state.widget.parentId,
                    title:this.$store.state.widget.boxTitle,
                    parentKey:this.$store.state.widget.parentKey
                });
            }
        },
        checkHasRow:function(id){
            let result=false;
            const keys=Object.keys(this.$store.state.widget.style);
            for (let i=0;i<keys.length;i++){
                if(keys[i].toString().trim()==id.toString().trim()){
                    result=true;
                }
            }
            return result;
        },
        setAppBoxHeight:function () {

            setTimeout(function () {
                const min_height=document.documentElement.scrollHeight;
                document.getElementById('app').style.minHeight=min_height+'px';
            },200);

        },
        validateBoxName:function () {
            const en = /^[A-Za-z0-9_]*$/;
            let result=false;
            if(this.$store.state.widget.boxTitle.trim()==""){
                this.$store.state.widget.newBoxError="لطفا شناسه را وارد نمایید";
            }
            else {
                if(en.test(this.$store.state.widget.boxTitle)){
                    if(!this.checkHasRow(this.$store.state.widget.boxTitle)){
                        result=true;
                    }
                    else {
                        this.$store.state.widget.newBoxError="شناسه وارد شده تکراری می باشد";
                    }
                }
                else{
                    this.$store.state.widget.newBoxError="شناسه وارد شده باید دارای کاراکتر های انگلیسی باشد";
                }
            }
            return result;
        },
        getStyle:function (id) {

           const style=this.defaultStyle(id);
           const page_width=this.$store.state.widget.page_width;
           const responsiveStyle=this.$store.state.widget.responsiveStyle;
           const keys=Object.keys(responsiveStyle);
           for (let i=0;i<keys.length;i++){
                if(this.checkAddResponsiveStyle(keys[i],id))
                {
                   const responsive_key=keys[i].toString().split('_');
                   const rStyle=responsiveStyle[keys[i]];
                   const styleKey=Object.keys(rStyle);
                   if(responsive_key[0]=='min'){
                       if(page_width>=responsive_key[(responsive_key.length-1)]){
                           for (let j=0;j<styleKey.length;j++){
                               if(rStyle[styleKey[j]]!='' && styleKey[j]!='type'){
                                   style[styleKey[j]]=rStyle[styleKey[j]];
                               }
                           }
                       }
                   }
                   else if(responsive_key[0]=='max'){
                       if(page_width<=responsive_key[(responsive_key.length-1)]){
                           for (let j=0;j<styleKey.length;j++){
                               if(rStyle[styleKey[j]]!='' && styleKey[j]!='type'){
                                   style[styleKey[j]]=rStyle[styleKey[j]];
                               }
                           }
                       }
                   }
                }
           }
           return style;
        },
        defaultStyle:function (id) {

            const style=this.$store.state.widget.style[id];
            const res={};
            const key=Object.keys(style);
            for(let i=0;i<key.length;i++){
                if(style[key[i]]!=''){
                    res[key[i]]=style[key[i]];
                }
            }
            return res;

        },
        checkAddResponsiveStyle:function (key,id) {
            let res=false;
            const k=key.toString().split('_');
            if(k.length>=2){
                key=key.toString().replace(k[0]+"_",'');
                key=key.toString().replace("_"+k[(k.length-1)],'');
            }
            if(key===id){
                res=true;
            }
            return res;
        }
    }
}

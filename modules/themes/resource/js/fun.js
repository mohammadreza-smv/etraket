export default {
    checkHasResponsiveStyle:function (style) {
        let res=false;
        const keys=Object.keys(style);
        for (let i=0;i<keys.length;i++){
            if(style[keys[i]]!='' && keys[i]!='type'){
                res=true;
            }
        }
        return res;
    },
    getResponsiveStyle:function (StyleObj) {
        let style={};
        const keys=Object.keys(StyleObj);
        for (let i=0;i<keys.length;i++){
            if(StyleObj[keys[i]]!=''){
                style[keys[i]]=StyleObj[keys[i]];
            }
        }
        return style;
    },
    defaultStyle:function () {
        return {
            width:'',
            height:'',
            backgroundColor:'',
            color:'',
            marginTop:'',
            marginRight:'',
            marginLeft:'',
            marginBottom:'',
            paddingTop:'',
            paddingRight:'',
            paddingLeft:'',
            paddingBottom:'',
            borderWidth:'0px',
            borderColor:'',
            borderTopRightRadius:'',
            borderBottomLeftRadius:'',
            borderBottomRightRadius:'',
            borderTopLeftRadius:'',
            flexDirection:'row',
            borderStyle:"solid",
            display: "flex",
            textAlign: "right",
            justifyContent:'start'
        };
    },
    responsive:function () {
        return {
            width:'',
            height:'',
            marginTop:'',
            marginRight:'',
            marginLeft:'',
            marginBottom:'',
            paddingTop:'',
            paddingRight:'',
            paddingLeft:'',
            paddingBottom:'',
            type:'min'
        };
    },
    setAppBoxHeight:function () {

        setTimeout(function () {
            const min_height=document.documentElement.scrollHeight;
            document.getElementById('app').style.minHeight=min_height+'px';
        },200);

    },
    getFinalStyle:function (styles,tagData,rows) {
        const finalList=styles;
        const keys=Object.keys(finalList);
        for (let i = 0; i <keys.length ; i++) {
            const res=this.checkHasTagId(tagData,rows,keys[i]);
            if(!res){
                delete finalList[keys[i]];
            }
        }
        return finalList;
    },
    checkHasTagId:function(tags,rows,id){
        let res=false;
        const keys=Object.keys(tags);
        for (let i = 0; i <keys.length ; i++) {
            const childKeys=Object.keys(tags[keys[i]]);
            for (let j = 0; j <childKeys.length ; j++) {
                if(childKeys[j]===id){
                    res=true;
                }
            }
        }
        for (let i = 0; i <rows.length ; i++) {
            if(rows[i].id===id){
                res=true;
            }
            else {
                const child1=rows[i].child;
                for (let j = 0; j <child1.length ; j++) {
                    if(child1[j].id===id){
                        res=true;
                    }
                    else{
                        const child2=child1[j].child;
                        if(child2!==undefined){
                            for (let k = 0; k <child2.length ; k++) {
                                if(child2[k].id===id){
                                    res=true;
                                }
                            }
                        }
                    }
                }
            }
        }
        return res;
    }
}

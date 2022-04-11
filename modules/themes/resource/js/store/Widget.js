import fun from "../fun";
const defaultStyle=fun.defaultStyle();
const responsive=fun.responsive();
export  default {
    namespaced:true,
    state:()=>({
        styleList:defaultStyle,
        style:{},
        styleId:'',
        rows:[],
        elementType:'',
        elementTag:'',
        tagCount:{
            img:0,
            p:0,
            card:0,
            ul:0,
            code:0,
            slide:0,
        },
        tagData:{
            img:{

            },
            card:{

            },
            ul:{

            },
            code:{

            },
            p:{

            },
            slide:{

            }
        },
        defaultValue:'',
        setting_box:'',
        dragRow:-1,
        boxDragRow:-1,
        page_state:'get-data',
        widget_list:[],
        positions:[],
        position:'',
        positionWithoutParam:'',
        positionName:'',
        widgetTag:'',
        widgetId:'',
        widgetData:{},
        show_right_box:true,
        page_width:'',
        responsive:responsive,
        responsiveStyle:{},
        responsiveItems:[],
        widgetDialog:false,
        newBoxDialog:false,
        BoxLabel:'',
        boxTitle:'',
        newBoxError:false,
        parentId:0,
        parentKey:-1,
        styleBox:false,
        inputPageWidth:'',
        responsive_type:'min',
        runDropFunction:'',
        positionParam:false,
        positionParamName:'',
        use_template:'yes'
    }),
    mutations:{
        setDefaultStyle:function (state,id) {
            state.styleId=id;
            const style=state.style[id];
            const keys=Object.keys(state.styleList);
            for (let i=0;i<keys.length;i++){
                state.styleList[keys[i]]=(style[keys[i]]!==undefined) ? style[keys[i]] : state.styleList[keys[i]];
            }
         },
        setStyle:function(state,boxStyle){
            state.style[state.styleId]=boxStyle;
            state.styleBox=false;

            const checkHasResponsiveStyle=fun.checkHasResponsiveStyle(state.responsive);
            const key=state.responsive_type+'_'+state.styleId+'_'+state.page_width;
            if(checkHasResponsiveStyle){
                const rStyle=fun.getResponsiveStyle(state.responsive);
                state.responsiveStyle[key]=rStyle;
            }
            else{
                if(state.responsiveStyle[key]!=undefined){
                    delete state.responsiveStyle[key];
                }
            }
            state.styleList=fun.defaultStyle();
            state.responsive=fun.responsive();
            //state.styleId='';
        },
        addNewBox(state,payload){
            const parentId=payload.parentId;
            const title=payload.title;
            const parentKey=payload.parentKey;

            let ob={};
            if(state.style[parentId].flexDirection=='column'){

                ob={
                    [title]: {width:'100%',height:'40px',display:"flex",flexDirection:'column'}
                };

            }
            else{

                let height=state.style[parentId].height.toString().replace('px','');
                height=parseInt(height)/2;
                height=height.toString()+'px';

                ob={
                    [title]: {width:'200px',height:height,display:"flex",flexDirection:'column'}
                };
            }

            state.style=Object.assign(ob,state.style);

            const childBox=parentKey.toString().split('@');
            if(childBox.length===2){
                state.rows[childBox[0]]['child'][childBox[1]].child.push({
                    id:title,
                    type:"box",
                    child:[]
                });
            }
            else {
                state.rows[parentKey].child.push({
                    id:title,
                    type:"box",
                    child:[]
                });
            }


            state.newBoxDialog=false;
        },
        addNewRow:function(state,title){
            state.rows.push({
                id:title,
                child:[]
            });

            const ob={
                [title]: {width:'100%',height:'150px',display:"flex",flexDirection:'column'}
            };

            state.style=Object.assign(ob,state.style);

            state.newBoxDialog=false;
        },
        dragstart:function (state,payload) {
            state.elementTag=payload.tag;
            state.elementType=payload.type;
            state.defaultValue=payload.defaultValue;
            this.runDropFunction='';
        },
        dropFinish:function (state,payload) {
            if(this.runDropFunction!=='dropFinish2'){
                 if(state.elementType!==''){
                     state.tagCount[state.elementTag]++;
                     const tagId=payload.id+"-"+state.elementTag+state.tagCount[state.elementTag];
                     if(payload.parent_key==undefined){
                         state.rows[payload.key].child.push({
                             type:state.elementType,
                             tag:state.elementTag,
                             id:tagId
                         });
                     }
                     else{
                         state.rows[payload.parent_key].child[payload.key].child.push({
                             type:state.elementType,
                             tag:state.elementTag,
                             id:tagId
                         });
                     }
                     const ob={
                         [tagId]:{}
                     }

                     state.style=Object.assign(ob,state.style);

                     const defaultValue=state.defaultValue;


                     state.tagData[state.elementTag]=Object.assign({
                         [tagId]:defaultValue
                     }, state.tagData[state.elementTag])


                     state.elementTag='';
                     state.elementType='';
                 }
                 else{
                     if(state.boxDragRow!==-1 && payload.parent_key!==undefined){
                         const k1=state.boxDragRow.toString().split('_');
                         state.rows[payload.parent_key]['child'].splice(payload.key,0,state.rows[payload.parent_key]['child'].splice(k1[1],1)[0])

                     }
                 }
            }
        },
        dropFinish2:function(state,payload){
            this.runDropFunction='dropFinish2';
            if(state.elementType!=''){
                state.tagCount[state.elementTag]++;
                const tagId=payload.id+"-"+state.elementTag+state.tagCount[state.elementTag];
                const parent_key=payload.parent_key.toString().split('@');

                state.rows[parent_key[0]]['child'][parent_key[1]].child[payload.box_key].child.push({
                    type:state.elementType,
                    tag:state.elementTag,
                    id:tagId
                });

                const ob={
                    [tagId]:{}
                }

                state.style=Object.assign(ob,state.style);

                const defaultValue=state.defaultValue;

                state.tagData[state.elementTag]=Object.assign({
                    [tagId]:defaultValue
                }, state.tagData[state.elementTag])

                state.elementTag='';
                state.elementType='';
            }
        },
        removeRowStyle:function (state,payload) {
            if(state.rows[payload.key].child!=undefined){
                const box=state.rows[payload.key].child;
                for (let j=0;j<box.length;j++){
                    if(box[j].child!=undefined){
                        const child=box[j].child;
                        for (let c=0;c<child.length;c++){
                            delete  state.style[child[c].id];
                        }
                        delete  state.style[box[j].id];
                    }
                    delete  state.style[box[j].id];
                }
            }
        },
        removeBox:function (state,payload) {
            if(state.rows[payload.key].child!==undefined){
                const box=state.rows[payload.key].child;
                for (let j=0;j<box.length;j++){

                    if(box[j].id===payload.id){

                        const tag=box[j]['tag'];
                        const tagId=box[j]['id'];
                        if(state.tagData[tag]!=undefined && state.tagData[tag][tagId]!=undefined){
                            delete state.tagData[tag][tagId];
                        }
                        delete  state.style[box[j].id];
                        state.rows[payload.key].child.splice(j,1);

                    }
                    if(box[j].child!==undefined){
                        const child1=box[j].child;
                        let checkHas=false;
                        for (let c=0;c<child1.length;c++){
                            if(child1[c].id===payload.id){
                                const tag=child1[c]['tag'];
                                const tagId=child1[c]['id'];
                                if(state.tagData[tag]!==undefined && state.tagData[tag][tagId]!==undefined){
                                    delete state.tagData[tag][tagId];
                                }
                                state.rows[payload.key].child[j].child.splice(c,1);
                                delete  state.style[child1[c].id];
                                checkHas=true;
                            }
                            else if(box[j].id===payload.id){
                                delete  state.style[child1[c].id];
                            }
                        }

                        if(!checkHas){
                            for (let c=0;c<child1.length;c++){
                                if(child1[c]['child']!==undefined){
                                    const child2=child1[c]['child'];
                                    for (let c2=0;c2<child2.length;c2++){

                                        if(child2[c2].id===payload.id){
                                            const tag=child2[c2]['tag'];
                                            const tagId=child2[c2]['id'];
                                            if(state.tagData[tag]!==undefined && state.tagData[tag][tagId]!==undefined){
                                                delete state.tagData[tag][tagId];
                                            }
                                            delete  state.style[child2[c2].id];
                                            state.rows[payload.key].child[j].child[c].child.splice(c2,1);

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        },
        rowDragstart:function (state,key) {
           state.dragRow=key;
        },
        boxDragstart:function (state,key) {
            state.boxDragRow=key;
            this.runDropFunction='';
        },
        rowDropFinish:function (state,key) {
            if( state.dragRow>-1){
                state.rows.splice(key,0,state.rows.splice(state.dragRow,1)[0])
            }
        },
        set_widgets_data:function (state,payload) {
            state.page_state='load-data';
            if(payload.widgets!=null){
                state.widget_list=payload.widgets;
                for(let i=0;i<state.widget_list.length;i++){
                    const tag=state.widget_list[i].name;
                    state.tagCount=Object.assign({[tag]:0},state.tagCount);
                    state.tagData=Object.assign({[tag]: {}},state.tagData);
                    state.widgetData[tag]=state.widget_list[i];
                }
            }

            state.positions=payload.positions;

        },
        set_position_data:function (state,payload) {
            state.page_state='load-data';
            if(payload!=null){
                state.rows=payload.rows;
                state.style=payload.style;
                state.tagData=payload.tags;
                if(payload.responsive_style!=undefined){
                    state.responsiveStyle=payload.responsive_style;
                }

                const rows=state.rows;
                for(let r=0;r<rows.length;r++){
                    if(rows[r].child!=undefined){
                        const box1=rows[r].child;
                        for(let c1=0;c1<box1.length;c1++){

                            if(box1[c1]['type']=='html'){
                                state.tagCount[box1[c1]['tag']]++;
                            }

                            if(box1[c1].child!=undefined){
                                const box2=box1[c1].child;
                                for(let c2=0;c2<box2.length;c2++){
                                    if(box2[c2]['type']==='html'){
                                        state.tagCount[box2[c2]['tag']]++;
                                    }
                                    if(box2[c2].child!==undefined){
                                         const box3=box2[c2].child;
                                        for(let c3=0;c3<box3.length;c3++){
                                            if(box3[c3]['type']==='html'){
                                                state.tagCount[box3[c3]['tag']]++;
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                }

                fun.setAppBoxHeight();
            }
            else{
                state.rows=[];
                state.style={};
            }
        },
        show_widget_setting_box:function (state,payload) {
            if(state.widgetData[payload.tag].setting!=undefined){
                state.widgetTag=payload.tag;
                state.widgetId=payload.id;
                state.widgetDialog=true;
            }
        },
        change_right_box_state:function (state) {
            state.page_width='';
            state.show_right_box=!state.show_right_box;
        },
        change_page_width:function (state) {
            if(parseInt(state.inputPageWidth)>0){
                state.page_width=parseInt(state.inputPageWidth);
            }
        },
        setResponsiveItems:function (state) {
            if(state.styleId!=''){
                state.responsiveItems=[];
                const responsiveStyle=state.responsiveStyle;
                const keys=Object.keys(responsiveStyle);
                for (let i=0;i<keys.length;i++){
                    if(keys[i].indexOf(state.styleId)>-1){
                        let add=true;
                        if(keys[i].indexOf('-')>-1){
                            if(state.styleId.indexOf('-')<=-1){
                                add=false;
                            }
                        }

                        if(add){
                            const rkey=keys[i].split('_');
                            if(rkey.length>=3){
                                state.responsiveItems.push({
                                    type:rkey[0],
                                    width:rkey[(rkey.length-1)],
                                    key:keys[i]
                                });
                            }
                        }
                    }
                }
            }
        },
        setDefaultResponsiveStyle:function (state,payload) {
            if(state.responsiveStyle[payload.key]!=undefined){
                state.responsive_type=payload.type;
                const style=state.responsiveStyle[payload.key];
                const keys=Object.keys(style);
                for (let i=0;i<keys.length;i++){
                    state.responsive[keys[i]]=style[keys[i]];
                }
                state.page_width=payload.width;
            }
        },
        changeNewBoxDialogStatus:function (state) {
            state.newBoxDialog=!  state.newBoxDialog;
        },
        changeStyleDialogStatus:function (state) {
            state.styleBox=!  state.styleBox;
            state.responsive=fun.responsive();
            if(state.styleBox===false){
                state.styleList=fun.defaultStyle();
            }
        }
    },
    actions:{
        show_style_box:function ({commit,state},payload) {
            commit('setDefaultStyle',payload.id);
            if(payload.setting_box==undefined){
                state.setting_box='';
            }
            else{
                state.setting_box=payload.setting_box;
            }

            commit('setResponsiveItems');

            commit('changeStyleDialogStatus');

        },
        removeBox:function ({commit,state},id) {
            const rows=state.rows;
            let checkHas=false;
            for (let i=0;i<rows.length;i++){

                commit('removeBox',{key:i,id:id})

                if(rows[i].id==id){

                    checkHas=true;
                    commit('removeRowStyle',{key:i,id:id});

                    if(rows[i].child!=undefined){
                        const child=rows[i].child;
                        for (let c=0;c<child.length;c++){
                            const tag=child[c]['tag'];
                            const tagId=child[c]['id'];
                            if(state.tagData[tag] !=undefined){
                                delete  state.tagData[tag][tagId];
                            }
                        }
                    }

                    state.rows.splice(i,1);
                }
            }
            delete  state.style[id];
        },
        get_widgets:function ({commit,state}) {
            const url=Vue.prototype.$siteUrl+"/admin/themes/widget-list";
            Vue.axios.get(url).then(response=>{
               commit('set_widgets_data',response.data);
            });
        },
        send_widget_data:function ({state}) {
            if(state.rows.length>0){

            }
            state.page_state='get-data';
            const url=Vue.prototype.$siteUrl+'/admin/theme/design/save-data';
            const responsiveStyle=Object.assign({}, state.responsiveStyle);

            const finalStyle=fun.getFinalStyle(state.style,state.tagData,state.rows)

            const formData=new FormData();
            formData.append('rows',JSON.stringify(state.rows));
            formData.append('style',JSON.stringify(finalStyle));
            formData.append('tagData',JSON.stringify(state.tagData));
            formData.append('position',state.position);
            formData.append('responsiveStyle',JSON.stringify(responsiveStyle));
            formData.append('use_template',state.use_template);
            Vue.axios.post(url,formData).then(response=>{
                state.page_state='load-data';
            }).catch(error=>{
                state.page_state='error';
                setTimeout(function () {
                    state.page_state = '';
                }, 5000);
            });
        },
        getPositionData:function ({commit,state}) {
            if(state.position!==''){
                state.page_state='get-data';
                const url=Vue.prototype.$siteUrl+'/admin/theme/design/get-position-data/'+state.position;
                Vue.axios.get(url).then(response=>{
                    commit('set_position_data',response.data);
                }).catch(error=>{
                    state.page_state='error';
                    setTimeout(function () {
                        state.page_state = '';
                    }, 5000);
                });
            }
        }
    },
}

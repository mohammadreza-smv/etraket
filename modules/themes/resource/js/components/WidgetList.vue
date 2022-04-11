<template>
    <div class="html-elements">
        <p>ابزارک ها</p>

        <ul class="elements_ul">
            <li v-for="item in $store.state.widget.widget_list"
                draggable="true"
                @dragstart="$store.commit('widget/dragstart',
                {
                    type:'widget',
                    tag:item.name,
                    defaultValue:getWidgetAttr(item),
                    widgetSettingData:getWidgetSettingData(item)
                })"
            >
                <span>{{ item.title }}</span>
            </li>

        </ul>

    </div>
</template>

<script>
    export default {
        name: "WidgetList",
        methods:{
            getWidgetSettingData:function (args) {
                let response=null;
                if(args.setting!=undefined){
                    if(args.setting.data!=undefined){
                        response=args.setting.data;
                    }
                }
                return response;
            },
            getWidgetAttr:function (data) {
                let result={};
                if(data.setting!=undefined){
                    if(data.setting.list!=undefined){
                        const keys=Object.keys(data.setting.list);
                        for(let i=0;i<keys.length;i++){
                            result[keys[i]]=data.setting.list[keys[i]]['value'];
                        }
                    }
                }
                result['view']=data['view'];
                return result;
            }
        }
    }
</script>


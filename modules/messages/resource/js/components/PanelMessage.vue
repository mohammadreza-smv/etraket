<template>
    <div class="messages">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "PanelMessage"
    }
</script>

<style>
    .form_link{
        background-color: #f4516c;
        color: white !important;
        padding: 4px 15px;
        border-radius: 15px;
        -webkit-border-radius: 15px;
        font-size: 14px;
    }
    .to_link{
        background-color: #34bfa3;
        color: white !important;
        padding: 4px 15px;
        border-radius: 15px;
        -webkit-border-radius: 15px;
        font-size: 14px;
    }
    .messages a{
        text-decoration:none;
    }
    .message_content_div{
        border-radius: 4px;
        -webkit-border-radius: 4px;
        box-shadow: 0px 2px 3px rgba(0, 0, 0, 0.09);
        color: #444d4d;
        font-size: 15px;
        margin-top: 20px;
        min-height: 160px;
    }
    .message_content_header {
        background-color: #f6f8fa;
        padding: 18px;
        display: inline-flex;
        justify-content: space-between;
        color: black;
        width: 100%;
        border-top-right-radius: 4px;
        -webkit-border-top-right-radius: 4px;
        border-top-left-radius: 4px;
        -webkit-border-top-left-radius: 4px;
        cursor: pointer;
    }
    .message_content_div .content {
        padding: 18px;
        list-style: none;
        line-height: 30px;
    }
    .mobile-message-box{
        background-color: #fff;
        padding: 5px 15px;
        border-radius: 9px;
        -webkit-border-radius: 9px;
        box-shadow: 0px 2px 4px 2px rgba(0,0,0,.09);
        -webkit-box-shadow: 0px 2px 4px 2px rgba(0,0,0,.09);
        margin-bottom:10px;
    }
    .user_message_div{
        border-radius: 4px;
        -webkit-border-radius: 4px;
        box-shadow:0px 2px 3px rgba(0, 0, 0, 0.09);
        color:#444d4d;
        font-size: 15px;
        margin-top: 20px;
        min-height: 160px;
    }
    .user_message_div_header{
        background-color: rgba(232, 249, 249, 0.68);
        padding: 18px;
        display: inline-flex;
        justify-content: space-between;
        color: black;
        width: 100%;
        border-top-right-radius: 4px;
        -webkit-border-top-right-radius: 4px;
        border-top-left-radius: 4px;
        -webkit-border-top-left-radius: 4px;
        cursor: pointer;
    }
    .message_content{
        padding: 18px;
        list-style: 28px;
        line-height: 30px;
    }
</style>

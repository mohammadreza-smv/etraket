<template>
    <div class="review_box">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "ProductReview",
    mounted() {
        this.$root.$on('change_review_box_status',function (id){

           const contentTag =document.querySelector("#review_box_"+id).querySelector('.content');
            if (contentTag.style.display === 'none') {
                contentTag.style.display='block';
                document.querySelector("#review_box_"+id).querySelector('.plus')
                .style.display='none';
                document.querySelector("#review_box_"+id).querySelector('.minus')
                    .style.display='block';
            } else {
                contentTag.style.display='none';
                document.querySelector("#review_box_"+id).querySelector('.plus')
                    .style.display='block';
                document.querySelector("#review_box_"+id).querySelector('.minus')
                    .style.display='none';
            }

        });
    }
}
</script>

<style>
    .review_box .item_row::before {
        content: "";
        background: #eee;
        width: 1px;
        position: absolute;
        bottom: 0px;
        top: 43px;
        right: 18px;
    }
    .review_box .item_row {
        position: relative;
        padding-bottom: 10px;
    }
    .review_box {
        width: 95%;
        margin: 40px auto;
        position: relative;
    }
    .expert_button {
        width: 38px;
        height: 32px;
        background-color: #a7a9a9;
        position: absolute;
        right: 0;
        top: 0;
        color: #fff;
        border: none;
        border-radius: 0px 15px 15px;
        -webkit-border-radius: 0px 15px 15px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .review_box .item_row h3 {
        padding-right: 45px;
        font-size: 18px;
        padding-top: 8px;
    }
    .review_box .plus{
        display: none;
    }
    .review_box .v-icon{
        color: white;
        margin: 0 !important;
    }
</style>

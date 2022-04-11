<template>
    <div class="page-content">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "PageContent"
}
</script>

<style scoped>
.page-content{
    background: white;
    margin: 10px auto 20px auto !important;
    width:98%;
    padding: 30px;
    line-height: 30px;
    border: 1px solid #dedede;
    margin-bottom: 30px;
}
.page-content h2 {
    margin-bottom: 20px;
}
</style>

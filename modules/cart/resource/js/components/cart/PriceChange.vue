<template>
    <div v-if="changes_price.length>0" class="alert alert-warning changes_cart">
        <span>توجه : قیمت یا موجودی بعضی از کالاهای سبد خرید شما تغییر کرده است</span>
        <ul>
            <li v-for="(msg,key) in changes_price" :key="key">
                {{ msg }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "PriceChange",
        props:['changes_price']
    }
</script>


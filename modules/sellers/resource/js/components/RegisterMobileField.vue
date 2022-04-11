<template>
    <div>
        <input type="hidden" name="mobile" :value="mobile">
    </div>
</template>

<script>
    export default {
        name: "RegisterMobileField",
        props:['mobile']
    }
</script>


<template>
    <v-app-bar absolute color="white" elevate-on-scroll height="60">

        <v-app-bar-nav-icon @click="$root.$emit('changeNavigation')" />

        <v-toolbar-title>پنل فروشندگان</v-toolbar-title>

        <v-spacer></v-spacer>


        <ul>
            <li>
                <v-icon @click="$root.$emit('send_post_request',$siteUrl+'/sellers/panel/logout',{})">mdi-logout</v-icon>
            </li>
        </ul>

    </v-app-bar>

</template>

<script>
    export default {
        name: "SellerAppBar"
    }
</script>


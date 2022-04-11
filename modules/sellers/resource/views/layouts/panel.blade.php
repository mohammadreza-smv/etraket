<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>پنل مدیریت فروشندگان</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_url" content="{{ url(('/')) }}">
    <link href="{{ asset('modules/sellers/sellers.css?id=fdfdssgdd') }}" rel="stylesheet">
    {{ add_css_file('desktop') }}
</head>
<body>

<div id="app">
    <?php
       $sideBarMenu=getSellerPanelMenu();
    ?>
    <v-app class="app-style">
        <seller-panel-drawer :items="{{ json_encode($sideBarMenu) }}"></seller-panel-drawer>
        <v-main>
            <seller-app-bar></seller-app-bar>
            <div style="padding-top:80px">
                <app-content>
                    @yield('content')
                </app-content>
            </div>
            <response-dialog></response-dialog>
        </v-main>
    </v-app>
</div>

<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>

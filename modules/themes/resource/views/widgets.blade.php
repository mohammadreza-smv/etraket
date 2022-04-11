<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ابزارک ها</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_url" content="{{ url(('/')) }}">
    {{ add_css_file('widgets?id=fabguer') }}
</head>
<body>

<div id="app">
    <theme-widgets></theme-widgets>
</div>



<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo.adminkit.io/dashboard-ecommerce" />

    <title>Dashboard | SmartApartment</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->
    <!-- <link href="css/light.css" rel="stylesheet"> -->
    {{-- <link href="css/dark.css" rel="stylesheet"> --}}

    <!-- BEGIN SETTINGS -->
    <!-- Remove this after purchasing -->
    <link class="js-stylesheet" href="css/dark.css" rel="stylesheet">
    <script src="js/settings.js"></script>

    <style>
        body {
            opacity: 0;
        }

    </style>
    <!-- END SETTINGS -->

    @stack('css')
</head>
<!--
  HOW TO USE:
  data-theme: default (default), dark, light, colored
  data-layout: fluid (default), boxed
  data-sidebar-position: left (default), right
  data-sidebar-layout: default (default), compact
-->

<body data-theme="dark" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">
        @include('layouts.dashboard.sidebar')

        <div class="main">
            @include('layouts.dashboard.navbar')

            @yield('main')

            @include('layouts.dashboard.footer')
        </div>
    </div>



    <script src="js/app.js"></script>
    @stack('js')

</body>

</html>

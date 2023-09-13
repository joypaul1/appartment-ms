<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{{-- <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5"> --}}
@include('backend._include.metaTag')

{{-- for ajax  csrf token --}}
<meta name="csrf-token" content="{{ csrf_token() }}" />
{{-- <meta name="author" content="AdminKit"> --}}
{{-- <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web"> --}}

<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

{{-- <link rel="canonical" href="https://demo.adminkit.io/dashboard-ecommerce" /> --}}

<title>Appartment | @yield('title')</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

<!-- Choose your prefered color scheme -->

<!-- BEGIN SETTINGS -->
<link href="{{ asset('assets/backend/css/light.css') }}" rel="stylesheet">
{{-- <link  href="{{ asset('assets/backend/css/light.css') }}" rel="stylesheet"> --}}
<link href="{{ asset('assets/backend') }}/toastr/toastr.min.css"  rel="stylesheet">



<style>
    body {
        opacity: 0;
    }
</style>
<!-- END SETTINGS -->

@stack('css')
{{-- meta tag --}}

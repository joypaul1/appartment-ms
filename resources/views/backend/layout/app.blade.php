<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend._include.headerCss')
</head>


<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">

        @include('backend._partials.sidebar')

        <div class="main">

            @include('backend._partials.nav_header')

            <main class="content">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </main>

            @include('backend._partials.footer')

        </div>
    </div>

    <script src="{{ asset('assets/backend/js/app.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatables.js') }}"></script>

    @include('backend._include.footerJs')
</body>

</html>

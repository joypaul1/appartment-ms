<!DOCTYPE html>
<html lang="en" <head>
<!-- PAGE TITLE HERE -->
<title>{{ URL::current() }} </title>
{{-- header included here --}}
@include('backend._include.headerCss')

</head>

<body class="theme-cyan">





    <div id="wrapper">

        <!--  Nav header start -->
        {{-- @include('backend._partials.nav_header') --}}
        <!--  Nav header end -->

        <!--  Sidebar start -->
        {{-- @include('backend._partials.sidebar') --}}
        <!--  Sidebar end -->


        <div id="main-content">
            <div class="container-fluid mt-4">
                @yield('content')
            </div>
        </div>
        <!--Footer scripts included here -->
        {{-- @include('backend._include.footerJs') --}}

        <script type="text/javascript">
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        </script>
        {{-- toast-sms --}}
        @if (Session::get('success'))
            <script>
                let $message = "{{ Session::get('success') }}";
                let $context = 'success';
                let $positionClass = 'toast-top-right';
                toastr.remove();
                toastr[$context]($message, '', {
                    positionClass: $positionClass
                });
            </script>
        @elseif(Session::get('error'))
            <script>
                let $message = "{{ Session::get('error') }}";
                let $context = 'error';
                let $positionClass = 'toast-top-right';
                toastr.remove();
                toastr[$context]($message, '', {
                    positionClass: $positionClass
                });
            </script>
        @endif
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend._include.headerCss')
</head>


<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">
        {{-- @dd(auth('admin')->user()->role_type) --}}
        @if (auth('admin')->user()->role_type == 'owner')
        @include('backend._partials.owner_sidebar')
        @elseif (auth('admin')->user()->role_type == 'tenant')
        @include('backend._partials.tenant_sidebar')
        @elseif (auth('admin')->user()->role_type == 'employee')
        @include('backend._partials.employee_sidebar')
        @else
        @include('backend._partials.sidebar')
        @endif

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
    <script src="{{ asset('assets/backend/toastr/toastr.js') }}"></script>
    @stack('js')

    @include('backend._include.footerJs')
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

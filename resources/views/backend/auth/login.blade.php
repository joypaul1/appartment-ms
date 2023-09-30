<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    {{--
    <meta name="author" content="AdminKit"> --}}
    {{--
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web"> --}}

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    {{--
    <link rel="canonical" href="https://demo.adminkit.io/dashboard-ecommerce" /> --}}

    <title>Apartment| Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->

    <!-- BEGIN SETTINGS -->
    <link href="{{ asset('assets/backend/css/dark.css') }}" rel="stylesheet">
    {{--
    <link href="{{ asset('assets/backend/css/light.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            opacity: 0;
        }
    </style>
    <!-- END SETTINGS -->

    @stack('css')
</head>

<body data-theme="dark" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default"
    style="background: url('{{ asset('assets/backend') }}/img/login_bg.jpg'); background-size: cover; background-repeat: no-repeat; ">
    <main class="d-flex w-100 h-100" style="background-color: #19222ce8;backdrop-filter: blur(6px);">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="text-center mb-4">
                                        @php
                                        $siteInfo = App\Models\SiteInfo::first();

                                        @endphp
                                        @if (File::exists(public_path($siteInfo->logo)))
                                        <img src="{{ asset('assets/backend') }}/img/login.png" alt="Charles Hall" class="img-fluid" width="200" />
                                        @else
                                        <img src="{{ asset('assets/backend') }}/img/login.png" alt="Charles Hall" class="img-fluid" width="200" />
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('backend.admin.login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                placeholder="Enter your password" />

                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="text-center mt-4">
                        <h1 class="h2">Welcome back, Charles</h1>
                        <p class="lead">
                            Sign in to your account to continue
                        </p>
                    </div> --}}



                </div>
            </div>
        </div>
        </div>
    </main>

    <script src="{{ asset('assets/backend/js/app.js') }}"></script>

</body>

</html>

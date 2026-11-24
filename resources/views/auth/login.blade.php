@extends('templates.main')

@section('title', 'Login')
@section('css')
    <link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet" />
@endsection
@section('body')
    {{-- Halaman login - markup & style (css/auth/auth.css) sama dengan
         auth/login.blade.php di supplier-portal, tanpa captcha & param
         integrasi. Form POST ke doLogin: username, password, remember. --}}
    <img src="{{ asset('img/auth/gradient.png') }}" alt="wave" class="wave">

    <div class="container-fluid">
        <div class="row bg-white py-2 mb-5">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6 d-none small d-md-block">
                            <h5>Template Supplier Portal</h5>
                        </div>
                        <div class="col-12 col-md-6 text-center small d-block d-md-none">
                            <h5>Template Supplier Portal</h5>
                        </div>

                        <div class="col-12 col-md-6 text-right d-none d-md-block">
                            <h5 class="cta"></h5>
                        </div>
                        <div class="col-12 col-md-6 text-center d-block d-md-none">
                            <h5 class="cta"></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="row d-flex">
                    <div class="col-12 col-md-5">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-center bg-white">
                                <img src="{{ asset('img/auth/akebonologo.png') }}" alt="logo"
                                    class="avatar w-75">
                            </div>
                            <div class="card-body">
                                @if (session()->has('error'))
                                    <div class="alert" role="alert" style="font-size: 12px">
                                        {{ session()->get('error') }}
                                    </div>
                                @endif
                                <h5 class="text-center mb-4">Selamat datang di PORTAL SUPPLIER</h5>
                                <form action="{{ route('doLogin') }}" method="post" autocomplete="on">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-div one">
                                                <div class="i">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <h5>Username</h5>
                                                    <input type="text" class="input" name="username" id="username"
                                                        autocomplete="username" value="{{ old('username') }}">
                                                </div>
                                            </div>
                                            @error('username')
                                                <p class="error-username"><b>{{ $message }}</b></p>
                                            @enderror
                                            <div class="input-div two">
                                                <div class="i">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                                <div>
                                                    <h5>Password</h5>
                                                    <input type="password" class="input" name="password" id="password"
                                                        autocomplete="current-password">
                                                    <a id="badge-MyPassword" onclick="showMyPassword()"
                                                        class="position-relative btn btn-sm text-primary pull-right col-2 h-100"
                                                        style="background: transparent">
                                                        <i class="p-3 fas fa-eye-slash" style="scale:1.5"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            @error('password')
                                                <p class="error-password"><b>{{ $message }}</b></p>
                                            @enderror
                                            <input type="checkbox" class="btn-check" name="remember" id="remember-me"
                                                value="1" style="scale:1.5">&nbsp; Ingat Saya
                                        </div>
                                        <div class="col-12 mt-5">
                                            <div class="btnform">
                                                <input type="submit" value="Login" id="login" class="btn text-white">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="row d-none d-md-block">
                            <div class="col-12">
                                <div class="">
                                    <div class=" d-flex justify-content-center">
                                        <img src="{{ asset('img/auth/loginimage.png') }}" alt="login image"
                                            class="w-75">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">

                                <div class="announcement">
                                    <div class="title">
                                        <img src="{{ asset('img/auth/icon.png') }}" alt="icon">
                                        <h5>Pengumuman</h5>
                                    </div>
                                    <div class="list">
                                        <p>Ini adalah template supplier portal. Akun contoh
                                            (password: <b>password</b>):</p>
                                        <p>1. <b>developer</b> - role Developer, semua menu.</p>
                                        <p>2. <b>supplier01</b> - role Supplier, hanya part miliknya.</p>
                                        <p>3. <b>finance01</b> - role Finance, menu Master MRP saja.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col-12 text-center">
                        <p>Copyright &copy; {{ date('Y') }} - Template Supplier Portal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function showMyPassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                $('#password').focus();
                $("#badge-MyPassword").html('<i class="p-3 fas fa-eye" style="scale:1.5"></i>');
                x.type = "text";
            } else {
                $("#badge-MyPassword").html('<i class="p-3 fas fa-eye-slash" style="scale:1.5"></i>');
                x.type = "password";
            }
        }
    </script>
@endsection

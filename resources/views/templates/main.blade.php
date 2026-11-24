@php
    // Layout master - struktur sama dengan templates/main.blade.php di
    // supplier-portal: halaman login dirender tanpa wrapper, halaman lain
    // dibungkus sidebar + header + content + footer (template Spruha).
    $currentRouteName = Route::currentRouteName();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="base-url" content="{{ url('/') }}/">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>@yield('title') - {{ config('app.name') }}</title>
    @include('templates.css')
    @yield('css')
</head>
@if ($currentRouteName == 'login')
    @php
        $classBody = '';
    @endphp
@else
    @php
        $classBody = 'main-body leftmenu';
    @endphp
@endif

<body class="{{ $classBody }}">
    @if ($currentRouteName == 'login')
        @yield('body')
    @else

        {{-- loader get data --}}
        <div class="preloader d-none">
            <div class="loading">
                <img src="{{ asset('img/main/loading/loading.gif') }}" width="150">
                <p class="text-center">Loading ...</p>
            </div>
        </div>
        {{-- end loader get data --}}

        <!-- Page -->
        <div class="page">
            @include('templates.sidemenu')

            @include('templates.header')

            <!-- Main Content-->
            <div class="main-content side-content pt-0">
                <div class="container-fluid">
                    <div class="inner-body">

                        @yield('body')
                    </div>
                </div>
            </div>
            <!-- End Main Content-->

            @include('templates.footer')
        </div>
        <!-- End Page -->

        <!-- Back-to-top -->
        <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>
    @endif

    @include('templates.js2')
    @yield('script')
</body>

</html>

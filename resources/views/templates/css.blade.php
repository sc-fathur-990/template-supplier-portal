{{-- CSS global - sama seperti templates/css.blade.php di supplier-portal.
     Asset Spruha (Bootstrap 4.5.3) disalin dari project asli ke public/spruha. --}}

<!-- Favicon -->
<link rel="icon" href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/img/brand/favicon.png" type="image/x-icon"/>

{{-- font awesome --}}
<link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}" />

@if (isset($currentRouteName) && $currentRouteName == 'login')
    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
@else
    <!-- Bootstrap css-->
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- daterange picker -->
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet"/>

    <!-- Icons css-->
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/web-fonts/icons.css" rel="stylesheet"/>
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/web-fonts/plugin.css" rel="stylesheet"/>

    <!-- New Datatables -->
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fixedColumns.dataTables.min.css') }}" rel="stylesheet">

    <!-- Style css-->
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/css/style.css" rel="stylesheet">
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/css/skins.css" rel="stylesheet">
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/css/dark-style.css" rel="stylesheet">
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/css/colors/default.css" rel="stylesheet">

    <link href="{{ asset('toastr/build/toastr.css') }}" rel="stylesheet"/>

    <!-- Color css-->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/css/colors/color.css">

    <!-- Select2 css-->
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/select2/css/select2.min.css" rel="stylesheet">

    <!-- Datepicker css -->
    <link rel="stylesheet" href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/model-datepicker/css/datepicker.css">

    <!-- Mutipleselect css-->
    <link rel="stylesheet" href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/multipleselect/multiple-select.css">

    <!-- Sidemenu css-->
    <link href="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/css/sidemenu/sidemenu2.css" rel="stylesheet">

    {{-- main css --}}
    <link rel="stylesheet" href="{{ asset('css/main/main.css') }}">
@endif
@yield('styles')
<style>
    .swal2-container {
        z-index: 10600 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        color: #666 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:focus {
        color: #666 !important;
    }

    .form-outline #mySearch {
        padding: 8px;
    }
</style>

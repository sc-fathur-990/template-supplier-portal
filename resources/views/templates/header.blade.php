{{--
    Header atas - struktur sama dengan templates/header.blade.php di
    supplier-portal (tanpa notifikasi loncheng; badge bell selalu 0).
    Sign Out memakai id buttonLogout yang ditangani public/js/main.js
    (konfirmasi SweetAlert -> redirect /logout).
--}}
<!-- Main Header-->
<div class="main-header side-header sticky" id="fixed">
    <div class="container-fluid">
        <div class="main-header-left">
            <a class="main-header-menu-icon" href="#" id="mainSidebarToggle"><span></span></a>
        </div>
        @php
            $currentUser = Auth::guard('pub_login')->user();
            $displayName = $currentUser->username ?? 'Guest';
            $displayRole = $currentUser->previllage ?? '-';
            $supplierCode = $currentUser->kode_supplier ?? '';
        @endphp
        <div class="main-header-right">
            <div class="dropdown d-md-flex">
                <a class="nav-link icon full-screen-link" href="">
                    <i class="fe fe-maximize fullscreen-button fullscreen header-icons"></i>
                    <i class="fe fe-minimize fullscreen-button exit-fullscreen header-icons"></i>
                </a>
            </div>
            <div class="dropdown main-header-notification">
                <a class="nav-link icon" href="">
                    <i class="fe fe-bell header-icons bell"></i>
                    <span class="badge badge-danger nav-link-badge">0</span>
                </a>
                <div class="dropdown-menu">
                    <div class="main-notification-list">
                        <div class="media new">
                            <div class="media-body">
                                <p class="text-center">
                                    <b>
                                        No new notifications
                                    </b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown d-md-flex">
                <div class="header-navheading">
                    <h6 class="main-notification-title">{{ $displayName }}</h6>
                    <p class="main-notification-text">{{ $displayRole }} {{ $supplierCode }}</p>
                </div>
            </div>
            <div class="dropdown main-profile-menu">
                <a class="d-flex" href="#">
                    <span class="main-img-user"><img alt="avatar"
                            src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/img/users/avatar.png"></span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" id="buttonLogout" style="color: black">
                        <i class="fe fe-power"></i> Sign Out
                    </a>
                </div>
            </div>
            <button class="navbar-toggler navresponsive-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
            </button><!-- Navresponsive closed -->
        </div>
    </div>
</div>
<!-- End Main Header-->

<!-- Mobile-header -->
<div class="mobile-main-header">
    <div class="mb-1 navbar navbar-expand-lg  nav nav-item  navbar-nav-right responsive-navbar navbar-dark  ">
        <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown main-header-notification flag-dropdown">
                </div>
                <div class="dropdown main-profile-menu">
                    <a class="d-flex" href="#">
                        <span class="main-img-user"><img alt="avatar"
                                src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/img/users/avatar.png"></span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="header-navheading">
                            <h6 class="main-notification-title">{{ $displayName }}</h6>
                        </div>
                        <a class="dropdown-item" id="buttonLogoutt" style="color: black">
                            <i class="fe fe-power"></i> Sign Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mobile-header closed -->

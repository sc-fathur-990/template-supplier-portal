{{--
    Sidebar menu - markup sama dengan templates/sidemenu3.blade.php di
    supplier-portal, tetapi isi menu diambil dari database:

    1. Dashboard : hardcoded, selalu tampil untuk semua role
    2. Menu lain : dari tabel `sidemenu` (level 1) dan `submenu` (level 2),
                   difilter role user (users_login.previllage vs kolom role).

    Penandaan menu aktif memakai Request::is() / explode currentRouteName,
    sama seperti project asli.
--}}
<script src="{{ asset('assets/js/jquery-3.6.0.js') }}"></script>
<!-- Sidemenu -->
<div class="main-menu main-sidebar main-sidebar-sticky side-menu">
    <div class="sidemenu-logo" style="background-color:white">
        <a class="main-logo" href="{{ route('dashboard') }}">
            <img src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/img/brand/logo-light.png"
                class="header-brand-img desktop-logo" alt="logo">
            <img src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/img/brand/icon-light.png"
                class="header-brand-img icon-logo" alt="logo">
        </a>
    </div>
    <div class="main-sidebar-body">
        <div class="slide-left disabled" id="slide-left"><i class="fe fe-chevron-left"></i></div>
        <ul class="nav menu-nav" id="myMenu">
            @php
                $currentUser = Auth::guard('pub_login')->user();
                $currentPrevillage = $currentUser->previllage ?? null;
                $currentRouteName = Route::currentRouteName() ?? '';

                // Menu level 1 yang boleh dilihat role user ini
                $sidemenus = \App\Models\Sidemenu::all()->filter(
                    fn ($menu) => $menu->allowsRole($currentPrevillage)
                );
            @endphp
            <li class="nav-item">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="mySearch" class="form-control" placeholder="Search..."
                            onkeyup="cariMenuSidebar()">
                    </div>
                </div>
            </li>

            {{-- Dashboard (hardcoded, semua role) --}}
            <li class="nav-item @if ('dashboard' == explode('.', $currentRouteName)[0]) active @endif">
                <a class="nav-link" href="{{ route('dashboard') }}"><span class="shape1"></span><span
                        class="shape2"></span><i class="ti-home sidemenu-icon"></i><span
                        class="sidemenu-label">Dashboard</span></a>
            </li>

            {{-- Menu dari database (level 1 + level 2) --}}
            @foreach ($sidemenus as $menu)
                @php
                    $submenus = $menu->submenus->filter(
                        fn ($sub) => $sub->allowsRole($currentPrevillage)
                    );
                    // Menu aktif jika path sekarang cocok dengan rutenya
                    // sendiri atau salah satu rute submenu-nya
                    $isActive = Request::is(ltrim($menu->route, '/'))
                        || $submenus->contains(fn ($sub) =>
                            Request::is(ltrim($sub->rute, '/'))
                            || ($sub->in_rute && Request::is(ltrim($sub->in_rute, '/'))));
                @endphp

                @if ($submenus->isEmpty())
                    {{-- Menu tunggal tanpa submenu --}}
                    <li class="nav-item @if ($isActive) active @endif">
                        <a class="nav-link" href="{{ url($menu->route) }}">
                            <span class="shape1"></span><span class="shape2"></span>
                            <i class="{{ $menu->icon }} sidemenu-icon"></i>
                            <span class="sidemenu-label">{{ $menu->name }}</span>
                        </a>
                    </li>
                @else
                    {{-- Menu dengan dropdown submenu --}}
                    <li class="nav-item @if ($isActive) active show @endif">
                        <a class="nav-link with-sub" href="#">
                            <span class="shape1"></span><span class="shape2"></span>
                            <i class="{{ $menu->icon }} sidemenu-icon"></i><span
                                class="sidemenu-label">{{ $menu->name }}</span><i
                                class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            @foreach ($submenus as $sub)
                                <li class="nav-sub-item @if (Request::is(ltrim($sub->rute, '/'))) active @endif">
                                    <a class="nav-sub-link" href="{{ url($sub->rute) }}"><span>{{ $sub->nama }}</span></a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
        <div class="slide-right" id="slide-right"><i class="fe fe-chevron-right"></i></div>
    </div>
</div>
<!-- End Sidemenu -->

{{-- JS global - sama seperti templates/js2.blade.php di supplier-portal. --}}
<script type="text/javascript">var base_url = "{{ url('') }}";</script>
<script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>

@if ($currentRouteName == 'login')

@else

    <!-- Popper js-->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Internal Chart.Bundle js-->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/chart.js/Chart.bundle.min.js"></script>

    <!-- Select2 js-->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/js/select2.js"></script>

    <!-- Internal Daternagepicker js-->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Internal Datepicker js -->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/model-datepicker/js/datepicker.js"></script>
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/model-datepicker/js/main.js"></script>

    <!-- New Datatable -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.fixedColumns.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.colReorder.min.js') }}"></script>
    <!-- JQuery Export Table -->
    <script src="{{ asset('assets/js/jquery.table2excel.min.js') }}"></script>
    <!-- Perfect-scrollbar js -->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!-- Sidemenu js -->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/sidemenu/sidemenu4.js"></script>

    <!-- Sidebar js -->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/plugins/sidebar/sidebar.js"></script>

    <!-- Sticky js -->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/js/sticky.js"></script>

    <!-- Modal js-->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/js/modal.js"></script>

    <!-- Custom js -->
    <script src="{{ asset('spruha/HTML-LTR/vertical-Icontext') }}/../../assets/js/custom.js"></script>
    <script src="{{ asset('toastr/toastr.js') }}"></script>
@endif

<script src="{{ asset('assets/sweetalert/sweetalert2@10.js') }}"></script>

{{-- js custom (berisi handler #buttonLogout: konfirmasi SweetAlert -> /logout) --}}
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/lib/swal.js') }}"></script>
{{-- md5 hash for jquery --}}
<script src="{{ asset('assets/js/md5.js') }}"></script>

{{-- Auto-include js per halaman: public/js/<nama-route>.js (pola project asli) --}}
@if (!empty($currentRouteName))
    @if (file_exists(public_path() . '/js/' . explode('.', $currentRouteName)[0] . '.js'))
        <script src="{{ asset('js/' . explode('.', $currentRouteName)[0] . '.js') }}"></script>
    @endif
@endif

<script>
    // Pencarian menu sidebar (pola cariMenuSidebar project asli)
    function cariMenuSidebar() {
        var filter = document.getElementById('mySearch').value.toUpperCase();
        document.querySelectorAll('#myMenu > .nav-item').forEach(function (li) {
            if (li.querySelector('#mySearch')) return;
            var text = li.textContent || li.innerText;
            li.style.display = text.toUpperCase().indexOf(filter) > -1 ? '' : 'none';
        });
    }
</script>
@yield('scripts')

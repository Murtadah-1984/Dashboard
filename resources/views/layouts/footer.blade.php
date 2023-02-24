   <!-- Main Footer -->
   <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        {{ config('dashboard.company_sologon')}}
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ now()->format('Y') }} <a href="{{ config('dashboard.company_url')}}">{{ config('dashboard.company_name')}}</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@vite('resources/js/app.js')
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}" defer></script>
<!-- Chart JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<!--Select2-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Datatables -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/jszip-2.5.0/dt-1.13.2/af-2.5.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/date-1.3.0/fh-3.3.1/kt-2.8.1/r-2.4.0/sp-2.1.1/datatables.min.js"></script>
<!-- Additional Scripts -->
@yield('scripts')
</body>
</html>

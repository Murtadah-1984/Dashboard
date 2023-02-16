   <!-- Main Footer -->
   <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        {{ config('dashboard.company_sologon')}}
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ Carbon\Carbon::now()->format('Y')}} <a href="{{ config('dashboard.company_url')}}">{{ config('dashboard.company_name')}}</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@vite('resources/js/app.js')
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@yield('scripts')
</body>
</html>

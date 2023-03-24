@include('layouts.head')

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('layouts.navbar')

    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    @include('layouts.sidecontrol')
    <!-- /.control-sidebar -->

 @include('layouts.footer')

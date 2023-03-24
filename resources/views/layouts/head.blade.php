<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- flags -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
    <!-- datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/jszip-2.5.0/dt-1.13.2/af-2.5.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/date-1.3.0/fh-3.3.1/kt-2.8.1/r-2.4.0/sp-2.1.1/datatables.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.3/codemirror.min.css">
    <!--Select2-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
    <script type="text/javascript">
        /**
         * Creates a new Select2 instance on the element with the given ID,
         * with remote data loading from the specified URL.
         *
         * @param {string} id - The ID of the element to attach Select2 to.
         * @param {string} [placeHolder=''] - The placeholder text to display in the Select2 field.
         * @param {string} [url=''] - The URL to load data from via AJAX.
         * @returns {jQuery} - The Select2 instance.
         * @throws {Error} - If any of the input arguments are invalid.
         */
        function makeSelector(id,placeHolder,url){
            return $(id).select2({
               theme: "classic",
               placeholder: placeHolder,
               ajax: {
                   url: url,
                   dataType: 'json',
                   delay: 250,
                   processResults: function (data) {
                       return {
                           results: $.map(data, function (item) {
                               return {
                                   text: item.text,
                                   id: item.id
                               }
                           })
                       }
                   },
                   cache: true
               }
           });
        }
    </script>
    @vite('resources/css/app.css')
     <!-- Additional Styles -->
    @yield('styles')
</head>
<body class="sidebar-mini layout-fixed control-sidebar-slide-open " style="height: auto;">

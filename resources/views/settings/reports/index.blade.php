@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Reports') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div id="event_info" class="box"></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div id="card-search"></div>
                            <div class="card-tools">
                                @can('scope_reports')
                                    <select class="btn btn-iframe-close" id="scope-select">
                                        <option value="">Select a scope...</option>
                                    </select>
                                @endcan
                                @can('export_reports')
                                    <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export Options
                                    </a>
                                    <div  id="actions" class="dropdown-menu" aria-labelledby="dropdownMenuLink"></div>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-xl">
                                <table class="table table-striped table-bordered hover" id="dataTable">
                                    <thead>
                                        <tr class="bg-gradient-gray-dark font-weight-bold">
                                            <td class="text-center">#</td>
                                            <td class="text-center">User</td>
                                            <td class="text-center">Task</td>
                                            <td class="text-center">Details</td>
                                            <td class="text-center">Date</td>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="bg-gradient-gray-dark font-weight-bold">
                                            <td class="text-center">#</td>
                                            <td class="text-center">User</td>
                                            <td class="text-center">Task</td>
                                            <td class="text-center">Details</td>
                                            <td class="text-center">Date</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div><!-- ./ Card Modal-->
                </div>
            </div>
            <!-- /.row -->
            <div class="row text-center">
                <a href="javascript:" class="img-circle elevation-2 bg-gradient-gray-dark p-2 m-4" id="return-to-top" style="display: block; cursor: pointer;"><i class="fas fa-chevron-up"></i></a>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
        /**
         * ------------------------------------------
         * --------------------------------------------
         * Render DataTable
         * --------------------------------------------
         * --------------------------------------------
         */
        const table = $('#dataTable').DataTable({responsive: true, serverSide: true, processing: true, pageLength: 10, stateSave: true, colReorder: true, fixedColumns: true, fixedHeader: true, select: true, dom: 'lBfrtip',order: [[1, 'asc']],
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100],], buttons: [@can('export_reports')'copyHtml5','excelHtml5','pdfHtml5','print'@endcan],

            ajax: "{{ route('reports.index') }}",
            columns: [
                {data: 'id', name: 'id', className: 'text-center align-middle', width: "1%" },
                {data: 'user', name: 'user', className: 'text-center align-middle'},
                {data: 'task', name: 'details', className: 'text-center align-middle'},
                {data: 'details', name: 'details', className: 'text-center align-middle'},
                {data: 'created_at', name: 'created_at', className: 'text-center align-middle'},

            ],
        });
        table.buttons().container().appendTo( $('#actions'));

    </script>
@endsection

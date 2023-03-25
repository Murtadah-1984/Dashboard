@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Users') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-center my-4">
                <div class="spinner-border" role="status" id="spinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                @can('scope_users')
                                    <select class="btn btn-iframe-close" id="scope-select">
                                        <option value="">Select a scope...</option>
                                    </select>
                                @endcan
                                @can('export_users')
                                    <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export Options
                                    </a>
                                    <div  id="actions" class="dropdown-menu" aria-labelledby="dropdownMenuLink"></div>
                                @endcan
                                    <button type="button" class="btn btn-outline-primary" id="select-toggle"><i class="far fa-square"></i></button>
                                @can('forceDelete_users')
                                    <button type="button" class="btn btn-outline-danger" onclick="massForceDelete('User')"><i class="fas fa-trash"></i></button>
                                @endcan
                                @can('delete_users')
                                    <button type="button" class="btn btn-outline-danger" onclick="massDestroy('User')"><i class="fas fa-trash-alt"></i></button>
                                @endcan
                                @can('restore_users')
                                    <button type="button" class="btn btn-outline-success" onclick="massRestore('User')"><i class="fas fa-trash-restore"></i></button>
                                @endcan
                                @can('add_users')
                                    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#addModel"><i class="fas fa-plus"></i></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-xl">
                                <table class="table table-striped table-bordered hover" id="TabledataTable">
                                    <thead>
                                        <tr class="bg-gradient-gray-dark font-weight-bold">
                                            <td class="text-center"></td>
                                            <td class="text-center">#</td>
                                            <td class="text-center">Name</td>
                                            <td class="text-center">Email</td>
                                            <td class="text-center">Role</td>
                                            <td class="text-center">Roles</td>
                                            <td class="text-center">Actions</td>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="bg-gradient-gray-dark font-weight-bold">
                                            <td class="text-center"></td>
                                            <td class="text-center">#</td>
                                            <td class="text-center">Name</td>
                                            <td class="text-center">Email</td>
                                            <td class="text-center">Role</td>
                                            <td class="text-center">Roles</td>
                                            <td class="text-center">Actions</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div><!-- ./ Card Modal-->
                </div>
                @include('users.edit')
                @include('users.add')
                @include('users.view')

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
        const table =createDataTable({!! $columns !!})
    </script>
@endsection

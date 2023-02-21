@extends('layouts.app')

@section('styles')

@endsection
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Users Table</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUser"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered hover" id="usersTable">
                                    <thead>
                                        <tr class="">
                                            <td class="">User</td>
                                            <td class="">Roles</td>
                                            <td class="">Actions</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr @if($user->deleted_at) class="table-danger" @endif >
                                                <td class=""><b>{{ $user->name }} </b></br> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                                <td class=""><b>{{ $user->role->display_name }}</b> </br> 
                                                    @foreach($user->roles as $role )
                                                        {{ $role->display_name }} </br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <div class="margin">
                                                        @can('viewAny', $user)
                                                            <button type="button" class="btn btn-warning mb-2" data-id="{{$user->id}}"><i class="fas fa-eye"></i></button>
                                                        @endcan

                                                        @can('viewAny', $user)
                                                            <button type="button" class="btn btn-info mb-2" data-id="{{$user->id}}"><i class="fas fa-user-edit"></i></button>
                                                        @endcan

                                                        @can('update', $user)
                                                            <button type="button" class="btn btn-secondary mb-2" href="{{ route('disable.user', $user->id ) }}"><i class="fas fa-user-slash"></i></button>
                                                        @endcan

                                                        @can('update', $user)
                                                            <button type="button" class="btn btn-primary mb-2" data-id="{{$user->id}}"><i class="fas fa-user-lock"></i></button>
                                                        @endcan

                                                        @can('restore', $user)
                                                            <button type="button" class="btn btn-success mb-2" href="{{ action('\App\Http\Controllers\UserController@restore', $user->id) }}"><i class="fas fa-trash-restore"></i></button>
                                                        @endcan

                                                        @can('delete', $user)
                                                            <form class="btn mt-0" action="{{ route('users.destroy', $user->id ) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger mb-2" ><i class="fas fa-user-times"></i></button>
                                                            </form>
                                                        @endcan

                                                        
                        
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="card-footer clearfix">
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    @include('users.view')
    @include('users.add')
    @include('users.edit')
@endsection
@section('scripts')

<script>
$('#usersTable').DataTable( {
    @can('export', 'App\Models\User')
    dom: 'Bfrtip',
    buttons: [
       'print','copy', 'excel', 'pdf'
   ]
   @endcan
} );
</script>
<script>
    $('#additionalRoles').select2();
</script>


@endsection
@if(is_null($data->deleted_at))
    @can('read_users')
        <button type="button" class="btn btn-sm btn-warning mb-2"  data-toggle="modal" data-target="#viewModel" onClick="view('{{ $data->id }}')"><i class="fas fa-eye"></i></button>
    @endcan
@endif

@if(is_null($data->deleted_at))
    @can('edit_users')
        <button type="button" class="btn btn-sm btn-info mb-2"  data-toggle="modal" id="editBtn" data-target="#editModel" onClick="edit('{{ $data->id }}')"><i class="fas fa-user-edit"></i></button>
    @endcan
@endif

@if(is_null($data->deleted_at))
    @can('edit_users')
        <button type="button" class="btn btn-sm btn-secondary mb-2" onClick="disable('{{ $data->id }}')"><i class="fas fa-user-slash"></i></button>
    @endcan
@endif

@if(is_null($data->deleted_at))
    @can('edit_users')
        <div class="dropdown btn mx-0 px-0">
            <button type="button" class="btn btn-sm btn-primary mb-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-id="{{$data->id}}"><i class="fas fa-user-lock"></i></button>
            <div class="dropdown-menu align-content-center pull-left">
                <form class="form-inline p-3">
                    <div class="form-group mb-2">
                        <input type="password" class="form-control" placeholder="New Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Change</button>
                </form>
            </div>
        </div>
    @endcan
@endif

@if(!is_null($data->deleted_at))
    @can('restore_users')
        <button type="submit" class="btn btn-sm btn-outline-success mb-2" onClick="restore('{{$data->id}}','User')"><i class="fas fa-trash-restore"></i></button>
    @endcan
@endif

@if(is_null($data->deleted_at))
    @can('delete_users')
        <button type="submit" class="btn btn-sm btn-outline-danger mb-2" onClick="destroy('{{$data->id}}','User')"><i class="fas fa-user-times"></i></button>
    @endcan
@endif

@if(!is_null($data->deleted_at))
    @can('forceDelete_users')
        <button type="submit" class="btn btn-sm btn-danger mb-2" onClick="forceDelete('{{$data->id}}','User')"><i class="fas fa-user-times"></i></button>
    @endcan
@endif

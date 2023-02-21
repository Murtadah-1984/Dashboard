@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard Configrations</h1>
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
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <strong>{{$message}}</strong>
                    </div>
                @endif
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Dashboard Configration</h3>
                    </div>
                    
                    
                    <form action="{{ route('dashboard.setting') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="company_fullname">Full Company Name</label>
                                <input type="text" class="form-control" id="company_fullname" name="dashboard.company_fullname" placeholder="{{ config('dashboard.company_fullname')}}">
                            </div>
                            <div class="form-group">
                                <label for="company_name">Short Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="dashboard.company_name" placeholder="{{ config('dashboard.company_name')}}">
                            </div>
                            <div class="form-group">
                                <label for="company_url">Company Url</label>
                                <input type="text" class="form-control" id="company_url" name="dashboard.company_url" placeholder="{{ config('dashboard.company_url')}}">
                            </div>
                            <div class="form-group">
                                <label for="company_email">Company Email</label>
                                <input type="text" class="form-control" id="company_email" name="dashboard.company_email" placeholder="{{ config('dashboard.company_email')}}">
                            </div>
                            <div class="form-group">
                                <label for="time_zone" >Time Zone</label>
                                <input type="text" class="form-control" id="time_zone"  name="dashboard.time_zone" placeholder="{{ config('dashboard.time_zone')}}">
                            </div>
                            <div class="form-group">
                                <label for="company_sologon" >Company Sologon</label>
                                <input type="text" class="form-control" id="company_sologon" name="dashboard.company_sologon" placeholder="{{ config('dashboard.company_sologon')}}">
                            </div>
                        </div>
                            
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-6">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Company Banner</h3>
                        </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <img src="{{ asset(config('dashboard.company_banner')) }}" alt="banner" class="img-fluid">
                                    <div class="ribbon-wrapper ribbon-sm">
                                        <div class="ribbon bg-success text-sm">
                                            Banner
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="card-footer">
                                <form action="{{ route('dashboard.banner') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="banner">Upload Banner</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="banner" name="banner">
                                                <label class="custom-file-label" for="banner">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" type="submit">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </form>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Company Logo</h3>
                        </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <img src="{{ asset(config('dashboard.company_logo'))}}" alt="logo" class="img-fluid">
                                    <div class="ribbon-wrapper ribbon-sm">
                                        <div class="ribbon bg-success text-sm">
                                            Logo
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="card-footer">
                                <form>
                                    <div class="form-group">
                                        <label for="logo">Upload Logo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="logo" name="logo">
                                                <label class="custom-file-label" for="logo">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


@endsection
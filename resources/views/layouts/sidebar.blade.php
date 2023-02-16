    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <img src="{{ asset(config('dashboard.logo_path)) }}" alt="{{ config('dashboard.company_fullname')}}Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('dashboard.company_fullname')}}</span>
        </a>

        @include('layouts.navigation')
    </aside>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>
            @foreach(App\Helpers\Menu::menu() as $menuItem)
            @if(!is_null($menuItem->model))
            @can('viewAny',$menuItem->model)
            @endif
            <li class="nav-item">
                <a href="{{ (!$menuItem->children->isEmpty()? '#' : route($menuItem->route) )  }}" class="nav-link">
                    <i class="nav-icon {{ $menuItem->class }} nav-icon"></i>
                    <p>
                        {{ $menuItem->title}}
                        @if(!$menuItem->children->isEmpty())
                        <i class="fas fa-angle-left right"></i>
                        @endif
                    </p>
                </a>
                @if(!$menuItem->children->isEmpty())
                <ul class="nav nav-treeview" style="display: none;">
                    @foreach($menuItem->children as $child)
                        @can('viewAny',$child->model)
                            <li class="nav-item">
                                <a href="{{ route($child->route) }}" class="nav-link">
                                    <i class="{{ $child->class}} nav-icon"></i>
                                    <p>{{ $child->title}}</p>
                                </a>
                            </li>
                        @endcan
                    @endforeach
                </ul>
                @endif
            </li>
            @if(!is_null($menuItem->model))
            @endcan
            @endif
            @endforeach
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
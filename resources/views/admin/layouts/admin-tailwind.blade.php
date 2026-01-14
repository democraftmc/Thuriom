<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="@if(dark_theme())dark@else light@endif">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') | {{ site_name() }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ favicon() }}">

    <!-- Scripts -->
    <script src="{{ asset('vendor/admin.js') }}" defer></script>

    <!-- Page level scripts -->
    @stack('scripts')

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Inter:300,400,600,800&display=swap" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('vendor/admin.css') }}" rel="stylesheet">
    @stack('styles')
    
    <style>
        /* Custom styles for admin sidebar and layout */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 16rem;
            overflow-y: auto;
        }
        
        .admin-main {
            margin-left: 16rem;
            min-height: 100vh;
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-base-100">
    <!-- Page Wrapper -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="admin-sidebar bg-base-200 shadow-lg z-50">
            <div class="p-4">
                <!-- Brand -->
                <a class="flex items-center justify-center py-4 border-b border-base-300" href="{{ route('home') }}">
                    <div class="text-center">
                        <img src="{{ asset('svg/azuriom-text-white.svg') }}" alt="Azuriom" class="max-w-[150px] mx-auto">
                        <small class="block text-center font-bold text-xs mt-2 opacity-70">
                            {{ game()->name() }} - v{{ Azuriom::version() }}
                        </small>
                    </div>
                </a>

                <!-- Navigation -->
                <ul class="menu p-0 mt-4 gap-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ add_active('admin.dashboard', 'active') }}">
                            <i class="bi bi-speedometer"></i>
                            {{ trans('admin.nav.dashboard') }}
                        </a>
                    </li>

                    @canany(['admin.settings', 'admin.navbar', 'admin.servers'])
                        <li class="menu-title text-xs font-semibold uppercase opacity-60 mt-4">
                            {{ trans('admin.nav.settings.heading') }}
                        </li>
                    @endcanany

                    <!-- Settings Dropdown -->
                    @can('admin.settings')
                        <li>
                            <details @if(Route::is('admin.settings.*', 'admin.social-links.*')) open @endif>
                                <summary>
                                    <i class="bi bi-gear"></i>
                                    {{ trans('admin.nav.settings.heading') }}
                                </summary>
                                <ul>
                                    <li><a href="{{ route('admin.settings.index') }}" class="{{ add_active('admin.settings.index', 'active') }}">{{ trans('admin.nav.settings.global') }}</a></li>
                                    <li><a href="{{ route('admin.settings.home') }}" class="{{ add_active('admin.settings.home', 'active') }}">{{ trans('admin.nav.settings.home') }}</a></li>
                                    @if(! oauth_login())
                                        <li><a href="{{ route('admin.settings.auth') }}" class="{{ add_active('admin.settings.auth', 'active') }}">{{ trans('admin.nav.settings.auth') }}</a></li>
                                    @endif
                                    <li><a href="{{ route('admin.settings.mail') }}" class="{{ add_active('admin.settings.mail', 'active') }}">{{ trans('admin.nav.settings.mail') }}</a></li>
                                    <li><a href="{{ route('admin.settings.performance') }}" class="{{ add_active('admin.settings.performance', 'active') }}">{{ trans('admin.nav.settings.performances') }}</a></li>
                                    <li><a href="{{ route('admin.settings.maintenance') }}" class="{{ add_active('admin.settings.maintenance', 'active') }}">{{ trans('admin.nav.settings.maintenance') }}</a></li>
                                    <li><a href="{{ route('admin.social-links.index') }}" class="{{ add_active('admin.social-links.*', 'active') }}">{{ trans('admin.nav.settings.social') }}</a></li>
                                </ul>
                            </details>
                        </li>
                    @endcan

                    @can('admin.navbar')
                        <li>
                            <a href="{{ route('admin.navbar-elements.index') }}" class="{{ add_active('admin.navbar-elements.*', 'active') }}">
                                <i class="bi bi-list"></i>
                                {{ trans('admin.nav.settings.navbar') }}
                            </a>
                        </li>
                    @endcan

                    @can('admin.servers')
                        <li>
                            <a href="{{ route('admin.servers.index') }}" class="{{ add_active('admin.servers.*', 'active') }}">
                                <i class="bi bi-hdd-network"></i>
                                {{ trans('admin.nav.settings.servers') }}
                            </a>
                        </li>
                    @endcan

                    <!-- Users Section -->
                    @canany(['admin.users', 'admin.roles'])
                        <li class="menu-title text-xs font-semibold uppercase opacity-60 mt-4">
                            {{ trans('admin.nav.users.heading') }}
                        </li>
                    @endcanany

                    @can('admin.users')
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="{{ add_active('admin.users.*', 'active') }}">
                                <i class="bi bi-people"></i>
                                {{ trans('admin.nav.users.users') }}
                            </a>
                        </li>
                    @endcan

                    @can('admin.roles')
                        <li>
                            <a href="{{ route('admin.roles.index') }}" class="{{ add_active('admin.roles.*', 'active') }}">
                                <i class="bi bi-person-badge"></i>
                                {{ trans('admin.nav.users.roles') }}
                            </a>
                        </li>
                    @endcan

                    @can('admin.users')
                        <li>
                            <a href="{{ route('admin.bans.index') }}" class="{{ add_active('admin.bans.*', 'active') }}">
                                <i class="bi bi-person-x"></i>
                                {{ trans('admin.nav.users.bans') }}
                            </a>
                        </li>
                    @endcan

                    <!-- Content Section -->
                    @canany(['admin.pages', 'admin.posts', 'admin.images', 'admin.redirects'])
                        <li class="menu-title text-xs font-semibold uppercase opacity-60 mt-4">
                            {{ trans('admin.nav.content.heading') }}
                        </li>
                    @endcanany

                    @can('admin.pages')
                        <li>
                            <a href="{{ route('admin.pages.index') }}" class="{{ add_active('admin.pages.*', 'active') }}">
                                <i class="bi bi-file-earmark"></i>
                                {{ trans('admin.nav.content.pages') }}
                            </a>
                        </li>
                    @endcan

                    @can('admin.posts')
                        <li>
                            <a href="{{ route('admin.posts.index') }}" class="{{ add_active('admin.posts.*', 'active') }}">
                                <i class="bi bi-newspaper"></i>
                                {{ trans('admin.nav.content.posts') }}
                            </a>
                        </li>
                    @endcan

                    @can('admin.images')
                        <li>
                            <a href="{{ route('admin.images.index') }}" class="{{ add_active('admin.images.*', 'active') }}">
                                <i class="bi bi-image"></i>
                                {{ trans('admin.nav.content.images') }}
                            </a>
                        </li>
                    @endcan

                    @can('admin.redirects')
                        <li>
                            <a href="{{ route('admin.redirects.index') }}" class="{{ add_active('admin.redirects.*', 'active') }}">
                                <i class="bi bi-signpost"></i>
                                {{ trans('admin.nav.content.redirects') }}
                            </a>
                        </li>
                    @endcan

                    <!-- Extensions Section -->
                    @canany(['admin.plugins', 'admin.themes'])
                        <li class="menu-title text-xs font-semibold uppercase opacity-60 mt-4">
                            {{ trans('admin.nav.extensions.heading') }}
                        </li>
                    @endcan

                    @can('admin.plugins')
                        <li>
                            <a href="{{ route('admin.plugins.index') }}" class="flex justify-between {{ add_active('admin.plugins.*', 'active') }}">
                                <span class="flex items-center gap-2">
                                    <i class="bi bi-puzzle"></i>
                                    {{ trans('admin.nav.extensions.plugins') }}
                                </span>
                                @if(($pluginsUpdates ?? 0) > 0)
                                    <span class="badge badge-error badge-sm">{{ $pluginsUpdates }}</span>
                                @endif
                            </a>
                        </li>
                    @endcan

                    @can('admin.themes')
                        <li>
                            <a href="{{ route('admin.themes.index') }}" class="flex justify-between {{ add_active('admin.themes.*', 'active') }}">
                                <span class="flex items-center gap-2">
                                    <i class="bi bi-brush"></i>
                                    {{ trans('admin.nav.extensions.themes') }}
                                </span>
                                @if(($themesUpdates ?? 0) > 0)
                                    <span class="badge badge-error badge-sm">{{ $themesUpdates }}</span>
                                @endif
                            </a>
                        </li>
                    @endcan

                    <!-- Plugin Nav Items -->
                    @if(! plugins()->getAdminNavItems()->isEmpty())
                        <li class="menu-title text-xs font-semibold uppercase opacity-60 mt-4">Plugins</li>
                    @endif

                    @foreach(plugins()->getAdminNavItems() as $navId => $navItem)
                        @if(! isset($navItem['permission']) || Gate::any($navItem['permission']))
                            @if(($navItem['type'] ?? '') !== 'dropdown')
                                <li>
                                    <a href="{{ route($navItem['route']) }}" class="{{ isset($navItem['route']) ? add_active($navItem['route'], 'active') : '' }}">
                                        <i class="{{ $navItem['icon'] }}"></i>
                                        {{ $navItem['name'] }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <details @if(isset($navItem['route']) && Route::is($navItem['route'])) open @endif>
                                        <summary>
                                            <i class="{{ $navItem['icon'] }}"></i>
                                            {{ $navItem['name'] }}
                                        </summary>
                                        <ul>
                                            @foreach($navItem['items'] ?? [] as $route => $subItem)
                                                @if(! isset($subItem['permission']) || Gate::check($subItem['permission']))
                                                    <li>
                                                        <a href="{{ route($route) }}" class="{{ add_active($route, 'active') }}">
                                                            {{ is_array($subItem) ? $subItem['name'] : $subItem }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </details>
                                </li>
                            @endif
                        @endif
                    @endforeach

                    <!-- Other Section -->
                    @canany(['admin.update', 'admin.logs'])
                        <li class="menu-title text-xs font-semibold uppercase opacity-60 mt-4">
                            {{ trans('admin.nav.other.heading') }}
                        </li>
                    @endcanany

                    @can('admin.update')
                        <li>
                            <a href="{{ route('admin.update.index') }}" class="flex justify-between {{ add_active('admin.update.*', 'active') }}">
                                <span class="flex items-center gap-2">
                                    <i class="bi bi-cloud-download"></i>
                                    {{ trans('admin.nav.other.update') }}
                                </span>
                                @if($hasUpdate)
                                    <span class="badge badge-error badge-sm">1</span>
                                @endif
                            </a>
                        </li>
                    @endcan

                    @can('admin.logs')
                        <li>
                            <a href="{{ route('admin.logs.index') }}" class="{{ add_active('admin.logs.*', 'active') }}">
                                <i class="bi bi-clock-history"></i>
                                {{ trans('admin.nav.other.logs') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="admin-main flex-1">
            <!-- Top Navigation Bar -->
            <nav class="navbar bg-base-100 shadow-md">
                <div class="flex-none lg:hidden">
                    <label for="sidebar-drawer" class="btn btn-square btn-ghost">
                        <i class="bi bi-list text-xl"></i>
                    </label>
                </div>
                
                <div class="flex-1 px-2">
                    <div class="hidden sm:flex gap-2">
                        <a href="https://azuriom.com/discord" class="btn btn-outline btn-primary btn-sm" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-question-circle"></i>
                            {{ trans('admin.nav.support') }}
                        </a>
                        <a href="https://azuriom.com/docs" class="btn btn-outline btn-secondary btn-sm" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-journals"></i>
                            {{ trans('admin.nav.documentation') }}
                        </a>
                    </div>
                </div>

                <div class="flex-none gap-2">
                    <!-- Notifications Dropdown -->
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle">
                            <div class="indicator">
                                <i class="bi bi-bell"></i>
                                @if(! $notifications->isEmpty())
                                    <span class="badge badge-sm badge-primary indicator-item" id="notificationsCounter">{{ $notifications->count() }}</span>
                                @endif
                            </div>
                        </label>
                        <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-80 bg-base-100 shadow-xl">
                            <div class="card-body">
                                <span class="font-bold text-lg">{{ trans('messages.notifications.notifications') }}</span>
                                @if(! $notifications->isEmpty())
                                    <div id="notifications" class="space-y-2">
                                        @foreach($notifications as $notification)
                                            <a href="{{ $notification->link ? url($notification->link) : '#' }}" class="block p-2 hover:bg-base-200 rounded">
                                                <div class="flex gap-2">
                                                    <div class="text-{{ $notification->level }}">
                                                        <i class="bi bi-{{ $notification->icon() }}"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="text-sm">{{ $notification->content }}</p>
                                                        <small class="text-xs opacity-60">{{ format_date($notification->created_at, true) }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="card-actions">
                                        <a href="{{ route('notifications.read.all') }}" id="readNotifications" class="btn btn-sm btn-block">
                                            {{ trans('messages.notifications.read') }}
                                        </a>
                                    </div>
                                @else
                                    <p class="text-success" id="noNotificationsLabel">
                                        <i class="bi bi-check-lg"></i> {{ trans('messages.notifications.empty') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Theme Toggle -->
                    <div class="form-control">
                        <label class="swap swap-rotate">
                            <input type="checkbox" @if(dark_theme()) checked @endif data-theme-toggle data-theme-url="{{ route('profile.theme') }}"/>
                            <i class="bi bi-sun-fill swap-on text-xl"></i>
                            <i class="bi bi-moon-stars-fill swap-off text-xl"></i>
                        </label>
                    </div>

                    <!-- User Menu Dropdown -->
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img src="{{ auth()->user()->getAvatar() }}" alt="{{ Auth::user()->name }}" />
                            </div>
                        </label>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                            <li class="menu-title">
                                <span>{{ Auth::user()->name }}</span>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.edit', Auth::user()) }}">
                                    <i class="bi bi-person-circle"></i>
                                    {{ trans('admin.nav.profile.profile') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}">
                                    <i class="bi bi-house"></i>
                                    {{ trans('admin.nav.back') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" data-route="logout">
                                    <i class="bi bi-box-arrow-right"></i>
                                    {{ trans('auth.logout') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-6">
                <h1 class="text-3xl font-bold mb-6">@yield('title', 'Admin')</h1>

                @include('admin.elements.session-alerts')

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="footer footer-center p-4 bg-base-200 text-base-content mt-auto">
                <div>
                    <p>
                        @lang('admin.footer', [
                            'year' => '2019-'.now()->year,
                            'azuriom' => '<a href="https://azuriom.com" target="_blank" rel="noopener noreferrer" class="link">Azuriom</a>',
                            'startbootstrap' => '<a href="https://adminkit.io/" target="_blank" rel="noopener noreferrer" class="link">AdminKit</a>'
                        ])
                    </p>
                </div>
            </footer>

            <!-- Delete Confirm Modal -->
            <dialog id="confirmDeleteModal" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">{{ trans('admin.delete.title') }}</h3>
                    <p class="py-4">{{ trans('admin.delete.description') }}</p>
                    <div class="modal-action">
                        <form id="confirmDeleteForm" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="button" class="btn" onclick="document.getElementById('confirmDeleteModal').close()">
                                <i class="bi bi-x-lg"></i> {{ trans('messages.actions.cancel') }}
                            </button>
                            <button type="submit" class="btn btn-error">
                                <i class="bi bi-exclamation-triangle"></i> {{ trans('messages.actions.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop">
                    <button>close</button>
                </form>
            </dialog>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    @stack('footer-scripts')

    <script>
        // Show delete confirmation modal
        document.addEventListener('click', function(e) {
            if (e.target.matches('[data-confirm-delete]')) {
                e.preventDefault();
                const form = document.getElementById('confirmDeleteForm');
                form.action = e.target.dataset.confirmDelete;
                document.getElementById('confirmDeleteModal').showModal();
            }
        });

        // Theme toggle handler
        document.addEventListener('change', function(e) {
            if (e.target.matches('[data-theme-toggle]')) {
                const url = e.target.dataset.themeUrl;
                if (url) {
                    window.location.href = url;
                }
            }
        });
    </script>
</body>
</html>

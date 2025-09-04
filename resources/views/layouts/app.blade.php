<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'AEMS - Association des Étudiants de Mitsoudjé au Sénégal')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/css/aems.css', 'resources/js/app.js'])
        {{-- <link rel="stylesheet" href="https://aems.up.railway.app/css/aems-inline.css"> --}}

    </head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="aems-sidebar aems-sidebar-gradient flex-shrink-0">
            <div class="aems-sidebar-content p-6">
                <!-- Logo AEMS -->
                <div class="text-center mb-8">
                    <div class="aems-logo aems-logo-shadow mb-4">
                                                        <img src="https://aems.up.railway.app/logo.jpg" alt="Logo AEMS" />
                    </div>
                    <div class="text-white">
                        <h1 class="text-lg font-bold mb-1">AEMS</h1>
                        <p class="text-xs text-white/80 leading-tight">
                            Association des Étudiants<br>
                            de Mitsoudjé au Sénégal
                        </p>
                        <p class="text-xs text-white/60 mt-2">
                            UNITÉ • SOLIDARITÉ • DÉVELOPPEMENT
                        </p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="aems-sidebar-nav">
                    <div class="space-y-1">
                        <a href="{{ route('home') }}" class="aems-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            <span class="aems-nav-icon">🏠</span>
                            <span>Accueil</span>
                        </a>
                        <a href="{{ route('about') }}" class="aems-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                            <span class="aems-nav-icon">ℹ️</span>
                            <span>À propos</span>
                        </a>
                        <a href="{{ route('photos') }}" class="aems-nav-link {{ request()->routeIs('photos') ? 'active' : '' }}">
                            <span class="aems-nav-icon">📸</span>
                            <span>Photos</span>
                        </a>
                        <a href="{{ route('videos') }}" class="aems-nav-link {{ request()->routeIs('videos') ? 'active' : '' }}">
                            <span class="aems-nav-icon">🎥</span>
                            <span>Vidéos</span>
                        </a>
                        
                        @auth
                            <div class="border-t border-white/20 my-4"></div>
                            <a href="{{ route('dashboard') }}" class="aems-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <span class="aems-nav-icon">📊</span>
                                <span>Tableau de bord</span>
                            </a>
                            
                            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                                <a href="{{ route('posts.index') }}" class="aems-nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}">
                                    <span class="aems-nav-icon">📝</span>
                                    <span>Articles</span>
                                </a>
                                <a href="{{ route('events.index') }}" class="aems-nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                                    <span class="aems-nav-icon">📅</span>
                                    <span>Événements</span>
                                </a>
                                <a href="{{ route('events.calendar') }}" class="aems-nav-link {{ request()->routeIs('events.calendar') ? 'active' : '' }}">
                                    <span class="aems-nav-icon">🗓️</span>
                                    <span>Calendrier</span>
                                </a>
                                <a href="{{ route('media.index') }}" class="aems-nav-link {{ request()->routeIs('media.*') ? 'active' : '' }}">
                                    <span class="aems-nav-icon">🎬</span>
                                    <span>Médias</span>
                                </a>
                            @endif

                            @if(auth()->check() && auth()->user()->isAdmin())
                                <div class="border-t border-white/20 my-4"></div>
                                <a href="{{ route('admin.dashboard') }}" class="aems-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <span class="aems-nav-icon">⚙️</span>
                                    <span>Administration</span>
                                </a>
                                <a href="{{ route('admin.users') }}" class="aems-nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                                    <span class="aems-nav-icon">👥</span>
                                    <span>Utilisateurs</span>
                                </a>
                                <a href="{{ route('admin.activity-logs') }}" class="aems-nav-link {{ request()->routeIs('admin.activity-logs*') ? 'active' : '' }}">
                                    <span class="aems-nav-icon">📊</span>
                                    <span>Logs d'activité</span>
                                </a>
                                <a href="{{ route('admin.settings') }}" class="aems-nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                                    <span class="aems-nav-icon">🔧</span>
                                    <span>Paramètres</span>
                                </a>
                            @endif
                        @endauth
                    </div>
                </nav>

                <!-- User Info -->
                <div class="border-t border-white/20 pt-4 mt-auto">
                    @auth
                        <div class="text-white text-sm mb-3">
                            <div class="font-semibold">{{ auth()->user()->name }}</div>
                            <div class="text-white/70 capitalize">{{ auth()->user()->role }}</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-white/70 hover:text-white text-sm py-2 px-3 rounded hover:bg-white/10 transition-colors">
                                Se déconnecter
                            </button>
                        </form>
                    @else
                        <div class="space-y-2">
                            <a href="{{ route('login') }}" class="aems-nav-link block text-center">
                                <span class="aems-nav-icon">🔑</span>
                                <span>Se connecter</span>
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="aems-nav-link block text-center">
                                    <span class="aems-nav-icon">📝</span>
                                    <span>S'inscrire</span>
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="aems-main-wrapper">
            <!-- Top Navigation -->
            <header class="aems-header shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold aems-text-green">
                                @yield('page-title', 'AEMS')
                            </h1>
                            @hasSection('page-subtitle')
                                <p class="text-sm text-gray-600 mt-1">@yield('page-subtitle')</p>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            @auth
                                <div class="flex items-center space-x-3">
                                    <div class="aems-user-avatar">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</div>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="aems-main-content p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    </body>
</html>
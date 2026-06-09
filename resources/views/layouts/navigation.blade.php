<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->role === 'admin' ? route('seller.orders.index') : route('menu.index') }}" class="flex items-center gap-2">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span class="font-black text-xl tracking-tight text-slate-900 hidden sm:block">Ingenio<span class="text-orange-500">Snack</span></span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        $activeClass = 'inline-flex items-center px-1 pt-1 border-b-2 border-orange-500 text-sm font-black text-slate-900 leading-5 transition duration-150 ease-in-out';
                        $inactiveClass = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-bold text-slate-500 hover:text-slate-800 hover:border-slate-300 leading-5 transition duration-150 ease-in-out';
                    @endphp

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('seller.orders.index') }}" class="{{ request()->routeIs('seller.orders.index') ? $activeClass : $inactiveClass }}">Monitor de Pedidos</a>
                        <a href="{{ url('/panel/categorias') }}" class="{{ request()->is('panel/categorias*') ? $activeClass : $inactiveClass }}">Categorías</a>
                        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? $activeClass : $inactiveClass }}">Productos</a>
                        <a href="{{ route('seller.finance.index') }}" class="{{ request()->routeIs('seller.finance.*') ? $activeClass : $inactiveClass }}">Caja y Finanzas</a>
                        <a href="{{ route('seller.reports') }}" class="{{ request()->routeIs('seller.reports') ? $activeClass : $inactiveClass }}">Reportes</a>
                        <a href="{{ route('seller.promotions.index') }}" class="{{ request()->routeIs('seller.promotions.*') ? $activeClass : $inactiveClass }}">Clientes fieles</a>
                        <a href="{{ route('seller.events.index') }}" class="{{ request()->routeIs('seller.events.*') ? $activeClass : $inactiveClass }}">Calendario IA</a>
                    @else
                        <a href="{{ route('menu.index') }}" class="{{ request()->routeIs('menu.index') ? $activeClass : $inactiveClass }}">Menú</a>
                        <a href="{{ route('client.orders') }}" class="{{ request()->routeIs('client.orders') ? $activeClass : $inactiveClass }}">Mis Pedidos</a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('cart.index') }}" class="relative text-slate-500 hover:text-orange-500 transition-colors flex items-center justify-center p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @if(session('cart'))
                            <span class="absolute top-0 right-0 bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full transform translate-x-1 -translate-y-1">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-slate-200 text-sm leading-4 font-bold rounded-xl text-slate-600 bg-white hover:bg-slate-50 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Mi Perfil') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500 font-bold">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-orange-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-orange-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-50 border-t border-slate-200 shadow-inner">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('seller.orders.index')" :active="request()->routeIs('seller.orders.index')">Monitor de Pedidos</x-responsive-nav-link>
                <x-responsive-nav-link :href="url('/panel/categorias')" :active="request()->is('panel/categorias*')">Categorías</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">Productos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.finance.index')" :active="request()->routeIs('seller.finance.*')">Caja y Finanzas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.reports')" :active="request()->routeIs('seller.reports')">Reportes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.promotions.index')" :active="request()->routeIs('seller.promotions.*')">Clientes fieles</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.events.index')" :active="request()->routeIs('seller.events.*')">Calendario IA</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('menu.index')" :active="request()->routeIs('menu.index')">Menú</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('client.orders')" :active="request()->routeIs('client.orders')">Mis Pedidos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="flex justify-between items-center">
                    Mi Carrito
                    @if(session('cart'))
                        <span class="bg-orange-500 text-white text-xs font-bold px-2.5 py-0.5 rounded-full">{{ count(session('cart')) }}</span>
                    @endif
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Mi Perfil') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500 font-bold">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
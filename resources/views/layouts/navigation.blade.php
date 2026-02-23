<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16">

            <!-- LEFT SIDE -->
            <div class="flex items-center gap-10">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden sm:flex items-center gap-8 text-sm font-medium">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('permintaan.create')" :active="request()->routeIs('permintaan.create')">
                        Permintaan
                    </x-nav-link>

                    <x-nav-link :href="route('permintaan.manage')" :active="request()->routeIs('permintaan.manage')">
                        Manage
                    </x-nav-link>

                    <x-nav-link :href="route('history.index')" :active="request()->routeIs('history.index')">
                        History
                    </x-nav-link>

                    <x-nav-link :href="route('permintaan.stock')" :active="request()->routeIs('permintaan.stock')">
                        Stock
                    </x-nav-link>

                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                            Admin
                        </x-nav-link>
                    @endif

                </div>
            </div>


            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex sm:items-center">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition">

                            <span>{{ Auth::user()->name }}</span>

                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>

                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>


            <!-- Mobile Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="p-2 rounded-md text-gray-500 hover:bg-gray-100 transition">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': !open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>

        </div>
    </div>


    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200 bg-white">

        <div class="px-6 py-4 space-y-3 text-sm">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('permintaan.create')" :active="request()->routeIs('permintaan.create')">
                Permintaan
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('permintaan.manage')" :active="request()->routeIs('permintaan.manage')">
                Manage
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('history.index')" :active="request()->routeIs('history.index')">
                History
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('permintaan.stock')" :active="request()->routeIs('permintaan.stock')">
                Stock
            </x-responsive-nav-link>

            @if(auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                    Admin
                </x-responsive-nav-link>
            @endif

            <div class="pt-4 border-t border-gray-200">
                <div class="text-gray-800 font-medium">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-gray-500 text-xs">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <x-responsive-nav-link :href="route('profile.edit')">
                Profile
            </x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                </x-responsive-nav-link>
            </form>

        </div>

    </div>

</nav>
<nav x-data="{ open: false }" class="bg-white bark:bg-gray-800 border-b border-gray-100 bark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 bark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Заработай') }}
                    </x-nav-link>

                    <x-nav-link :href="route('giveaway')" :active="request()->routeIs('giveaway')">
                        {{ __('Раздача робуксов') }}
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('referrals')" :active="request()->routeIs('referrals')">
                            {{ __('Пригласи друга') }}
                        </x-nav-link>

                        <x-nav-link :href="route('withdrawal.index')" :active="request()->routeIs('withdrawal.index')">
                            {{ __('Вывод робуксов') }}
                        </x-nav-link>

                        @if (Auth::user()->is_admin)
                            <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                                <i class="fa-solid fa-gear pr-2"></i>
                                {{ __('Administration') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bark:text-gray-400 bg-white bark:bg-gray-800 hover:text-gray-700 bark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <x-user-avatar />
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>


                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Мой профиль') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Выйти') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bark:text-gray-400 bg-white bark:bg-gray-800 hover:text-gray-700 bark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>Присоединяйся!</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('login')" :active="request()->routeIs('login')">
                                {{ __('Log in') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('login')" :active="request()->routeIs('register')">
                                {{ __('Register') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 bark:text-gray-500 hover:text-gray-500 bark:hover:text-gray-400 hover:bg-gray-100 bark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 bark:focus:bg-gray-900 focus:text-gray-500 bark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fa-solid fa-coins text-yellow-500 pr-2"></i>
                {{ __('Заработай') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('giveaway')" :active="request()->routeIs('giveaway')">
                <i class="fa-solid fa-gift text-red-500 pr-2"></i>
                {{ __('Раздача робуксов') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('referrals')" :active="request()->routeIs('referrals')">
                    <i class="fa-solid fa-user-plus text-blue-500 pr-2"></i>
                    {{ __('Пригласи друга') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('withdrawal.index')" :active="request()->routeIs('withdrawal.index')">
                    <i class="fa-solid fa-money-bill-transfer text-green-500 pr-2"></i>
                    {{ __('Вывод робуксов') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 bark:border-gray-600">
            @auth
                <div class="px-4">
                    <div class="flex flex-row items-center">
                        <x-user-avatar />
                        <div>
                            <div class="font-medium text-base text-gray-800 bark:text-gray-200">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>


                <div class="mt-3 space-y-1">
                    @if (Auth::user()->is_admin)
                        <x-responsive-nav-link :href="route('admin.index')">
                            <i class="fa-solid fa-gear pr-2"></i>
                            {{ __('Administration') }}
                        </x-responsive-nav-link>
                    @endif
                    <x-responsive-nav-link :href="route('profile.edit')">
                        <i class="fa-solid fa-address-card pr-2"></i>
                        {{ __('Мой профиль') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            {{ __('Выйти') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>

                </div>
            @endauth
        </div>
    </div>
</nav>

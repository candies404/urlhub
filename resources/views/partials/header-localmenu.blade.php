@php
    $routeName = request()->route()->getName();
@endphp

<nav class="pt-1">
    <div class="hidden layout-container sm:flex px-4 sm:px-6 lg:px-8 croll-smooth hover:scroll-auto">
        <a href="{{ route('dashboard') }}"
            class="mr-8 py-3 font-semibold hover:text-primary-700 transition duration-100 ease-in-out border-b-2 border-transparent
                {{ ($routeName === 'dashboard') ?
                'text-primary-700 !border-primary-500' :
                'text-black hover:border-primary-100' }}"
        >
            @svg('icon-dashboard', 'mr-1')
            <span class="@if ($routeName === 'dashboard') text-black @endif">{{ __('Dashboard') }}</span>
        </a>

        @role('admin')
            <a href="{{ route('dboard.allurl') }}"
                class="mr-8 py-3 font-semibold hover:text-primary-700 transition duration-100 ease-in-out border-b-2 border-transparent
                    {{ ($routeName === 'dboard.allurl') ?
                    'text-primary-700 !border-primary-500' :
                    'text-black hover:border-primary-100' }}"
            >
                @svg('icon-link', 'mr-1')
                <span class="@if ($routeName === 'dboard.allurl') text-black @endif">{{ __('URL List') }}</span>
            </a>
            <a href="{{ route('user.index') }}"
                class="mr-8 py-3 font-semibold hover:text-primary-700 transition duration-100 ease-in-out border-b-2 border-transparent
                    {{ ($routeName === 'user.index') ?
                    'text-primary-700 !border-primary-500' :
                    'text-black hover:border-primary-100' }}"
            >
                @svg('icon-people', 'mr-1')
                <span class="@if ($routeName === 'user.index') text-black @endif">{{ __('User List') }}</span>
            </a>
            <a href="{{ route('dboard.about') }}"
                class="mr-8 py-3 font-semibold hover:text-primary-700 transition duration-100 ease-in-out border-b-2 border-transparent
                    {{ ($routeName === 'dboard.about') ?
                    'text-primary-700 !border-primary-500' :
                    'text-black hover:border-primary-100' }}"
            >
                @svg('icon-about-system', 'mr-1')
                <span class="@if ($routeName === 'dboard.about') text-black @endif">{{ __('About') }}</span>
            </a>
        @endrole
    </div>
</nav>

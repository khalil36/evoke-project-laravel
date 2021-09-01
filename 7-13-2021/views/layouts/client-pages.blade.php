<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight w-1/2 inline">
            @yield('title')
        </h2>
        <div class="float-right">
            <x-jet-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <span class="inline-flex rounded-md">
                        <button type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                            Manage Provider Setup

                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </span>

                </x-slot>

                <x-slot name="content">
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage NPIs') }}
                    </div>

                    <x-jet-dropdown-link href="/import_npis">
                        {{ __('Import NPIs') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="/npis">
                        {{ __('View NPIs') }}
                    </x-jet-dropdown-link>

                    @can('manage users')
                        <div class="block px-4 py-2 text-xs text-gray-400">Media Partners</div>
                        <a href="/media_partners/create"
                           class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                            {{ __('Setup New Media Partner') }}
                        </a>
                        <a href="{{ route('admin') }}"
                           class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                            {{ __('Upload Media Partner ULD') }}
                        </a>
                        <div class="block px-4 py-2 text-xs text-gray-400">DoubleClick</div>
                        <a href="{{ route('admin') }}"
                           class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                            {{ __('Upload DCM Data') }}
                        </a>

                    @endcan

                </x-slot>
            </x-jet-dropdown>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(!Auth::user()->currentTeam->is_active )
                <div class="rounded-md bg-yellow-50 p-4 m-3">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Heroicon name: solid/exclamation -->
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                This Team is currently not active.
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>
                                    Please contact your evoke account manager.
                                </p>
                            </div>
                            @if(Auth::user()->hasTeamRole(Auth::user()->currentTeam, 'evoke_am') || Auth::user()->hasRole('Administrator'))
                                <div class=" text-sm mt-3 pl-5 border-2 border-dashed border-gray-200 rounded-lg">
                                    Private Evoke Note: The client will not see the below dashboard.  They will only be shown that the team is not currently active.  In order for them to see the tools the team will need to be active.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if (Gate::check('team-is-active', Auth::user()))

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                        @yield('client-content')



                    </div>
                </div>

            @endif

        </div>
    </div>
</x-app-layout>


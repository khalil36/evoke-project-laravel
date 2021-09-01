<?php
use Carbon\Carbon;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Administrators
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="max-w-lg mx-auto px-6">
                <ul class="divide-y divide-gray-200">
                    @foreach($user->authentications()->get() as $item)
                        @if(!is_null($item->login_at))
                            <li class="py-4">
                                <div class="flex space-x-3">
                                    <img class="h-6 w-6 rounded-full" src="{{ $user->getGravatarURL() }}"
                                         alt="{{ $user->name }}">
                                    <div class="flex-1 space-y-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-medium">{{$user->name}}</h3>
                                            <p class="text-sm text-gray-500 has-tooltip">
                                                {{ (new Carbon($item->login_at))->diffForHumans() }}
                                                <span class='tooltip relative z-10 p-2 -ml-10 text-xs leading-none text-white whitespace-no-wrap bg-black shadow-lg -mt-8'>
                                                    {{ $item->login_at }} UTC
                                                </span>
                                            </p>
                                        </div>
                                        <span class='text-sm text-gray-500 has-tooltip'>
                                            Logged In from {{$item->ip_address}}
                                            <span class='tooltip relative z-10 p-2 -ml-10 text-xs leading-none text-white whitespace-no-wrap bg-black shadow-lg -mt-8'>
                                                {{$item->user_agent}}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                    <!-- More items... -->
                </ul>
            </div>
        </div>
    </div>

</x-app-layout>
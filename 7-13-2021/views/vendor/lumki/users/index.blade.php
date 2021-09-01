<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('lumki::ui.manage_users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Last Logged In
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="{{ $user->getGravatarURL() }}" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->lastLoginAt()  }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Active
                </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->getRoleNames()->join(", ") }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('lumki.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a> |
                                            <a href="{{ route('impersonate', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">Impersonate</a>
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- More people... -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


           {{-- <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="space-y-10">
                    <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                        <div class="space-y-6">
                        @foreach ($users as $user)

                                <div class="flex items-center justify-between">
                                    <div>
                                        {{ $user->name }}
                                    </div>
                                    <div>
                                        {{ $user->getRoleNames()->join(", ") }}
                                    </div>


                                    <div class="flex items-center">
                                        <div>
                                            {{ $user->getTeamNames()->join(", ") }}
                                        </div>
                                        <div>
                                            {{ $user->lastLoginAt() }}
                                        </div>
                                        <button class="cursor-pointer ml-6 text-sm text-blue-500 focus:outline-none">
                                            <a href="{{ route('lumki.users.edit', $user) }}">{{ __('lumki::ui.edit_roles') }}</a>
                                        </button>
                                        <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none">
                                            <a href="{{ route('impersonate', $user->id) }}">{{ __('lumki::ui.impersonate') }}</a>
                                        </button>
                                    </div>
                                </div>

                        @endforeach
                        </div>

                    </div>
                </div>
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                    {{ $users->links() }}
                </div>
            </div>--}}
        </div>
    </div>

</x-app-layout>

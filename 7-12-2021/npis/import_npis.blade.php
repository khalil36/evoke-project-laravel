<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import NPIs') }}
        </h2>
    </x-slot>

    <div>
        
         @if(Session::has('Error'))
        <div class="rounded-md bg-red-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <!-- Heroicon name: solid/x-circle -->
              <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">
                ERROR! In Importing File
              </h3>
              <div class="mt-2 text-sm text-red-700">
                <p>
                  {{Session::get('Error')}}
                </p>
              </div>
            </div>
          </div>
        </div>
         @endif

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('import-npis-form')
        </div>
    </div>
</x-app-layout>







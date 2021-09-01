<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import NPIs') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if(Session::has('success'))
            <div class="rounded-md bg-green-50 p-4">
              <div class="flex">
                <div class="flex-shrink-0">
                  <!-- Heroicon name: solid/check-circle -->
                  <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  </svg>
                </div>
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-green-800">
                    NPIS Imported
                  </h3>
                  <div class="mt-2 text-sm text-green-700">
                    <p>
                      {{Session::get('success')}}
                    </p>
                    @if(Session::has('existing_team_ids'))
                      <p>
                        <p>Below Team IDs data is not imported, because these Team IDs are already exists in the system.</p>
                        <span class="text-red-500">(
                        @foreach(Session::get('existing_team_ids') as $ID )
                          <span>{{$ID}}, </span>
                        @endforeach
                        )</span>
                      </p>
                    @endif
                    <p>
                    
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <br>
            @endif

            @livewire('import-npis-form')
        </div>
    </div>
</x-app-layout>







@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

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
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200" style="width: 80%;">
              <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NPI</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Decile</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created at</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                </tr>
              </thead>
              <tbody>
                @php $count = 1; @endphp
                @if($npis)
                  @foreach ($npis as $npis)
                      <tr class="{{ ($count%2==0) ? 'bg-gray-50' : 'bg-white' }}">
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npis->npi }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npis->first_name }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npis->last_name }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npis->email }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npis->decile }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npis->created_at }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npis->name }}</td>
                      </tr>
                      @php $count++ ; @endphp
                  @endforeach
                @else
                  <tr class="bg-white">
                    <td>There is no data yet!</td>
                  </tr>
                @endif

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

@endsection


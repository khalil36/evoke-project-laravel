@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

@php 
  
  $fade_message = 'fade-message';
  if(Session::has('existing_npis')){
    $fade_message = 'no-fade-message';
  }

@endphp
    @if(Session::has('success'))
    <div class="bg-gray-100" id="{{$fade_message}}">
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
              NPIs Imported
            </h3>
            <div class="mt-2 text-sm text-green-700">
              <p>
                {{Session::get('success')}}
              </p>
              @if(Session::has('existing_npis'))
                <p>
                  <p>Below NPIs data is not imported, because these NPIs are already exists in the system.</p>
                  <span class="text-red-500">(
                  @foreach(Session::get('existing_npis') as $npi )
                    <span>{{$npi}}, </span>
                  @endforeach
                  )</span>
                </p>
              @endif
            </div>
          </div>
        </div>
        <br>
      </div>
    </div>
    @endif
    <style type="text/css">
        /*a < img { border: none; }*/
        .shadow-xl{
          box-shadow: unset;
        }

      </style>
    <!-- NPIs Search Form -->
    <div class="grid bg-gray-100 grid-cols-2 gap-4 items-center" id="jjjjjjjj">
      <div class="flex justify-between items-center">
        @if($messages ?? '')
            <div>You have searched <strong>"{{ $messages['search_text'] }}"</strong> in the <strong>"{{ strtoupper(str_replace("_"," ",$messages['search_option'])) }}"</strong> field.</div>
            <div>
              <a href="{{route('npis.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  All
              </a>
            </div>
        @endif
      </div>
      
      <div>
        <form method="POST" action="{{route('searchNPIs')}}">
           {{ csrf_field() }}
          <!-- <label for="email" class="block text-sm font-medium text-gray-700">Search NPIs</label> -->
          <div class="mt-1 flex rounded-md shadow-sm">
            <div class="relative flex items-stretch flex-grow focus-within:z-10">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
              </div>
              <input type="text" name="search_npis" id="search_npis" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300" placeholder="Search NPIs">
            </div>
            <span class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
              <!-- Heroicon name: solid/sort-ascending -->
              <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z" />
              </svg>
              <select id="search_npis_option" name="search_npis_option" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">
                <option value="first_name">First Name</option>
                <option value="last_name">Last Name</option>
                <option value="npi">NPI</option>
              </select>
            </span>

            <button type="submit" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
              Search
            </button>
          </div>
          @if($errors->has('search_npis'))
                  <em class="text-red-600">
                      {{ $errors->first('search_npis') }}
                  </em>
              @endif
        </form>
      </div>
      
    </div>
    <!-- NPIs List Table -->
    <div class="flex flex-col pt-6 bg-gray-100">
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
                @if($npis ?? '')
                  @foreach ($npis as $npi)
                      <tr class="{{ ($count%2==0) ? 'bg-gray-50' : 'bg-white' }}">
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npi->npi }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npi->first_name }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npi->last_name }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npi->email }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npi->decile }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npi->created_at }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npi->name }}</td>
                      </tr>
                      @php $count++ ; @endphp
                  @endforeach
                @endif
                @if($count == 1)
                <tr class="bg-white p-4">
                    <td colspan="7" class="p-4">No record found!</td>
                </tr>
                @endif
              </tbody>
            </table>
            @if($npis ?? '')
              <div class="p-2">
                {{ $npis->links() }}
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

@endsection


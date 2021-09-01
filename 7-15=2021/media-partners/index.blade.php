@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

    <!-- NPIs Search Form -->
    <div class="grid bg-gray-100 grid-cols-2 gap-4 items-center">
      <div class="flex justify-between items-center">
        @if(isset($_GET['search_npis']))
            <div></div>
            <div>
              <a href="{{route('npis.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  Reset Filter
              </a>
            </div>
        @endif
      </div>
      
      <div>
        <form method="GET" action="{{route('npis.index')}}">
           
          <div class="mt-1 flex rounded-md shadow-sm">
            <div class="relative flex items-stretch flex-grow focus-within:z-10">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
              </div>
              <input type="text" required value="{{(isset($_GET['search_npis']) ? $_GET['search_npis'] : '')}}" name="search_npis" id="search_npis" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300" placeholder="Search NPIs">
            </div>
            <span class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
             
              <select id="search_npis_option" name="search_npis_option" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">
                <option value="first_name" {{(isset($_GET['search_npis_option']) && $_GET['search_npis_option'] =='first_name' ? 'selected' : '')}}>First Name</option>
                <option value="last_name" {{(isset($_GET['search_npis_option']) && $_GET['search_npis_option'] =='last_name' ? 'selected' : '')}}>Last Name</option>
                <option value="npi" {{(isset($_GET['search_npis_option']) && $_GET['search_npis_option'] =='npi' ? 'selected' : '')}}>NPI</option>
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
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Added</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Present</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Most Recent Activity</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created By</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody>
                @php $count = 1;  @endphp
                @if($media_partners)
                  @foreach ($media_partners as $media_partner)
                      <tr class="{{ ($count%2==0) ? 'bg-gray-50' : 'bg-white' }}">
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $media_partner->media_partner_name ?? '--' }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ ($media_partner->created_at ?? '--') }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><img src="{{ asset('img/data-present.png')}}"><img src="{{ asset('img/no-data.png')}}"></td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">2021-03-21</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ ($media_partner->name ?? '--') }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Delete</td>
                      </tr>
                      @php $count++ ; @endphp
                  @endforeach
                @endif
                @if($count == 1)
                <tr class="bg-white p-4">
                    <td colspan="7" class="p-4">No records found!</td>
                </tr>
                @endif
              </tbody>
            </table>
            @if($media_partners ?? '')
              <div class="p-2" id="npis-pagination">
                @if(isset($_GET['search_npis']))
                  {{ $media_partners->appends(['search_npis' => $_GET['search_npis'], 'search_npis_option' => $_GET['search_npis_option']])->links() }}
                @else
                  {{ $media_partners->links() }}
                @endif
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

@endsection


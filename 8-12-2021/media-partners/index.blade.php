@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

@if(Session::has('deleted'))
    @include('components.deleted')
@endif

@if(Session::has('success'))
  @include('components.success')
@endif

@if(Session::has('created'))
  @include('components.create-success')
@endif

@if(Session::has('updated'))
  @include('components.update-success')
@endif


    <!-- Media Partner List Table -->
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
                @php 

                $count = 1;  
                 
                @endphp
                @if($media_partners)
                  @foreach ($media_partners as $media_partner)
                    @php 
                     $img = 'no-data-present.png';
                     if($media_partner['media_partner_present']){
                      $img = 'data-present-2.png';
                     }
                     @endphp
                      <tr class="{{ ($count%2==0) ? 'bg-gray-50' : 'bg-white' }}">
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $media_partner['media_partner_name'] ?? '--' }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $media_partner['media_partner_created_at'] ?? '--' }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center"><img class="inline" src='{{ asset("img/$img")}}'></td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $media_partner['media_partner_date'] ?? 'N/A' }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ ($media_partner['added_by_user_name'] ?? '--') }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <div class="flex">
                              <span class="pr-2">
                                <a href="{{route('media-partners.edit', ['id' => $media_partner['media_partner_id']])}}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase">Edit</a>
                              </span>
                              <span> @livewire('delete-media-partner',  ['mediaPartner' => $media_partner])</span>
                            </div>
                          </td>
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
                  {{ $get_media_partners->appends(['search_npis' => $_GET['search_npis'], 'search_npis_option' => $_GET['search_npis_option']])->links() }}
                @else
                  {{ $get_media_partners->links() }}
                @endif
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

@endsection


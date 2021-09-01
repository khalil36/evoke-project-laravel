<div>
    <h2 class="text-evoke text-xl font-medium tracking-wide">ULD NPIs Served</h2>
    <div class="mt-3">

        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">

            <div class="py-2 align-middle sm:px-6 lg:px-8">

                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-evoke-black">
                        <tr>
                            <th scope="col" class="px-2 py-1 text-left text-sm font-bold text-gray-50">
                                Media Partner
                            </th>
                            <th scope="col" class="px-2 py-1 text-left text-sm font-bold text-gray-50">
                                Unique NPIs Served
                            </th>
                            <th scope="col" class="px-2 py-1 text-left text-sm font-bold text-gray-50">
                                % Reached
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php  $count = 1;  @endphp
                        @if($mediaPartnersFullData)
                          @foreach ($mediaPartnersFullData as $media_partner)

                              <tr class="{{ ($count%2==0) ? 'bg-gray-50' : 'bg-white' }}">
                                  <td class="px-2 py-1 whitespace-nowrap text-sm font-medium text-gray-900">{{ $media_partner['media_partner_name'] ?? '--' }}</td>
                                  <td class="px-2 py-1 whitespace-nowrap text-sm font-medium text-gray-900">{{ number_format($media_partner['unique_npis']) ?? '--' }}</td>
                                  <td class="px-2 py-1 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $media_partner['percentage_reached']."%" ?? '--' }}</td>
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
                </div>
            </div>
        </div>
    </div>
</div>

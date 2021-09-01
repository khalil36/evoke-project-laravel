<div>
    <h2 class="text-evoke text-xl font-medium tracking-wide">Raw Impressions & Clicks by Media Partner</h2>
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
                                Impressions
                            </th>
                            <th scope="col" class="px-2 py-1 text-left text-sm font-bold text-gray-50">
                                Clicks
                            </th>
                        </tr>
                        </thead>
                        <tbody wire:init="loadSites" wire:loading.class="hidden">
                        <!-- Odd row -->
                        @foreach($sites as $site)
                            @if($loop->odd)
                                <tr class="bg-white">
                            @else
                                <tr class="bg-gray-50">
                            @endif
                                    <td class="px-2 py-1 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $site['Site (CM360)'] }}
                                    </td>
                                    <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-500">
                                        {{ $site['Impressions'] }}
                                    </td>
                                    <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-500">
                                        {{ $site['Clicks'] }}
                                    </td>
                                </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="hidden" wire:loading.class.remove="hidden" >
                                <td colspan="3" class=" align-middle text-center items-center">
                                    <div class="la-ball-pulse la-dark mx-auto">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

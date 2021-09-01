<div>
    <h2 class="text-evoke text-xl font-medium tracking-wide">Overlap Between Media Partners</h2>
    @php  $rowCount = 0; @endphp
    <dl class="mt-5 grid grid-cols-1 rounded-lg bg-white overflow-hidden shadow divide-y divide-gray-200 md:grid-cols-3 md:divide-y-0 md:divide-x">
        @if($overlappedBetweenMediaPartners ?? '')
            @foreach($overlappedBetweenMediaPartners as $combination)
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-base font-normal text-gray-900 capitalize">
                    {{$combination['combination'][0]->media_partner_name}} Vs {{$combination['combination'][1]->media_partner_name}}
                </dt>
                <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                    <div class="flex items-baseline text-2xl font-semibold text-evoke">
                        {{number_format($combination['overLappedNpis'])}}
                        <span class="ml-2 text-sm font-medium text-gray-500">
                          from {{number_format($combination['totalNpiReachedCount'])}} Total NPIs.
                        </span>
                    </div>

                    <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800 md:mt-2 lg:mt-0">
                        <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        <span class="sr-only">
                            Overlap of
                        </span>
                        {{$combination['percentage_reached']}}%
                    </div>
                </dd>
            </div>
                @php    
                        $rowCount++;
                        if($rowCount % 3 == 0) echo '</dl><dl class="mt-5 grid grid-cols-1 rounded-lg bg-white overflow-hidden shadow divide-y divide-gray-200 md:grid-cols-3 md:divide-y-0 md:divide-x">';
                @endphp
            @endforeach
        @endif
        
    </dl>
</div>


<div>

    <div>
        <h2 class="text-evoke text-xl font-medium tracking-wide">Overall NPI Reach</h2>
        <ul class="mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <li class="col-span-1 flex shadow-sm rounded-md">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-evoke text-white text-sm font-medium rounded-l-md">
                    NPIs
                </div>
                <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                    <div class="flex-1 px-4 py-2 text-sm truncate">
                        <a href="#" class="text-black-900 font-large hover:text-grey-600">{{ number_format($uniqueNpiCount) }}</a>
                        <p class="text-gray-500">out of {{number_format($totalNpiReachedCount)}} Total NPIs.</p>
                    </div>
                </div>
            </li>
            <li class="col-span-1 flex shadow-sm rounded-md">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-evoke text-white text-sm font-medium rounded-l-md">
                    %
                </div>
                <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                    <div class="flex-1 px-4 py-2 text-sm truncate">
                        <a href="#" class="text-black-900 font-large hover:text-grey-600">{{ $percentageNpiReached }}</a>
                        <p class="text-gray-500">percent reached.</p>
                    </div>
                </div>
            </li>
            <li class="col-span-1 flex shadow-sm rounded-md">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-evoke text-white text-sm font-medium rounded-l-md">
                    O
                </div>
                <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                    <div class="flex-1 px-4 py-2 text-sm truncate">
                        <a href="#" class="text-black-900 font-large hover:text-grey-600">{{ number_format($overLappedNpis) }}</a>
                        <p class="text-gray-500">overlapped NPIs.

                        </p>
                    </div>
                </div>
            </li>
        </ul>

    </div>

</div>

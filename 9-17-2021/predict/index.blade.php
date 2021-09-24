@extends('layouts.client-pages')
@section('title', 'Predict')
@section('client-content')

<div class="relative bg-white-500 rounded-lg  overflow-hidden">
    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

            <form class="space-y-8 divide-y divide-gray-200">
                <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                    <div>

                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">

                                <div>
                                    <label for="performance_metric" class="block text-lg leading-6 font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        Performance Metric
                                    </label>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                        Select the KPI you want Predict to recommend improvements for.
                                    </p>
                                </div>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <select id="performance_metric" name="performance_metric" autocomplete="performance_metric" class="max-w-lg block focus:ring-evoke focus:border-evoke w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                        <option>Traffic</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">

                                <div>
                                    <label for="buy_metric" class="block text-lg leading-6 font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        Buy Metric
                                    </label>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                        Select how you typically specify your media buy.
                                    </p>
                                </div>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <select id="buy_metric" name="buy_metric" autocomplete="buy_metric" class="max-w-lg block focus:ring-evoke focus:border-evoke w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                        <option>Cost</option>
                                    </select>
                                </div>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">

                                <div>
                                    <label for="dimensions" class="block text-lg leading-6 font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        Dimensions
                                    </label>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                        Select at least one and up to five spot parameters for Predict to consider when generating recommendations.
                                    </p>
                                </div>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    {{-- see docs here: https://laravel-form-components.randallwilk.dev/components/select --}}
                                    <x-custom-select name="dimensions"
                                                     :options="[1]"
                                                     value-field="id"
                                                     text-field="name"
                                                     optional
                                                     multiple
                                    />
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">

                                <div>
                                    <label for="historic_date_range" class="block text-lg leading-6 font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        Date Range
                                    </label>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                        Select the historic date range on which to base your recommendations.
                                    </p>
                                </div>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-center">
                                            <input id="historic_date_range" name="historic_date_range" checked="checked" type="radio" value="auto-select" class="focus:ring-evoke h-4 w-4 text-evoke border-gray-300">
                                            <label for="auto_select" class="ml-3 block text-sm font-medium text-gray-700">
                                                Auto-Select
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="historic_date_range" name="historic_date_range" type="radio" value="manually-select" class="focus:ring-evoke h-4 w-4 text-evoke border-gray-300">
                                            <label for="manually_select" class="ml-3 block text-sm font-medium text-gray-700">
                                                Manually Select
                                            </label>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">

                                <div>
                                    <label for="recommendation_date_range" class="block text-lg leading-6 font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        Recommendation Date Range
                                    </label>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                        Use a permanent address where you can receive mail.
                                    </p>
                                </div>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    {{-- taken from https://tailwindcomponents.com/component/multi-range-slider --}}
                                    <style>
                                        input[type=range]::-webkit-slider-thumb {
                                            pointer-events: all;
                                            width: 24px;
                                            height: 24px;
                                            -webkit-appearance: none;
                                            /* @apply w-6 h-6 appearance-none pointer-events-auto; */
                                        }
                                    </style>
                                    <div class="h-screen flex justify-center items-center">
                                        <div x-data="range()" x-init="mintrigger(); maxtrigger()" class="relative max-w-xl w-full">
                                            <div>
                                                <input type="range"
                                                       step="100"
                                                       x-bind:min="min" x-bind:max="max"
                                                       x-on:input="mintrigger"
                                                       x-model="minprice"
                                                       class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                                <input type="range"
                                                       step="100"
                                                       x-bind:min="min" x-bind:max="max"
                                                       x-on:input="maxtrigger"
                                                       x-model="maxprice"
                                                       class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                                <div class="relative z-10 h-2">

                                                    <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>

                                                    <div class="absolute z-20 top-0 bottom-0 rounded-md bg-evoke" x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                                                    {{-- <div class="absolute hidden z-30 w-6 h-6 top-0 left-0 bg-evoke rounded-full -mt-2 -ml-1" x-bind:style="'left: '+minthumb+'%'"></div> --}}

                                                    <div class="absolute z-30 w-6 h-6 top-0 right-0 bg-evoke rounded-full -mt-2 -mr-3" x-bind:style="'right: '+maxthumb+'%'"></div>

                                                </div>

                                            </div>

                                            <div class="flex justify-between items-center py-5">
                                                <div class="hidden">
                                                    <input type="text" maxlength="5" x-on:input="mintrigger" x-model="minprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                                                </div>
                                                <div>
                                                    Days<br/>
                                                    <input type="text" maxlength="5" x-on:input="maxtrigger" x-model="maxprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                                                </div>
                                            </div>

                                        </div>

                                        <script>
                                            function range() {
                                                return {
                                                    minprice: 0,
                                                    maxprice: 7000,
                                                    min: 0,
                                                    max: 10000,
                                                    minthumb: 0,
                                                    maxthumb: 0,

                                                    mintrigger() {
                                                        this.minprice = Math.min(this.minprice, this.maxprice - 500);
                                                        this.minthumb = ((this.minprice - this.min) / (this.max - this.min)) * 100;
                                                    },

                                                    maxtrigger() {
                                                        this.maxprice = Math.max(this.maxprice, this.minprice + 500);
                                                        this.maxthumb = 100 - (((this.maxprice - this.min) / (this.max - this.min)) * 100);
                                                    },
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-evoke">
                            Cancel
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-evoke hover:bg-evoke focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-evoke">
                            Save
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    </div>


@endsection


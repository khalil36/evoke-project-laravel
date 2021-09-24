<div class="bg-white">
    <div class="">
        <div class="text-left bg-white">
        <div class="" >
            <button wire:click="confirmNewModel" wire:loading.attr="disabled" class="float-right inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-evoke hover:bg-evoke-tertiary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-evoke-tertiary">
                {{ __('Run New Model') }}
            </button>
        </div>

        <!-- Delete Media Partner Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingNewModel">
            <x-slot name="title">
                <h2 class="mb-8 text-lg font-bold">Default Weights</h2>
            </x-slot>
            
           <x-slot name="content">
       
            <div class="flex">

                <div class="w-1/5">
                    <label for="wieght_1" class="block text-base leading-6 font-medium text-gray-900 sm:mt-px sm:pt-2">
                        Weight 1:
                    </label>
                </div>

                <div x-data="range()" x-init="mintrigger(); maxtrigger()" class="relative max-w-xl w-full flex-1">
                    <div>
                        <input type="range"
                               step="2"
                               x-bind:min="min" x-bind:max="max"
                               x-on:input="mintrigger"
                               x-model="minprice"
                               class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                        <input type="range"
                               step="2"
                               x-bind:min="min" x-bind:max="max"
                               x-on:input="maxtrigger"
                               x-model="maxprice"
                               class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                        <div class="relative z-10 h-2">

                            <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>

                            <div class="absolute z-20 top-0 bottom-0 rounded-md bg-evoke" x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                            <div class="absolute z-30 w-6 h-6 top-0 right-0 bg-evoke rounded-full -mt-2 -mr-3" x-bind:style="'right: '+maxthumb+'%'"></div>

                        </div>

                    </div>

                    <div class="flex justify-between items-center py-5">
                        <div class="hidden">
                            <input type="text" maxlength="3" x-on:input="mintrigger" x-model="minprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                        </div>
                        <div>
                            <input type="text" name="wieght_1" :maxlength="maxprice > 100 ? '3' : '2' " x-on:input="maxtrigger" x-model="maxprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                        </div>
                    </div>

                </div>

            </div>

            <div class="flex">

                <div class="w-1/5">
                    <label for="wieght_2" class="block text-base leading-6 font-medium text-gray-900 sm:mt-px sm:pt-2">
                        Weight 2:
                    </label>
                </div>

                <div class="mt-1 sm:mt-0 sm:col-span-2 flex-1">
                    <div class="flex items-center">
                        <div x-data="range()" x-init="mintrigger(); maxtrigger()" class="relative max-w-xl w-full">
                            <div>
                                <input type="range"
                                       step="2"
                                       x-bind:min="min" x-bind:max="max"
                                       x-on:input="mintrigger"
                                       x-model="minprice"
                                       class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                <input type="range"
                                       step="2"
                                       x-bind:min="min" x-bind:max="max"
                                       x-on:input="maxtrigger"
                                       x-model="maxprice"
                                       class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                <div class="relative z-10 h-2">

                                    <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>

                                    <div class="absolute z-20 top-0 bottom-0 rounded-md bg-evoke" x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                                    <div class="absolute z-30 w-6 h-6 top-0 right-0 bg-evoke rounded-full -mt-2 -mr-3" x-bind:style="'right: '+maxthumb+'%'"></div>

                                </div>

                            </div>

                            <div class="flex justify-between items-center py-5">
                                <div class="hidden">
                                    <input type="text" maxlength="3" x-on:input="mintrigger" x-model="minprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                                </div>
                                <div>
                                    <input type="text" name="wieght_2" :maxlength="maxprice > 100 ? '3' : '2' " x-on:input="maxtrigger" x-model="maxprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                                </div>
                            </div>

                        </div>

                        
                    </div>
                </div>
            </div>

            <div class="flex">

                <div class="w-1/5">
                    <label for="wieght_3" class="block text-base leading-6 font-medium text-gray-900 sm:mt-px sm:pt-2">
                        Weight 3:
                    </label>
                </div>

                <div class="mt-1 sm:mt-0 sm:col-span-2 flex-1">
                    <div class="flex items-center">
                        <div x-data="range()" x-init="mintrigger(); maxtrigger()" class="relative max-w-xl w-full">
                            <div>
                                <input type="range"
                                       step="2"
                                       x-bind:min="min" x-bind:max="max"
                                       x-on:input="mintrigger"
                                       x-model="minprice"
                                       class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                <input type="range"
                                       step="2"
                                       x-bind:min="min" x-bind:max="max"
                                       x-on:input="maxtrigger"
                                       x-model="maxprice"
                                       class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                <div class="relative z-10 h-2">

                                    <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>

                                    <div class="absolute z-20 top-0 bottom-0 rounded-md bg-evoke" x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                                    <div class="absolute z-30 w-6 h-6 top-0 right-0 bg-evoke rounded-full -mt-2 -mr-3" x-bind:style="'right: '+maxthumb+'%'"></div>

                                </div>

                            </div>

                            <div class="flex justify-between items-center py-5">
                                <div class="hidden">
                                    <input type="text" maxlength="3" x-on:input="mintrigger" x-model="minprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                                </div>
                                <div>
                                    <input type="text" name="wieght_3" :maxlength="maxprice > 100 ? '3' : '2' " x-on:input="maxtrigger" x-model="maxprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                                </div>
                            </div>

                        </div>

                        
                    </div>
                </div>
            </div>

            <div class="flex">

                <div class="w-1/5">
                    <label for="wieght_4" class="block text-base leading-6 font-medium text-gray-900 sm:mt-px sm:pt-2">
                        Weight 4:
                    </label>
                </div>

                <div class="mt-1 sm:mt-0 sm:col-span-2 flex-1">
                    <div class="flex items-center">
                        <div x-data="range()" x-init="mintrigger(); maxtrigger()" class="relative max-w-xl w-full">
                            <div>
                                <input type="range"
                                       step="2"
                                       x-bind:min="min" x-bind:max="max"
                                       x-on:input="mintrigger"
                                       x-model="minprice"
                                       class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                <input type="range"
                                       step="2"
                                       x-bind:min="min" x-bind:max="max"
                                       x-on:input="maxtrigger"
                                       x-model="maxprice"
                                       class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                <div class="relative z-10 h-2">

                                    <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>

                                    <div class="absolute z-20 top-0 bottom-0 rounded-md bg-evoke" x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                                    <div class="absolute z-30 w-6 h-6 top-0 right-0 bg-evoke rounded-full -mt-2 -mr-3" x-bind:style="'right: '+maxthumb+'%'"></div>

                                </div>

                            </div>

                            <div class="flex justify-between items-center py-5">
                                <div class="hidden">
                                    <input type="text" maxlength="3" x-on:input="mintrigger" x-model="minprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                                </div>
                                <div>
                                    <input type="text" name="wieght_4" :maxlength="range.maxtrigger == 100 ? '3' : '2' "  x-on:input="maxtrigger" x-model="maxprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                                </div>
                            </div>

                        </div>

                        
                    </div>
                </div>
            </div>
        </x-slot>
       
        <x-slot name="footer">

            <div class="text-center">
            
                <x-jet-secondary-button wire:click="$toggle('confirmingNewModel')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2"  wire:loading.attr="disabled" wire:click="seeModel" class="bg-evoke-tertiary">
                    {{ __('See Model') }}
                </x-jet-button>

            </div>
        </x-slot>
            
        </x-jet-dialog-modal>

        </div>
    </div>
</div>

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

<script>
    function range() {
        return {
            minprice: 0,
            maxprice: 10,
            min: 0,
            max: 100,
            minthumb: 0,
            maxthumb: 0,

            mintrigger() {
                this.minprice = Math.min(this.minprice, this.maxprice - 0);
                this.minthumb = ((this.minprice - this.min) / (this.max - this.min)) * 100;
            },

            maxtrigger() {
                this.maxprice = Math.max(this.maxprice, this.minprice + 0);
                this.maxthumb = 100 - (((this.maxprice - this.min) / (this.max - this.min)) * 100);
            },
        }
    }
</script>
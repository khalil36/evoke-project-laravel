<!-- This example requires Tailwind CSS v2.0+ -->
<div class="flex items-center justify-between">
  <span class="flex-grow flex flex-col" id="availability-label">
    <span class="text-sm font-medium text-gray-900">{{ $title }}</span>
    <span class="text-sm text-gray-500">{{ $description }}</span>
  </span>
    <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
    <button
        {!! $attributes !!}
        {{--x-data="{ isOn: true }"--}}
        x-data="{
        onValue: {{ json_encode("1") }},
        offValue: {{ json_encode("0") }},
         value:$wire.state.is_active,
         get isPressed() {
            return this.value === this.onValue;
        },
        isOn: $wire.state.is_active ,
        toggle() {
            this.value = this.isPressed ? this.offValue : this.onValue;
            isOn = this.value
        },
        }"
        wire:ignore.self
        {{--@click="isOn = !isOn"--}}
        @click="toggle()"


        :aria-checked="isOn"
        :class="{'bg-evoke': isOn, 'bg-gray-200': !isOn }"
        type="button"
        class="bg-gray-200 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-evoke-tertiary" role="switch" aria-checked="false" aria-labelledby="availability-label">
        <span class="sr-only">Use setting</span>
        <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
        <span :class="{'translate-x-5': isOn, 'translate-x-0': !isOn }" aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
    </button>
    <input type="hidden" name="{{ $name }}" x-bind:value="JSON.stringify(value)" />
</div>

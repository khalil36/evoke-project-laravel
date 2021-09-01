@if($campaigns_created)
  @include('components.campaigns_created')
@endif
<div>
    <p>Please select the creatives to be used:</p>
    <p>
        <select name="creatives" multiple wire:model="creatives" class="text-sm w-2/3" size="10" {{($campaigns_created) ? 'disabled' : '' }}>
            @foreach($allCreatives as $c)
            <option value="{{$c->id}}">[ {{$c->size->width}} X {{$c->size->height}} ] {{$c->name}} </option>
            @endforeach
        </select>
        <div class="text-xs">CTRL + Click to select multiple.</div>
    </p>
    <br/>
    <p class="text-xs">Results above are cached for 60 seconds.  <br/>If you have waited 60 seconds and still do not see the expected creative listed, please have the trafficking manager review campaign manager.</p>
    <br/><br/>
    <div class="">



        @if($isDisabled)
        <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
            {{ __('Start') }}
        </x-jet-button>
        @else
        <x-jet-button class="ml-2 {{($campaigns_created) ? 'cursor-not-allowed' : '' }}" wire:click="create" disabled="disabled">
            {{ __('Start') }}
        </x-jet-button>
        @endif

        <div class="hidden" wire:loading.class.remove="hidden" >

            <div class="la-ball-pulse la-dark mx-auto">
                <div></div>
                <div></div>
                <div></div>
            </div>

        </div>

    </div>

</div>

@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

@if(Session::has('Error'))
  @include('components.error')
@endif

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div wire:id="LqPb8H1xm0xzXCvGxqRK" class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1 flex justify-between">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium text-gray-900">Update Media Partner</h3>

                <p class="mt-1 text-sm text-gray-600">
                    Update media partner.
                </p>
            </div>

            <div class="px-4 sm:px-0">

            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form method="POST" action="{{route('update' , [ $media_partner->id])}}" class="bg-gray-100">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700" for="media_partner_name">
                                Media Partner Name
                            </label>
                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="name" value="{{$media_partner->media_partner_name}}" type="text" name="media_partner_name" autofocus="autofocus" required>
                            @if($errors->has('media_partner_name'))
                                <em class="text-red-600">
                                    {{ $errors->first('media_partner_name') }}
                                </em>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700" for="dfa_site_name">
                                Campaign Manager Site
                            </label>
                            <x-custom-select
                                             name="dfa_site_name"
                                             :options="$sites"
                                             value-field="name"
                                             text-field="name"
                                             filterable
                                             optional
                                             value="{{$media_partner->dfa_site}}"

                            />
                            @if($errors->has('dfa_site_name'))
                                <em class="text-red-600">
                                    {{ $errors->first('dfa_site_name') }}
                                </em>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--START: These help the filterable select box show and not get clipped since the page is so short--}}
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
{{--END: These help the filterable select box show and not get clipped since the page is so short--}}
@endsection

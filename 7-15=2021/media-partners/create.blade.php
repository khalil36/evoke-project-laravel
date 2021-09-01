@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

@php 
  
  $fade_message = 'fade-message';
  if(Session::has('Success')){
    $fade_message = 'no-fade-message';
  }

@endphp

@if(Session::has('Success'))
    <div class="bg-gray-100" id="{{$fade_message}}">
      <div class="rounded-md bg-green-50 p-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-green-800">
              Success!
            </h3>
            <div class="mt-2 text-sm text-green-700">
              <p>
                {{Session::get('Success')}}
              </p>
            </div>
          </div>
        </div>
        <br>
      </div>
    </div>
    @endif
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div wire:id="LqPb8H1xm0xzXCvGxqRK" class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1 flex justify-between">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium text-gray-900">Create New Media Partner</h3>

                <p class="mt-1 text-sm text-gray-600">
                    Create a new media partner to be able to upload ULD data and start reporting on.
                </p>
            </div>

            <div class="px-4 sm:px-0">

            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form method="POST" action="{{route('save')}}" class="bg-gray-100">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700" for="name">
                                Media Partner Name
                            </label>
                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="name" type="text" name="media_partner_name" autofocus="autofocus" required>
                            @if($errors->has('media_partner_name'))
                                <em class="text-red-600">
                                    {{ $errors->first('media_partner_name') }}
                                </em>
                            @endif
                        </div>
            
                    </div>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
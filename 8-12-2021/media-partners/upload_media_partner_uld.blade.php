@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

@if(Session::has('Error'))
    @include('components.error')
@endif

@if(Session::has('not_valid_dates'))
  @include('components.not-imported')
@endif

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 bg-gray-100">
	<div id="Q1XHz6LvJ27kEctjKjDb" class="md:grid md:grid-cols-3 md:gap-6">
		<div class="md:col-span-1 flex justify-between">
			<div class="px-4 sm:px-0">
				<h3 class="text-lg font-medium text-gray-900">Upload Media Partner ULDs</h3>

				<p class="mt-1 text-sm text-gray-600">
					Upload Media Partner ULDs from csv or xlsx file.
				</p>
			</div>

			<div class="px-4 sm:px-0">

			</div>
		</div>

		<div class="mt-5 md:mt-0 md:col-span-2">
			<form method="POST" action="{{route('map-media-partner-uld')}}" enctype="multipart/form-data" class="bg-gray-100">
				{{ csrf_field() }}
				<div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
					<div class="grid grid-cols-6 gap-6">
						<div class="col-span-6 sm:col-span-4">
							<label class="block font-medium text-sm text-gray-700 space-y-6 block" for="csv_file">
								CSV or XLSX
							</label>
							<input type="file" name="csv_file" id="csv_file" class="space-y-6 block">
							@if($errors->has('csv_file'))
                            <em class="text-red-600">
                             {{ $errors->first('csv_file') }}
                            </em>
                            @endif
                            
                            <div class="mt-6">
                              <label for="media_partner_id" class="block text-sm font-medium text-gray-700">Media Partner</label>
                              <select id="media_partner_id" name="media_partner_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-evoke-500 focus:border-evoke-500 sm:text-sm rounded-md">
                                <option value="0">Please select a media partner</option>
                                @foreach ($media_partners as $partner)
                                    <option value="{{ $partner->id }}">{{ $partner->media_partner_name }}</option>
                                @endforeach
                              </select>
                            </div>

                            <label class="block font-medium text-sm text-gray-700 space-y-6 block mt-6" for="csv_file">
                                Import Method
                            </label>

                            <fieldset>
                                <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer" x-data="{importMethod: 'append'}" >
                                    <label type="button" class="cursor-pointer relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 border-t border-gray-200 rounded-t-none  rounded-b-none text-left">
                                        <input type="radio" x-model="importMethod" name="import_option" value="append" class="sr-only" aria-labelledby="import_option-0-label" aria-describedby="import_option-0-description-0 import_option-0-description-1">
                                        <div :class="importMethod == 'append' ? 'opacity-100' : 'opacity-50'">
                                            <div class="flex items-center">
                                                <div class="text-sm text-gray-600 ">
                                                    Append
                                                </div>
                                                <svg x-cloak x-show="importMethod == 'append'" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div class="mt-2 text-xs text-gray-600">
                                                New records will be inserted.
                                            </div>
                                        </div>
                                    </label>

                                    <label type="button" class="cursor-pointer relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 border-t border-gray-200 rounded-t-none  rounded-b-none text-left">
                                        <input type="radio" x-model="importMethod" name="import_option" value="delete" class="sr-only" aria-labelledby="import_option-2-label" aria-describedby="import_option-2-description-0 import_option-2-description-1">
                                        <div :class="importMethod == 'delete' ? 'opacity-100' : 'opacity-50'">
                                            <div class="flex items-center">
                                                <div class="text-sm text-gray-600 ">
                                                    Delete
                                                </div>
                                                <svg x-cloak x-show="importMethod == 'delete'" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div class="mt-2 text-xs text-gray-600">
                                                All data associated with this media partner will be deleted first.  Then the import of this sheet will be completed.
                                            </div>
                                        </div>
                                    </label>


                                </div>

                            </fieldset>
                            @if($errors->has('import_option'))
                            <em class="text-red-600">
                               {{ $errors->first('import_option') }}
                           </em>
                           @endif

                       </div>
                   </div>
               </div>

    			<div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
    				<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
    					Map File
    				</button>
    			</div>
    
             <div class="bg-gray-50 sm:rounded-lg mt-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Need an example file?
                    </h3>
                    <div class="mt-2 max-w-xl text-sm text-gray-500">
                        <p>
                            This template can be downloaded if you are unsure of the file format needed to upload Media Partner ULDs or need a starting point.
                            If you already have a csv file, you can skip this step and use your existing file.
                        </p>
                    </div>
        
                    <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 flex-1 w-0 truncate">
                                  Media-Partner-ULDs-Example.csv
                                </span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="{{ asset('uploads/files/Media-Partner-ULDs-Example.csv') }}" class="font-medium text-evoke-tertiary hover:text-evoke-tertiary">
                                        Download
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
			</form>
		</div>
	</div>

</div>
@endsection

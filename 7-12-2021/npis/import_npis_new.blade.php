@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

@if(Session::has('Error'))
    <div class="rounded-md bg-red-50 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <!-- Heroicon name: solid/x-circle -->
          <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-red-800">
            ERROR! In Importing File
          </h3>
          <div class="mt-2 text-sm text-red-700">
            <p>
              {{Session::get('Error')}}
            </p>
          </div>
        </div>
      </div>
    </div>
@endif
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 bg-gray-100">
	<div id="Q1XHz6LvJ27kEctjKjDb" class="md:grid md:grid-cols-3 md:gap-6">
		<div class="md:col-span-1 flex justify-between">
			<div class="px-4 sm:px-0">
				<h3 class="text-lg font-medium text-gray-900">Import NPIs</h3>

				<p class="mt-1 text-sm text-gray-600">
					Import NPIs from csv or xlsx file.
				</p>
			</div>

			<div class="px-4 sm:px-0">

			</div>
		</div>

		<div class="mt-5 md:mt-0 md:col-span-2">
			<form method="POST" action="{{route('mapNPIs')}}" enctype="multipart/form-data" class="bg-gray-100">
				{{ csrf_field() }}
				<div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
					<div class="grid grid-cols-6 gap-6">
						<div class="col-span-6 sm:col-span-4">
							<label class="block font-medium text-sm text-gray-700 space-y-6 block" for="csv_file">
								CSV or XLSX
							</label>
							<br>
							<input type="file" name="csv_file" id="csv_file" class="space-y-6 block">
							 @if($errors->has('csv_file'))
				                  <em class="text-red-600">
				                      {{ $errors->first('csv_file') }}
				                  </em>
				              @endif
							<br>
							<a href="https://av-evokegroup-khalil.dev.securedatatransit.com/uploads/files/NPIS-example.csv" class="no-underline hover:underline text-blue-700">Download example file</a>
						</div>
					</div>
				</div>

				<div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
					<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
						Map File
					</button>
				</div>
			</form>
		</div>
	</div>

</div>
@endsection
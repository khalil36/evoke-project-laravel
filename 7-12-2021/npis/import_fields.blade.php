@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

 
<form class="form-horizontal bg-gray-100" method="POST" action="{{ route('processImport') }}">
    <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />
    {{ csrf_field() }}
    @php $count = 1 ; @endphp

  
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200" style="width: 80%;">
              <thead class="bg-gray-50">
               
                    @foreach ($csv_data as $row)
                        @if($count == 1)
                            <tr>
                            @foreach ($row as $key => $value)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $value }}</th>
                            @endforeach
                            </tr>
                            @php $count++ ; @endphp
                        @endif
                        @break
                    @endforeach
               
              </thead>
              <tbody>

                @foreach ($csv_data as $row)
                        @if($count > 2)
                            <tr class="{{ ($count%2==0) ? 'bg-gray-50' : 'bg-white' }}">
                            @foreach ($row as $key => $value)
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $value }}</td>
                            @endforeach
                            </tr>
                        @endif
                        @php $count++ ; @endphp
                @endforeach

                <tr class="bg-white">
                    @foreach ($csv_data[0] as $index => $value)
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <select name="fields[{{ $index }}]">
                                    <option value="not_seclected">-- Select Field --</option>
                                @foreach ($npis_fields as $key => $db_field)
                                    @php  
                                      $db_field = str_replace("_"," ",$db_field);
                                      $db_field_lowercase = strtolower($db_field);
                                      $value_lowercase = strtolower($value);
                                    @endphp
                                    <option value="{{ $key }}" {{($value_lowercase == $db_field_lowercase) ? 'selected' : '' }}>{{ $db_field }}</option>
                                @endforeach
                            </select>
                           <!--  <input type="hidden" name="colum_index" value="{{$key}}"> -->
                        </td>
                    @endforeach
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
   
    <br>
    <button type="submit" class="float-right inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
        Import Data
    </button>
    <!-- <a onClick="console.log('aaaa');khalil();" class="float-right inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
        Import Data
    </a> -->
    <br>
</form>

@endsection
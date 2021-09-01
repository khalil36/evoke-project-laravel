@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

<div class="rounded-md bg-red-50 p-4" id="npi-required" style="display:none;">
  <div class="flex">
    <div class="flex-shrink-0">
      <!-- Heroicon name: solid/x-circle -->
      <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
      </svg>
    </div>
    <div class="ml-3">
      <h3 class="text-sm font-medium text-red-800">
        Error on form submission.
      </h3>
      <div class="mt-2 text-sm text-red-700">
        <p>
            <strong>NPI</strong> field is required.
        </p>
      </div>
    </div>
  </div>
</div>
 
<form name="mapNPIsForm" class="form-horizontal bg-gray-100" method="POST" action="{{ route('processImport') }}" onsubmit="return validateForm()">
    <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />
    {{ csrf_field() }}
    @php $count = 1 ; $columnIndexCounter = 0; @endphp
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
                            <select name="fields[{{$index}}]" id="field_{{$index}}" onchange="javascript: checkFieldName(this.value, {{$index}})">
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
                        </td>
                        @php $columnIndexCounter++; @endphp
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
    <br>
</form>

<script type="text/javascript">
    //validateForm();
    var columns = @php echo json_encode(array_keys($npis_fields)) @endphp;
    var items=[];
    function checkFieldName(val='', index=''){

        for (var i = 0; i < @php echo $columnIndexCounter; @endphp ; i++) {
                if (index != i ) {
                    if (val != 'not_seclected') {
                        var objSelect = document.getElementById("field_" + i);
                        if (objSelect.value == val) {
                            document.getElementById("field_" + index).value = 'not_seclected';
                            alert('This option is already selected');
                            break;
                        }
                    }
                }
            }

        //var arrObj = document.getElementsByName("fields[]");
        // console.log(arrObj);
        // var gg = Array.prototype.slice.call(document.arrObj);
         //console.log(gg);
        // for (var i = 0; i < arrObj.length; i++) {
        //     if (index != i) {
        //         if (arrObj[i].value == value) {
        //             arrObj[index].value = 'not_seclected';
        //             alert('This field is already selected!')
        //             break;
        //         }
        //     }
        // }
       
        // for (var i = 0;  i < columns.length; i++) {
        //     var x = document.getElementById('field_'+i).value;
        //     items.push(x); 
        // }

        // if (value != 'not_seclected') {
        //     if(items.indexOf(value) > -1){
        //         alert('value12: ' + value)
        //     }
        // }
    }
    function validateForm() {
        //alert(' on to sumbit');
     
        items=[];
        for (var i = 0;  i < @php echo $columnIndexCounter; @endphp ; i++) {
            var x = document.getElementById('field_'+i).value;
            items.push(x); 
        }
      
        if (items) {
            var npi_required = document.getElementById('npi-required');
            if(items.indexOf('npi') > -1){
                npi_required.style.display = 'none';
                return true;
            } else {
                npi_required.style.display = 'block';
                return false;
            }

        }

        return false;
    }
</script>
@endsection
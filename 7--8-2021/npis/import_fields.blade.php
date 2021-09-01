<form class="form-horizontal" method="POST" action="{{ route('processImport') }}">
    <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />
    {{ csrf_field() }}
    @php 

        $count = 1 ;
        $DB_Fields = array(
            'team id',
            'npi',
            'first name',
            'last name',
            'email',
            'decile'
        );

    @endphp

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200" style="width: 80%;">
              <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NPI</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Decile</th>
                </tr>
              </thead>
              <tbody>

                <tr class="bg-white">
                    @foreach ($DB_Fields as $db_field)
                    @php 
                      if($count == 1){
                        $field_name = 'team_id';
                      } elseif($count == 2){
                        $field_name = 'npi';
                      }elseif($count == 3){
                        $field_name = 'first_name';
                      }elseif($count == 4){
                        $field_name = 'last_name';
                      }elseif($count == 5){
                        $field_name = 'email';
                      }elseif($count == 6){
                        $field_name = 'decile';
                      }
                         
                    @endphp
                    @foreach ($csv_data as $key => $row)
                   
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <select name="{{$field_name}}">
                                @foreach ($row as $header)
                                    @php  
                                      $header_lowercase = strtolower($header);
                                    @endphp 
                                    <option value="{{ $loop->index }}" {{($header_lowercase == $db_field) ? 'selected' : '' }}>{{ $header }}</option>
                                @endforeach
                            </select>
                        </td>
                        
                        
                    @endforeach
                    @php $count++ ; @endphp
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
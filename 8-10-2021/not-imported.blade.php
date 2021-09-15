<div class="rounded-md bg-red-50 p-4" x-data="{ open: true}" x-show="open">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
      </svg>
    </div>
    <div class="ml-3">
      <h3 class="text-sm font-medium text-red-800">
        NOT IMPORTED!
      </h3>
      <div class="mt-2 text-sm text-red-700">
        <p>
          @php 

          $fields=''; 
          echo"<pre>not_valid_dates:"; print_r(Session::get('not_valid_dates')); exit;
          if(count(Session::get('not_valid_dates')) > 300){
            echo '<p>Many records were not imported because of wrong date.</p>';
          } else {
            echo '<p>The records of dates listed below are not imported because of wrong date, But rest of the records are imported.</p>';
            foreach(Session::get('not_valid_dates') as $date ){
              $fields .=	$date . ', ';
            }

          }

          @endphp
          <span class="text-red-500">( {{substr(trim($fields), 0, -1)}} )</span>
        </p>
      </div>
    </div>
    <div class="ml-auto pl-3">
        <div class="-mx-1.5 -my-1.5">
            <button type="button" x-on:click="open = !open" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600">
                <span class="sr-only">Dismiss</span>
                <!-- Heroicon name: solid/x -->
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
  </div>
</div>
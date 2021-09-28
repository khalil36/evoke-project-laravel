<style type="text/css">
  .analyze-page-table tbody tr:nth-child(even){
    background: #f9fafb;
  }  
</style>
<div x-data="sortableTable()">
   <table class="min-w-full divide-y divide-gray-200 analyze-page-table">
      <thead class="bg-gray-50">
        <tr>
            <th @click="sortByColumn" 
                :class="((sortAsc && sortBy.trim() == 'PLACEMENT') ? 'analyze-table__col-acs' : 'analyze-table__col-desc')" 
                class="cursor-pointer px-3 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Placement 
                 <span class="flex flex-col float-right margin-top">
                    <span class="leading-none">&#9650;</span> 
                    <span class="leading-none">&#9660;</span>
                </span>
            </th>
            <th @click="sortByColumn" 
                :class="((sortAsc && sortBy.trim() == 'BOUNCE RATE (20%)') ? 'analyze-table__col-acs' : 'analyze-table__col-desc')" 
                class="cursor-pointer px-3 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Bounce Rate (20%)  
                 <span class="flex flex-col float-right margin-top">
                    <span class="leading-none">&#9650;</span> 
                    <span class="leading-none">&#9660;</span>
                </span>
            </th>
            <th @click="sortByColumn" 
                :class="((sortAsc && sortBy.trim() == 'PAGES PER SESSION (20%)') ? 'analyze-table__col-acs' : 'analyze-table__col-desc')" 
                class="cursor-pointer px-3 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Pages Per Session (20%)    
                 <span class="flex flex-col float-right margin-top">
                    <span class="leading-none">&#9650;</span> 
                    <span class="leading-none">&#9660;</span>
                </span>
            </th>
            <th @click="sortByColumn" 
                :class="((sortAsc && sortBy.trim() == 'AVERAGE TIME ON PAGE (20%)') ? 'analyze-table__col-acs' : 'analyze-table__col-desc')" 
                class="cursor-pointer px-3 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Average Time on Page (20%)     
                 <span class="flex flex-col float-right margin-top">
                    <span class="leading-none">&#9650;</span> 
                    <span class="leading-none">&#9660;</span>
                </span>
            </th>
            <th @click="sortByColumn" 
                :class="((sortAsc && sortBy.trim() == 'CONVERSIONS (40%)') ? 'analyze-table__col-acs' : 'analyze-table__col-desc')" 
                class="cursor-pointer px-3 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Conversions (40%)  
                 <span class="flex flex-col float-right margin-top">
                    <span class="leading-none">&#9650;</span> 
                    <span class="leading-none">&#9660;</span>
                </span>
            </th>
            <th @click="sortByColumn" 
                :class="((sortAsc && sortBy.trim() == 'WEIGHTED RESULT') ? 'analyze-table__col-acs' : 'analyze-table__col-desc')" 
                class="cursor-pointer px-3 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Weighted Result    
                 <span class="flex flex-col float-right margin-top">
                    <span class="leading-none">&#9650;</span> 
                    <span class="leading-none">&#9660;</span>
                </span>
            </th>
            <th @click="sortByColumn" 
                :class="((sortAsc && sortBy.trim() == 'RANK') ? 'analyze-table__col-acs' : 'analyze-table__col-desc')" 
                class="cursor-pointer px-3 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Rank   
                 <span class="flex flex-col float-right margin-top">
                    <span class="leading-none">&#9650;</span> 
                    <span class="leading-none">&#9660;</span>
                </span>
            </th>

        </tr>
      </thead>
      <tbody x-ref="tbody">
        @if($analyze_data->count() != 0)
            @foreach($analyze_data as $row)
                <tr class="bg-white">
                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $row->placement }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $row->bounce_rate }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $row->page_per_session }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $row->avg_time_on_page }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $row->conversion }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $row->weighted_result }}
                    </td>
                     <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $row->rank }}
                    </td>
                </tr>
            @endforeach
        @else
            <tr class="bg-white p-4">
                <td colspan="7" class="p-4">No records found!</td>
            </tr>
        @endif
      </tbody>
    </table>

</div>
<script type="text/javascript">
    function sortableTable() {
        return {
            sortBy: "",
            sortAsc: false,
            sortByColumn($event) {
                if (this.sortBy === $event.target.innerText) {
                    if (this.sortAsc) {
                        this.sortBy = "";
                        this.sortAsc = false;
                    } else {
                        this.sortAsc = !this.sortAsc;
                    }
                } else {
                    this.sortBy = $event.target.innerText;
                }

                let rows = this.getTableRows()
                    .sort(
                        this.sortCallback(
                            Array.from($event.target.parentNode.children).indexOf(
                                $event.target
                            )
                        )
                    )
                    .forEach((tr) => {
                        this.$refs.tbody.appendChild(tr);
                    });
            },
            getTableRows() {
                return Array.from(this.$refs.tbody.querySelectorAll("tr"));
            },
            getCellValue(row, index) {
                return row.children[index].innerText;
            },
            sortCallback(index) {
                return (a, b) =>
                    ((row1, row2) => {
                        return row1 !== "" &&
                            row2 !== "" &&
                            !isNaN(row1) &&
                            !isNaN(row2)
                            ? row1 - row2
                            : row1.toString().localeCompare(row2);
                    })(
                        this.getCellValue(this.sortAsc ? a : b, index),
                        this.getCellValue(this.sortAsc ? b : a, index)
                    );
            }
        };
    }

</script>

<div x-data="sortableTable()">
   <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
            <th scope="col" @click="sortByColumn" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Placement</th>
            <th scope="col" @click="sortByColumn" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bounce Rate (20%)</th>
            <th scope="col" @click="sortByColumn" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pages Per Session (20%)</th>
            <th scope="col" @click="sortByColumn" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Average Time on Page (20%)</th>
            <th scope="col" @click="sortByColumn" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conversions (40%)</th>
            <th scope="col" @click="sortByColumn" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weighted Result</th>
            <th scope="col" @click="sortByColumn" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>

        </tr>
      </thead>
      <tbody x-ref="tbody">
        @if($analyze_data != '')
            @foreach($analyze_data as $row)
                @if($loop->odd)
                    <tr class="bg-white">
                @else
                    <tr class="bg-gray-50">
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $row->placement }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $row->bounce_rate }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $row->page_per_session }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $row->avg_time_on_page }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $row->conversion }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $row->weighted_result }}
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
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

<div class="mt-4"
      x-data="{
        init() {
          const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

          const data = {
            labels: labels,
            datasets: [{
              label: 'Last Year Orders',
              backgroundColor: 'lightgray',
              data: {{ Js::from($lastYearOrders) }},
            }, {
              label: 'This Year Orders',
              backgroundColor: 'lightgreen',
              data: {{ Js::from($thisYearOrders) }},
            }],
          };

          const config = {
            type: 'bar',
            data: data,
            options: {}
          };

          const myChart = new Chart(
            this.$refs.canvas,
            config
          );
        }
     }"
>
  <span>Year:</span>
  <select class="border"
          name="selectedYear"
          id="selectedYear"
  >
    @foreach($availableYears as $year)
      <option value="{{ $year }}">{{ $year }}</option>
    @endforeach
  </select>
  <div class="my-6">
    <div>Last Year: {{ array_sum($lastYearOrders) }}</div>
    <div>This Year: {{ array_sum($thisYearOrders) }}</div>
  </div>
  <canvas id="myChart" x-ref="canvas"></canvas>
</div>

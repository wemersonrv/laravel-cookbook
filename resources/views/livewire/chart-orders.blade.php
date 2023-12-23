<div class="mt-4"
     wire:ignore
     x-data="{
        selectedYear: @entangle('selectedYear'),
        lastYearOrders: @entangle('lastYearOrders'),
        thisYearOrders: @entangle('thisYearOrders'),
        init() {
          const labels =  ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

          const data = {
              labels,
              datasets: [{
                  label: `${this.selectedYear - 1} Orders`,
                  backgroundColor: 'lightgray',
                  data: this.lastYearOrders,
              }, {
                  label: `${this.selectedYear} Orders`,
                  backgroundColor: 'lightgreen',
                  data: this.thisYearOrders,
              }]
          };

          const config = {
              type: 'bar',
              data,
              options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          }

          const myChart = new Chart(
            this.$refs.canvas,
            config
          );

          Livewire.on('updateTheChart', () => {
            // Last Year
            myChart.data.datasets[0].label = `${this.selectedYear - 1} Orders`;
            myChart.data.datasets[0].data = this.lastYearOrders;

            // This Year
            myChart.data.datasets[1].label = `${this.selectedYear} Orders`;
            myChart.data.datasets[1].data = this.thisYearOrders;

            myChart.update();
          });
        }
     }"

>
  <span>Year: </span>
  <select class="border"
          wire:model="selectedYear"
          wire:change="updateOrdersCount"
          name="selectedYear"
          id="selectedYear"
  >
    @foreach($availbleYears as $year)
      <option value="{{ $year }}">{{ $year }}</option>
    @endforeach
  </select>
  <div class="my-6">
    <div>
      <span x-text="selectedYear - 1"></span> Orders:
      <span x-text="lastYearOrders.reduce((a, b) => a + b)"></span>
    </div>
    <div>
      <span x-text="selectedYear"></span> Orders:
      <span x-text="thisYearOrders.reduce((a, b) => a + b)"></span>
    </div>
  </div>
  <canvas id="myChart" x-ref="canvas"></canvas>
</div>

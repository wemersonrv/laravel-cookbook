@php use Illuminate\Support\Js; @endphp
<x-app-layout>
    <div class="bg-white rounded-md border my-8 px-6 py-6 mx-40">
        <div>
            <h2 class="text-2xl font-semibold">Charts</h2>
            <div class="my-6">
                <div>Last Year: {{ array_sum($lastYearOrders) }}</div>
                <div>This Year: {{ array_sum($thisYearOrders) }}</div>
            </div>
            <div class="mt-4">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        'Jan',
                        'Feb',
                        'Mar',
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep',
                        'Oct',
                        'Nov',
                        'Dec',
                    ],
                    datasets: [{
                        label: 'Last Year Orders',
                        backgroundColor: 'lightgray',
                        data: {{ Js::from($lastYearOrders) }},
                    }, {
                        label: 'This Year Orders',
                        backgroundColor: 'lightgreen',
                        data: {{ Js::from($thisYearOrders) }},
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>

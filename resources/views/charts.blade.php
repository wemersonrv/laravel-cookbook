@php use Illuminate\Support\Js; @endphp
<x-app-layout>
    <div class="bg-white rounded-md border my-8 px-6 py-6 mx-40">
        <div>
            <h2 class="text-2xl font-semibold">Charts</h2>
            <livewire:chart-orders />
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.2"></script>
    @endpush
</x-app-layout>

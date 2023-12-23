<x-app-layout>
    <div class="bg-white xl:w-1/2 mx-auto rounded-lg shadow-md mt-4 overflow-hidden">
        <div class="bg-purple-800 text-white">
            <h3 class="text-2xl text-center font-bold px-4 py-4">{{ $announcement->title_text }}</h3>
        </div>
        <div class="text-gray-600 px-5 py-5">

            <div class="content">{!! $announcement->content !!}</div>

            <p class="mt-6 mx-auto">
                <a class="bg-purple-800 text-white inline-block rounded-xl font-semibold px-8 py-4"
                   style="background: {{ $announcement->button_color }}"
                   href="{{ $announcement->button_link }}"
                >
                    {{ $announcement->button_text }}
                </a>
            </p>
        </div>
    </div>
</x-app-layout>

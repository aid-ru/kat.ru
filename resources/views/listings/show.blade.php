<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto p-6 shadow rounded">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
            @endif

            <h1 class="text-3xl font-bold">{{ $listing->title }}</h1>
            <p class="text-2xl text-blue-600 my-4">{{ number_format($listing->price, 0, '.', ' ') }} ₽</p>
            
            <div class="bg-gray-50 p-4 rounded mb-6">
                <p><strong>Город:</strong> {{ $listing->location->name }}</p>
                <p><strong>Категория:</strong> {{ $listing->category->name }}</p>
            </div>

            <div class="prose max-w-none">
                {!! nl2br(e($listing->description)) !!}
            </div>

            {{-- Вывод динамических характеристик --}}
            @php $details = $listing->productDetails ?? $listing->serviceDetails ?? $listing->jobDetails ?? $listing->personDetails; @endphp
            @if($details && $details->extra_metadata)
                <div class="mt-8 border-t pt-4">
                    <h3 class="font-bold mb-2">Дополнительная информация:</h3>
                    @foreach($details->extra_metadata as $key => $value)
                        @if($value)
                            <p><strong>{{ $key }}:</strong> {{ $value }}</p>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

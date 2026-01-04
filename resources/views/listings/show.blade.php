<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto p-6 shadow rounded">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
            @endif

            <h1 class="text-3xl font-bold">{{ $listing->title }}</h1>
            <p class="text-2xl text-blue-600 my-4">{{ number_format($listing->price, 0, '.', ' ') }} ₽</p>
            
            <div class="bg-gray-50 p-4 rounded mb-6">
                <p><strong>Город:</strong> {{ $listing->location->name ?? 'не указан' }}</p>
                <p><strong>Категория:</strong> {{ $listing->category->name ?? 'не указана' }}</p>
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


            {{-- Секция характеристик --}}
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-bold mb-4">Характеристики</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    {{-- 1. Вывод "жестких" полей (если они есть) --}}
                    @php 
                        $details = $listing->productDetails 
                            ?? $listing->serviceDetails 
                            ?? $listing->jobDetails 
                            ?? $listing->personDetails 
                            ?? $listing->assetDetails; 
                    @endphp

                    @if($details)
                        {{-- Пример вывода стандартных полей --}}
                        @if(isset($details->brand)) <p><strong>Бренд:</strong> {{ $details->brand }}</p> @endif
                        @if(isset($details->model)) <p><strong>Модель:</strong> {{ $details->model }}</p> @endif
                        @if(isset($details->service_type)) <p><strong>Тип услуги:</strong> {{ $details->service_type }}</p> @endif

                        {{-- 2. Вывод кастомных полей из extra_metadata --}}
                        @if($details->extra_metadata)
                            @foreach($details->extra_metadata as $key => $value)
                                @if($value)
                                    <p>
                                        <strong class="capitalize">{{ str_replace('_', ' ', $key) }}:</strong> 
                                        {{-- Если значение - булево (из чекбокса), выводим Да/Нет --}}
                                        @if(is_bool($value))
                                            {{ $value ? 'Да' : 'Нет' }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </p>
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

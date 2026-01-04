<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-lg font-semibold mb-4">Объявления в категории</h3>
            
            @if($listings->count())
                <div class="grid grid-cols-1 gap-4">
                    @foreach($listings as $listing)
                         <div class="border p-4 rounded shadow flex justify-between items-center">
                            <div>
                                <h4 class="font-bold">{{ $listing->title }}</h4>
                                <p>Цена: {{ number_format($listing->price, 0, ',', ' ') }} ₽</p>
                                <p class="text-sm text-gray-500">
                                    {{ $listing->location->name ?? 'Город не указан' }}
                                </p>
                            </div>
                            <a href="{{ route('listings.show', $listing) }}" class="font-bold py-2 px-4 rounded">
                                Посмотреть
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $listings->links() }}
                </div>
            @else
                <p>В этой категории пока нет объявлений.</p>
            @endif
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Каталог объявлений') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            {{-- Блок Категорий --}}
            <div class="w-1/4 pr-4">
                <h3 class="text-lg font-semibold mb-4">Категории</h3>
                <ul>

                    @foreach($categoriesByType as $type => $group)
                        <div class="mb-8">
                            <h2 class="text-xl font-bold uppercase text-gray-700 border-b mb-4">
                                {{ $type === 'product' ? 'Товары' : ($type === 'service' ? 'Услуги' : 'Прочее') }}
                            </h2>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($group as $mainCategory)
                                    <div class="mb-4">
                                        <a href="{{ route('category.show', $mainCategory->slug) }}" class="font-semibold text-blue-600">
                                            {{ $mainCategory->name }}
                                        </a>
                                        <ul class="text-sm text-gray-500 mt-1">
                                            @foreach($mainCategory->children as $child)
                                                <li><a href="{{ route('category.show', $child->slug) }}" class="hover:underline">{{ $child->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </ul>
                <a href="{{ route('listings.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Создать объявление
                </a>
            </div>

            {{-- Блок Последних объявлений --}}
            <div class="w-3/4">
                <h3 class="text-lg font-semibold mb-4">Последние объявления</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($latestListings as $listing)
                        <div class="border p-4 rounded shadow">
                            <h4 class="font-bold">{{ $listing->title }}</h4>
                            <p>Цена: {{ number_format($listing->price, 0, ',', ' ') }} ₽</p>
                                <p class="text-sm text-gray-500">
                                    {{ $listing->location->name ?? 'Город не указан' }}
                                    | Тип: {{ $listing->category->type }}
                                </p>
                            {{-- Пример вывода атрибута товара --}}
                            @if($listing->productDetails)
                                <p class="text-sm">Бренд: {{ $listing->productDetails->brand }}</p>
                            @endif
                            <a href="#" class="text-blue-500 hover:underline">Подробнее</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

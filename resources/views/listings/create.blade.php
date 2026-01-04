<x-app-layout>
    <div class="py-12" x-data="listingForm()">
        <div class="max-w-3xl mx-auto p-8 rounded shadow">
            <h2 class="text-2xl font-bold mb-6">Создать объявление</h2>

            {{-- Блок вывода ошибок --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <strong>Ошибка!</strong> Проверьте следующие поля:
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('listings.store') }}" method="POST">
                @csrf

                <!-- Выбор категории -->
                <div class="mb-4">
                    <label class="block font-bold">Категория</label>
                    <select name="category_id" 
                            class="w-full border-gray-300 rounded" 
                            @change="updateCategory($event)"
                            required>
                        <option value="">-- Выберите --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    data-type="{{ $category->type }}"
                                    data-settings='@json($category->settings ?? [])'>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Поле ЦЕНА (скрывается динамически) -->
                <div class="mb-4" x-show="!settings.hide_price" x-cloak>
                    <label class="block font-bold">Стоимость (₽)</label>
                    <input type="number" name="price" class="w-full border-gray-300 rounded" :required="!settings.hide_price">
                </div>

                <!-- Поле ЛОКАЦИЯ (скрывается динамически) -->
                <div class="mb-4" x-show="!settings.hide_location" x-cloak>
                    <label class="block font-bold">Локация</label>
                    <!--
                    <select name="location_id" class="w-full border-gray-300 rounded" :required="!settings.hide_location">
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    //-->
                    <select name="location_id" class="w-full border-gray-300 rounded" :required="!settings.hide_location">
                        @foreach($locations as $region)
                            <optgroup label="{{ $region->name }}">
                                @foreach($region->children as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <!-- ДИНАМИЧЕСКИЕ КАСТОМНЫЕ ПОЛЯ (из тегов Filament) -->
                <template x-for="field in settings.custom_fields" :key="field">
                    <div class="mb-4 bg-blue-50 p-2 rounded border border-blue-100">
                        <label class="block font-bold text-blue-800" x-text="field.charAt(0).toUpperCase() + field.slice(1).replace('_', ' ')"></label>
                        <input type="text" :name="field" class="w-full border-gray-300 rounded" :placeholder="'Введите ' + field">
                    </div>
                </template>

                <!-- Стандартные блоки типов (Product, Service и т.д.) -->
                <div x-show="type === 'product'" class="p-4 bg-gray-50 mb-4 rounded" x-cloak>
                    <input type="text" name="brand" placeholder="Бренд" class="w-full border-gray-300 rounded mb-2">
                    <input type="text" name="model" placeholder="Модель" class="w-full border-gray-300 rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Заголовок</label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Описание</label>
                    <textarea name="description" rows="5" class="w-full border-gray-300 rounded" required></textarea>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Опубликовать</button>
            </form>
        </div>
    </div>

    <script>
        function listingForm() {
            return {
                type: '',
                settings: {},
                updateCategory(e) {
                    const option = e.target.options[e.target.selectedIndex];
                    this.type = option.dataset.type || '';
                    this.settings = JSON.parse(option.dataset.settings || '{}');
                    
                    // Если поле скрыто, обнуляем значение (чтобы не ушло в базу случайно)
                    if (this.settings.hide_price) {
                        document.getElementsByName('price')[0].value = 0;
                    }
                }
            }
        }
    </script>
    <style> [x-cloak] { display: none !important; } </style>
</x-app-layout>

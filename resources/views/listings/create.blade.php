<x-app-layout>
    <div class="py-12">
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

                {{-- Общие обязательные поля --}}
                <div class="mb-4">
                    <label class="block font-bold">Категория</label>
                    <select name="category_id" id="category-select" class="w-full border-gray-300 rounded" required>
                        <option value="">-- Выберите категорию --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-type="{{ $category->type }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Заголовок</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Стоимость (₽)</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="w-full border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Город / Локация</label>
                    <select name="location_id" class="w-full border-gray-300 rounded" required>
                        <option value="">-- Выберите город --</option>
                        @foreach($locations as $location)
                            @if($location->children->count() > 0)
                                <optgroup label="{{ $location->name }}">
                                    @foreach($location->children as $child)
                                        <option value="{{ $child->id }}" {{ old('location_id') == $child->id ? 'selected' : '' }}>
                                            {{ $child->name }}
                                        </li>
                                    @endforeach
                                </optgroup>
                            @else
                                <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Описание</label>
                    <textarea name="description" rows="5" class="w-full border-gray-300 rounded" required>{{ old('description') }}</textarea>
                </div>

                {{-- Динамические блоки --}}
                
                <!-- ТОВАРЫ -->
                <div id="fields-product" class="extra-fields hidden bg-gray-50 p-4 mb-4 rounded border">
                    <h3 class="font-bold mb-2">Характеристики товара</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="brand" value="{{ old('brand') }}" placeholder="Бренд" class="border-gray-300 rounded">
                        <input type="text" name="model" value="{{ old('model') }}" placeholder="Модель" class="border-gray-300 rounded">
                    </div>
                </div>

                <!-- УСЛУГИ -->
                <div id="fields-service" class="extra-fields hidden bg-gray-50 p-4 mb-4 rounded border">
                    <h3 class="font-bold mb-2">Детали услуги</h3>
                    <select name="service_type" class="w-full border-gray-300 rounded mb-2">
                        <option value="online" {{ old('online') == $location->id ? 'selected' : '' }}>Онлайн</option>
                        <option value="offline" {{ old('offline') == $location->id ? 'selected' : '' }}>Очно</option>
                    </select>
                    <input type="text" name="access_info" value="{{ old('access_info') }}" placeholder="Ссылка на курс или адрес" class="w-full border-gray-300 rounded">
                </div>

                <!-- РАБОТА -->
                <div id="fields-job" class="extra-fields hidden bg-gray-50 p-4 mb-4 rounded border">
                    <h3 class="font-bold mb-2">Вакансия / Резюме</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" name="salary_from" value="{{ old('salary_from') }}" placeholder="Зарплата от" class="border-gray-300 rounded">
                        <input type="text" name="experience_years" value="{{ old('experience_years') }}" placeholder="Опыт (лет)" class="border-gray-300 rounded">
                    </div>
                </div>

                <!-- ЗНАКОМСТВА -->
                <div id="fields-person" class="extra-fields hidden bg-gray-50 p-4 mb-4 rounded border">
                    <h3 class="font-bold mb-2">О себе</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <select name="gender" class="border-gray-300 rounded">
                            <option value="male" {{ old('male') == $location->id ? 'selected' : '' }}>Мужчина</option>
                            <option value="female" {{ old('female') == $location->id ? 'selected' : '' }}>Женщина</option>
                        </select>
                        <input type="number" name="age" value="{{ old('age') }}" placeholder="Возраст" class="border-gray-300 rounded">
                        <input type="number" name="height" value="{{ old('height') }}" placeholder="Рост" class="border-gray-300 rounded">
                        <input name="pizhama" value="{{ old('pizhama') }}" placeholder="Любимая пижама" class="border-gray-300 rounded">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-6 py-2 rounded">Опубликовать</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const categorySelect = document.getElementById('category-select');
        const extraFields = document.querySelectorAll('.extra-fields');

        function updateFields() {
            extraFields.forEach(el => el.classList.add('hidden'));
            const selected = categorySelect.options[categorySelect.selectedIndex];
            const type = selected.getAttribute('data-type');
            if (type) {
                const target = document.getElementById('fields-' + type);
                if (target) target.classList.remove('hidden');
            }
        }

        categorySelect.addEventListener('change', updateFields);
        // Запускаем при загрузке (если форма вернулась с ошибками, но категория выбрана)
        window.onload = updateFields;
    </script>
</x-app-layout>

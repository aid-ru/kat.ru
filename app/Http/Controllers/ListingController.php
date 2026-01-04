<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function store(Request $request)
    {
        $category = Category::findOrFail($request->category_id);
        // 1. Валидируем только ОБЩИЕ поля. 
        // Кастомные поля не валидируем жестко, чтобы не блокировать отправку.
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'description' => 'required|string|min:5',
            'price'       => ($category->settings['hide_price'] ?? false) ? 'nullable' : 'required|numeric|min:0',
        ]);

        try {
            $listing = DB::transaction(function () use ($request, $category) {
                // 2. Создаем базу
                $newListing = Listing::create([
                    'user_id'     => auth()->id(),
                    'category_id' => $category->id,
                    'location_id' => $request->location_id,
                    'title'       => $request->title,
                    'description' => $request->description,
                    'price'       => $request->input('price', 0),
                ]);

                // 3. Список ВСЕХ стандартных полей (которые мы НЕ хотим в extra_metadata)
                $systemFields = ['_token', '_method', 'title', 'price', 'description', 'location_id', 'category_id', 'condition'];

                // Собираем ВСЕ стандартные поля всех существующих типов деталей
                $allStandardAttributes = [
                    'brand', 'model', 'color', 'size', 'material', // products
                    'service_type', 'duration_unit', 'access_info', // services
                    'job_type', 'salary_from', 'salary_to', 'experience_years', // jobs
                    'gender', 'age', 'relationship_goal', 'height', 'education' // person
                ];

                // 4. Поля, специфичные именно для ЭТОЙ категории (жесткие колонки)
                $currentTypeFields = match($category->type) {
                    'product' => ['brand', 'model', 'color', 'size'],
                    'service' => ['service_type', 'duration_unit', 'access_info'],
                    'job'     => ['job_type', 'salary_from', 'salary_to', 'experience_years'],
                    'person'  => ['gender', 'age', 'relationship_goal', 'height'],
                    default   => [],
                };

                // 5. СОБИРАЕМ EXTRA_METADATA
                // Берем ВСЕ данные из запроса
                $extra = $request->all();

                // Удаляем системные поля
                foreach ($systemFields as $field) { unset($extra[$field]); }

                // Удаляем ВООБЩЕ ВСЕ стандартные атрибуты всех категорий
                foreach ($allStandardAttributes as $field) { unset($extra[$field]); }

                // Очищаем от пустых значений
                $extra = array_filter($extra, fn($value) => !is_null($value) && $value !== '');

                // 6. Сохраняем детали
                $detailsData = array_merge(
                    $request->only($currentTypeFields),
                    ['extra_metadata' => $extra]
                );

                match($category->type) {
                    'product' => $newListing->productDetails()->create($detailsData),
                    'service' => $newListing->serviceDetails()->create($detailsData),
                    'job'     => $newListing->jobDetails()->create($detailsData),
                    'person'  => $newListing->personDetails()->create($detailsData),
                    'asset'   => $newListing->assetDetails()->create($detailsData),
                };

                return $newListing;
            });

            return redirect()->route('listings.show', $listing->id)
                            ->with('success', 'Объявление успешно опубликовано!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Ошибка базы данных: ' . $e->getMessage()]);
        }
    }

    public function index()
    {
        // Оптимизированная загрузка всех типов деталей
        $listings = Listing::with(['category', 'productDetails', 'serviceDetails']) // Загружаем детали одним запросом (Eager Loading)
            ->where('status', 'active')
            ->latest()
            ->simplePaginate(20); // Оптимально для больших таблиц (не делает лишний COUNT)

        return view('listings.index', compact('listings'));
    }

    public function create() {
        // Получаем только основные категории для выбора
        $categories = Category::orderBy('sort_order')->get();
        //$locations = Location::orderBy('name')->get();
        $locations = Location::whereNull('parent_id')->with('children')->get();
        return view('listings.create', compact('categories' ,'locations'));
    }

    public function show(Listing $listing)
    {
        // Загружаем все возможные детали, чтобы Blade мог их отобразить
        $listing->load(['category', 'location', 'productDetails', 'serviceDetails', 'jobDetails', 'personDetails']);
        
        return view('listings.show', compact('listing'));
    }

}

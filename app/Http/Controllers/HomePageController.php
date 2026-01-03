<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        // Получаем категории, группируя их по типу для дерева
        $categoriesByType = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('type');

        // Получаем локации (корневые регионы с городами) для фильтра или формы
        $locations = Location::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        // Получаем несколько последних объявлений для главной
        $latestListings = Listing::with(['category', 'location'])
            ->where('status', 'active')
            ->latest()
            ->take(10)
            ->get();

        return view('home', compact('categoriesByType', 'latestListings', 'locations'));
    }

    public function category_old($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Получаем объявления текущей категории и всех её подкатегорий
        $listings = Listing::whereHas('category', function ($query) use ($category) {
            // Для высоконагруженного сайта нужно оптимизировать получение всех ID подкатегорий
            // Сейчас используем простой способ
            $categoryIds = $category->children->pluck('id')->push($category->id);
            $query->whereIn('id', $categoryIds);
        })
        ->with('productDetails')
        ->where('status', 'active')
        ->simplePaginate(20);

        return view('listings.category', compact('category', 'listings'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $listings = Listing::where('category_id', $category->id)
            ->with(['location', 'productDetails'])
            ->where('status', 'active')
            ->simplePaginate(20);

        return view('listings.category', compact('category', 'listings'));
    }
}

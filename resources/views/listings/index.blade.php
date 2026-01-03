<x-app-layout>
    <x-slot name="header"><h2 class="text-xl">Все объявления</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                @foreach($listings as $listing)
                    <div class="border-b py-2">
                        <p class="font-bold">{{ $listing->title }} - {{ $listing->price }} ₽</p>
                    </div>
                @endforeach
                <div class="mt-4">{{ $listings->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

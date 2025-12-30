<x-app-layout>
    <x-slot name="header">
        <h2 class="h2_header">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="kat_div_center">
        <div class="kat_div_margin">
            <div class="kat_div_bg">
                <div class="kat_div_inner">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

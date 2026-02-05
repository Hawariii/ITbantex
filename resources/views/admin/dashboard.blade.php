<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    {{-- Content --}}
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Total Items --}}
                <div class="bg-white shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Total Items
                    </h3>
                    <p class="text-3xl font-bold mt-2">
                        {{ $totalItems }}
                    </p>
                </div>

                {{-- Pending Requests --}}
                <div class="bg-white shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Pending Stock Requests
                    </h3>
                    <p class="text-3xl font-bold mt-2 text-red-600">
                        {{ $pendingRequests }}
                    </p>
                </div>

            </div>

            {{-- Quick Access --}}
            <div class="mt-10 bg-white shadow  p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Quick Menu
                </h3>

                <div class="flex flex-col gap-3">

                    <a href="{{ route('admin.item-master.index') }}"
                        class="px-4 py-3 rounded bg-gray-100 hover:bg-gray-200 transition">
                        Manage Item Master
                    </a>

                    @if (Route::has('admin.stock.index'))
                        <a href="{{ route('admin.stock.index') }}"
                            class="px-4 py-3 rounded bg-gray-100 hover:bg-gray-200 transition">
                            Stock Transaction Requests
                        </a>
                    @else
                        <a href="#"
                            class="px-4 py-3 rounded bg-gray-100 opacity-50 cursor-not-allowed transition"
                            aria-disabled="true">
                            Stock Transaction Requests
                        </a>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
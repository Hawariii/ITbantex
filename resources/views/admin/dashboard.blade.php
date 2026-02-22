<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                Admin Dashboard
            </h2>

            <span class="text-sm text-gray-500">
                {{ now()->format('l, d F Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- TOTAL ITEMS --}}
                <div class="bg-white rounded-2xl shadow-sm border p-6 hover:shadow-md transition">
                    <div class="text-sm text-gray-500">
                        Total Items
                    </div>
                    <div class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $totalItems }}
                    </div>
                </div>

                {{-- PENDING REQUEST --}}
                <div class="bg-white rounded-2xl shadow-sm border p-6 hover:shadow-md transition">
                    <div class="text-sm text-gray-500">
                        Pending Stock Requests
                    </div>
                    <div class="mt-2 text-3xl font-bold text-red-600">
                        {{ $pendingRequests }}
                    </div>
                </div>

                {{-- LOW STOCK (OPTIONAL IF ADA DATA) --}}
                <div class="bg-white rounded-2xl shadow-sm border p-6 hover:shadow-md transition">
                    <div class="text-sm text-gray-500">
                        Low Stock Items
                    </div>
                    <div class="mt-2 text-3xl font-bold text-yellow-600">
                        {{ $lowStock ?? 0 }}
                    </div>
                </div>

            </div>


            {{-- QUICK ACTION PANEL --}}
            <div class="bg-white rounded-2xl shadow-sm border p-8">

                <h3 class="text-lg font-semibold text-gray-800 mb-6">
                    Quick Menu
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <a href="{{ route('admin.item-master.index') }}"
                        class="group p-6 rounded-xl border hover:bg-gray-50 transition flex justify-between items-center">

                        <div>
                            <div class="font-semibold text-gray-800">
                                Manage Item Master
                            </div>
                            <div class="text-sm text-gray-500 mt-1">
                                Lihat dan sync data stock dari Excel
                            </div>
                        </div>

                        <div class="text-gray-400 group-hover:translate-x-1 transition">
                            →
                        </div>

                    </a>


                    @if (Route::has('admin.stock.index'))
                        <a href="{{ route('admin.stock.index') }}"
                            class="group p-6 rounded-xl border hover:bg-gray-50 transition flex justify-between items-center">

                            <div>
                                <div class="font-semibold text-gray-800">
                                    Stock Transaction Requests
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    Approve atau reject permintaan barang
                                </div>
                            </div>

                            <div class="text-gray-400 group-hover:translate-x-1 transition">
                                →
                            </div>

                        </a>
                    @else
                        <div class="p-6 rounded-xl border bg-gray-50 opacity-60 cursor-not-allowed">
                            <div class="font-semibold text-gray-500">
                                Stock Transaction Requests
                            </div>
                            <div class="text-sm text-gray-400 mt-1">
                                Module belum tersedia
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
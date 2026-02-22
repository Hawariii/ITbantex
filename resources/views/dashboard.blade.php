<x-app-layout>

<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-7xl mx-auto px-6 space-y-8">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Dashboard Bantex
                </h1>
                <p class="text-gray-500 text-sm">
                    Ringkasan aktivitas permintaan barang
                </p>
            </div>

            <a href="{{ route('permintaan.create') }}"
               class="px-5 py-3 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition">
                + Tambah Permintaan
            </a>
        </div>


        <!-- SUMMARY CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <p class="text-sm text-gray-500">Total Permintaan</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $data->count() }}
                </h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <p class="text-sm text-gray-500">Total Item</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $data->sum('jumlah') }}
                </h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <p class="text-sm text-gray-500">Total Nominal</p>
                <h2 class="text-3xl font-bold text-indigo-600 mt-2">
                    Rp {{ number_format($data->sum('total')) }}
                </h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <p class="text-sm text-gray-500">Supplier Aktif</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $data->unique('supplier')->count() }}
                </h2>
            </div>

        </div>


        <!-- TABLE SECTION -->
        <div class="bg-white rounded-2xl shadow-lg p-8">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    Permintaan Terbaru
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">

                    <thead>
                        <tr class="border-b text-gray-500 text-left">
                            <th class="py-3 px-4">Nama Barang</th>
                            <th class="py-3 px-4">Merk</th>
                            <th class="py-3 px-4 text-center">Jumlah</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4">Supplier</th>
                            <th class="py-3 px-4">Arrival</th>
                            <th class="py-3 px-4">Created</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse ($data as $row)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="py-3 px-4 font-medium text-gray-800">
                                {{ $row->nama_barang }}
                            </td>

                            <td class="py-3 px-4 text-gray-600">
                                {{ $row->merk_type }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                {{ $row->jumlah }}
                            </td>

                            <td class="py-3 px-4 text-gray-600">
                                Rp {{ number_format($row->harga_satuan) }}
                            </td>

                            <td class="py-3 px-4 font-semibold text-indigo-600">
                                Rp {{ number_format($row->total) }}
                            </td>

                            <td class="py-3 px-4">
                                {{ $row->supplier }}
                            </td>

                            <td class="py-3 px-4">
                                {{ \Carbon\Carbon::parse($row->arrival_date)->format('d M Y') }}
                            </td>

                            <td class="py-3 px-4 text-gray-500">
                                {{ $row->created_at->format('d M Y') }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-gray-400">
                                Belum ada permintaan barang
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

    </div>
</div>

</x-app-layout>
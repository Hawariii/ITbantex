<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 space-y-6">

        <!-- Header -->
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                Dashboard ITbantex
            </h1>
            <p class="text-gray-500 text-sm">
                Ringkasan permintaan barang Anda
            </p>
        </div>

        <!-- Table -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    Permintaan Barang
                </h2>

                <a href="{{ route('permintaan.create') }}"
                   class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                    + Tambah Permintaan
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-3 py-2 border">Nama</th>
                            <th class="px-3 py-2 border">Merk</th>
                            <th class="px-3 py-2 border">Jumlah</th>
                            <th class="px-3 py-2 border">Harga</th>
                            <th class="px-3 py-2 border">Total</th>
                            <th class="px-3 py-2 border">Supplier</th>
                            <th class="px-3 py-2 border">Arrival</th>
                            <th class="px-3 py-2 border">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border">{{ $row->nama_barang }}</td>
                            <td class="px-3 py-2 border">{{ $row->merk_type }}</td>
                            <td class="px-3 py-2 border text-center">{{ $row->jumlah }}</td>
                            <td class="px-3 py-2 border">{{ number_format($row->harga_satuan) }}</td>
                            <td class="px-3 py-2 border font-semibold">
                                {{ number_format($row->total) }}
                            </td>
                            <td class="px-3 py-2 border">{{ $row->supplier }}</td>
                            <td class="px-3 py-2 border">{{ $row->arrival_date }}</td>
                            <td class="px-3 py-2 border">
                                {{ $row->created_at->format('d-m-Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">
                                Belum ada permintaan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>

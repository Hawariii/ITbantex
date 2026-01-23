<x-app-layout>
<div class="max-w-7xl mx-auto py-8 space-y-6">

    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">
                Detail History Export
            </h1>
            <p class="text-sm text-gray-500">
                Doc No: <span class="font-medium text-gray-700">{{ $export->doc_no }}</span>
            </p>
            <p class="text-sm text-gray-500">
                Exported: <span class="text-gray-700">{{ optional($export->exported_at)->format('d/m/Y H:i') }}</span>
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('history.index') }}"
               class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100 transition">
                Kembali
            </a>

            <form method="POST" action="{{ route('history.reprint', $export->id) }}">
                @csrf
                <button type="submit"
                        class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100 transitions">
                    Reprint Excel
                </button>
            </form>
        </div>
    </div>

    <!-- Summary -->
    <div class="bg-white shadow rounded-lg p-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <p class="text-xs text-gray-500">Lokasi</p>
            <p class="font-semibold text-gray-800">{{ $export->lokasi }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Item Count</p>
            <p class="font-semibold text-gray-800">{{ $export->item_count }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Grand Total</p>
            <p class="font-semibold text-gray-800">{{ number_format($export->grand_total) }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">User</p>
            <p class="font-semibold text-gray-800">{{ $export->user_id }}</p>
        </div>
    </div>

    <!-- Table Detail -->
    <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
        <table class="min-w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-3 py-2 text-center">No</th>
                    <th class="border px-3 py-2">Nama</th>
                    <th class="border px-3 py-2">Merk/Type</th>
                    <th class="border px-3 py-2 text-center">Jumlah</th>
                    <th class="border px-3 py-2">Harga</th>
                    <th class="border px-3 py-2">Total</th>
                    <th class="border px-3 py-2">Supplier</th>
                    <th class="border px-3 py-2">Arrival</th>
                    <th class="border px-3 py-2">Keterangan</th>
                </tr>
            </thead>

            <tbody>
            @forelse($export->items as $i => $row)
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2 text-center">{{ $i + 1 }}</td>
                    <td class="border px-3 py-2">{{ $row->nama_barang }}</td>
                    <td class="border px-3 py-2">{{ $row->merk_type }}</td>
                    <td class="border px-3 py-2 text-center">{{ $row->jumlah }}</td>
                    <td class="border px-3 py-2">{{ number_format($row->harga_satuan) }}</td>
                    <td class="border px-3 py-2 font-semibold">{{ number_format($row->total) }}</td>
                    <td class="border px-3 py-2">{{ $row->supplier }}</td>
                    <td class="border px-3 py-2">{{ $row->arrival_date }}</td>
                    <td class="border px-3 py-2">{{ $row->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-gray-500">
                        Tidak ada item
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>

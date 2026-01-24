<x-app-layout>
<div class="max-w-7xl mx-auto py-8 space-y-6">

    <!-- Header -->
    <div class="bg-white shadow rounded-2xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <p class="text-xs text-gray-500">Detail History Export</p>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Doc No: {{ $export->doc_no }}
                </h1>

                <div class="mt-2 flex flex-wrap gap-2 text-sm">
                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs">
                        Exported:
                        <span class="font-semibold text-gray-800">
                            {{ optional($export->exported_at)->format('d/m/Y H:i') ?? optional($export->created_at)->format('d/m/Y H:i') }}
                        </span>
                    </span>

                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs">
                        Export ID:
                        <span class="font-semibold text-gray-800">#{{ $export->id }}</span>
                    </span>
                </div>
            </div>

            <div class="flex gap-2 flex-wrap justify-end">
                <a href="{{ route('history.index') }}"
                   class="px-4 py-2 rounded-lg border text-sm text-gray-700 hover:bg-gray-100 transition">
                    Kembali
                </a>

                <a href="{{ route('history.reprint', $export->id) }}"
                   class="px-4 py-2 rounded-lg bg-green-600 text-white text-sm hover:bg-green-700 transition">
                    Reprint
                </a>

                <form method="POST" action="{{ route('history.destroy', $export->id) }}"
                      onsubmit="return confirm('Yakin mau hapus history export Doc No: {{ $export->doc_no }} ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Content -->
    <div class="bg-white shadow rounded-2xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Daftar Item</h2>
                <p class="text-sm text-gray-500">
                    Ini adalah snapshot hasil export (untuk reprint monitoring).
                </p>
            </div>

            <div class="text-sm text-gray-700">
                Total Item:
                <span class="font-semibold text-gray-900">
                    {{ $export->items->count() }}
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-3 py-2 text-center">No</th>
                        <th class="border px-3 py-2 text-left">Nama</th>
                        <th class="border px-3 py-2 text-left">Merk</th>
                        <th class="border px-3 py-2 text-center">Jumlah</th>
                        <th class="border px-3 py-2 text-right">Harga</th>
                        <th class="border px-3 py-2 text-right">Total</th>
                        <th class="border px-3 py-2 text-left">Supplier</th>
                        <th class="border px-3 py-2 text-left">Arrival</th>
                        <th class="border px-3 py-2 text-left">Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                @php $grandTotal = 0; @endphp

                @forelse ($export->items as $i => $item)
                    @php $grandTotal += $item->total; @endphp

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">{{ $i + 1 }}</td>
                        <td class="border px-3 py-2 font-medium text-gray-900">{{ $item->nama_barang }}</td>
                        <td class="border px-3 py-2 text-gray-700">{{ $item->merk_type }}</td>
                        <td class="border px-3 py-2 text-center">{{ $item->jumlah }}</td>
                        <td class="border px-3 py-2 text-right">{{ number_format($item->harga_satuan) }}</td>
                        <td class="border px-3 py-2 text-right font-semibold">{{ number_format($item->total) }}</td>
                        <td class="border px-3 py-2">{{ $item->supplier }}</td>
                        <td class="border px-3 py-2">{{ $item->arrival_date }}</td>
                        <td class="border px-3 py-2">{{ $item->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="border px-3 py-6 text-center text-gray-500">
                            Tidak ada item di history export ini.
                        </td>
                    </tr>
                @endforelse
                </tbody>

                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="5" class="border px-3 py-3 text-right font-semibold text-gray-700">
                            Grand Total
                        </td>
                        <td class="border px-3 py-3 text-right font-semibold text-gray-900">
                            {{ number_format($grandTotal) }}
                        </td>
                        <td colspan="3" class="border px-3 py-3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

</div>
</x-app-layout>

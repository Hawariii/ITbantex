<x-app-layout>
<div class="max-w-7xl mx-auto py-8 space-y-8">

    <!-- Page Header -->
    <div class="bg-white rounded-2xl shadow-sm border p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">
            History Export
        </h1>
        
        <p class="text-sm text-gray-500 mt-1">
            Riwayat export permintaan barang yang telah diproses
        </p>
    </div>

    <!-- Export List -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-6 space-y-6">

        @forelse ($exports as $export)

        <div class="border border-gray-200 rounded-xl overflow-hidden bg-white">

            <!-- Header -->
            <div class="flex justify-between items-center px-6 py-4 bg-gray-50 hover:bg-gray-100 transition cursor-pointer"
                 onclick="toggleDetails('export-{{ $export->id }}')">

                <div class="text-sm text-gray-700 flex flex-wrap gap-6">
                    <div>
                        <span class="font-semibold">Doc:</span>
                        {{ $export->doc_no }}
                    </div>

                    <div>
                        <span class="font-semibold">Tanggal:</span>
                        {{ $export->exported_at->format('d-m-Y H:i') }}
                    </div>

                    <div>
                        <span class="font-semibold">Items:</span>
                        {{ $export->items->count() }}
                    </div>

                    <div class="text-blue-600 font-semibold">
                        Total: {{ number_format($export->items->sum('total')) }}
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('history.reprint', $export->id) }}"
                       onclick="event.stopPropagation()"
                       class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        Reprint
                    </a>

                    <button onclick="event.stopPropagation(); deleteExport({{ $export->id }})"
                            class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Delete
                    </button>
                </div>
            </div>

            <!-- Detail -->
            <div id="export-{{ $export->id }}"
                 class="hidden px-6 py-6 bg-white border-t border-gray-200">

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">

                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Merk</th>
                                <th class="px-4 py-3 text-center">Jumlah</th>
                                <th class="px-4 py-3 text-left">Harga</th>
                                <th class="px-4 py-3 text-left">Total</th>
                                <th class="px-4 py-3 text-left">Supplier</th>
                                <th class="px-4 py-3 text-left">Arrival</th>
                                <th class="px-4 py-3 text-left">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($export->items as $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-4 py-3">{{ $item->nama_barang }}</td>
                                <td class="px-4 py-3">{{ $item->merk_type }}</td>
                                <td class="px-4 py-3 text-center">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3">{{ number_format($item->harga_satuan) }}</td>
                                <td class="px-4 py-3 font-semibold">{{ number_format($item->total) }}</td>
                                <td class="px-4 py-3">{{ $item->supplier }}</td>
                                <td class="px-4 py-3">{{ $item->arrival_date }}</td>
                                <td class="px-4 py-3">{{ $item->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                @php
                    $subtotal = $export->items->sum('total');
                @endphp

                <div class="flex justify-end mt-6">
                    <div class="text-right">
                        <p class="text-xs text-gray-400 uppercase">Total</p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ number_format($subtotal) }}
                        </p>
                    </div>
                </div>

            </div>
        </div>

        @empty
            <p class="text-center text-gray-500 py-8">
                Belum ada history export
            </p>
        @endforelse

    </div>
</div>

<!-- Delete Forms -->
@foreach ($exports as $export)
<form id="delete-{{ $export->id }}"
      action="{{ route('history.destroy', $export->id) }}"
      method="POST"
      class="hidden">
    @csrf
    @method('DELETE')
</form>
@endforeach

<script>
function toggleDetails(id) {
    const el = document.getElementById(id);
    el.classList.toggle('hidden');
}

function deleteExport(id) {
    if (confirm('Yakin ingin menghapus history ini?')) {
        document.getElementById('delete-' + id).submit();
    }
}
</script>

</x-app-layout>
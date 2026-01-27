<x-app-layout>
<div class="max-w-7xl mx-auto py-8 space-y-6">

    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800">History Export</h1>
        <p class="text-gray-500 text-sm">Daftar export permintaan barang yang sudah dilakukan</p>
    </div>

    <!-- Export Table -->
    <div class="bg-white shadow rounded-lg p-6 space-y-4">
        @forelse ($exports as $export)
        <div class="border rounded-lg overflow-hidden mb-6">

            <!-- Header Export -->
            <div class="flex justify-between items-center px-4 py-2 bg-gray-100 cursor-pointer hover:bg-gray-200"
                 onclick="toggleDetails('export-{{ $export->id }}')">
                <div>
                    <span class="font-semibold">Doc No:</span> {{ $export->doc_no }} |
                    <span class="font-semibold">Tanggal Export:</span> {{ $export->exported_at->format('d-m-Y H:i') }} |
                    <span class="font-semibold">Items:</span> {{ $export->items->count() }}
                </div>
                <div class="flex justify-between items-center px-4 py-3 bg-gray-100 cursor-pointer hover:bg-gray-200"
                onclick="toggleDetails('export-{{ $export->id }}')">
                    <div class="flex gap-2">
                        <a href="{{ route('history.reprint', $export->id) }}"
                        class="px-3 py-2 border rounded-md text-sm text-gray-700 hover:bg-gray-100"
                        onclick="event.stopPropagation()">
                            Reprint
                        </a>

                        <button onclick="event.stopPropagation(); deleteExport({{ $export->id }})"
                                class="px-3 py-2 bg-red-600 text-white rounded-md text-sm hover:bg-red-700">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
            <!-- Detail Items -->
            <div id="export-{{ $export->id }}" class="hidden px-4 py-3 bg-white border-t">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="border px-3 py-2">Nama</th>
                                <th class="border px-3 py-2">Merk</th>
                                <th class="border px-3 py-2">Jumlah</th>
                                <th class="border px-3 py-2">Harga</th>
                                <th class="border px-3 py-2">Total</th>
                                <th class="border px-3 py-2">Supplier</th>
                                <th class="border px-3 py-2">Arrival</th>
                                <th class="border px-3 py-2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($export->items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-3 py-2">{{ $item->nama_barang }}</td>
                                    <td class="border px-3 py-2">{{ $item->merk_type }}</td>
                                    <td class="border px-3 py-2 text-center">{{ $item->jumlah }}</td>
                                    <td class="border px-3 py-2">{{ number_format($item->harga_satuan) }}</td>
                                    <td class="border px-3 py-2 font-semibold">{{ number_format($item->total) }}</td>
                                    <td class="border px-3 py-2">{{ $item->supplier }}</td>
                                    <td class="border px-3 py-2">{{ $item->arrival_date }}</td>
                                    <td class="border px-3 py-2">{{ $item->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                                    @php
                    $subtotal = $export->items->sum('total');
                @endphp

                <div class="flex items-center gap-6 mt-4">
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Total</p>
                        <p class="text-lg font-bold text-gray-800">
                            {{ number_format($subtotal) }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
        @empty
            <p class="text-center text-gray-500 py-4">Belum ada history export</p>
        @endforelse
    </div>
</div>

<!-- Delete Form (hidden) -->
@foreach ($exports as $export)
<form id="delete-{{ $export->id }}" action="{{ route('history.destroy', $export->id) }}" method="POST" class="hidden">
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

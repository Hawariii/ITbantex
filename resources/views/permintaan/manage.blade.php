<x-app-layout>
<div class="max-w-7xl mx-auto py-8 space-y-6">

    <!-- HEADER -->
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Manage Permintaan Barang
        </h1>
        <p class="text-gray-500 text-sm">
            Data dikelompokkan berdasarkan Document No
        </p>
    </div>

    <!-- LIST DOCUMENT -->
    @forelse ($data as $docNo => $items)
        <div class="bg-white rounded-xl shadow border">

            <!-- SUMMARY ROW -->
            <div class="flex justify-between items-center px-6 py-4 hover:bg-gray-50 transition">
        <!-- LEFT : DOC INFO (toggle) -->
        <div
            class="cursor-pointer"
            onclick="toggleDetail('{{ $docNo }}')"
            >
        <div class="text-lg font-semibold text-gray-800">
            {{ $docNo }}
            </div>
                <div class="text-sm text-gray-500">
                    {{ $items->count() }} item ·
                    Rp {{ number_format($items->sum('total')) }}
                </div>
            </div>
            <!-- RIGHT : ACTIONS -->
        <div class="flex items-center gap-3">
            <!-- PRINT / EXPORT -->
                <form
                method="POST"
                action="{{ route('permintaan.exportExcel') }}"
                onsubmit="event.stopPropagation();"
                >
                @csrf
                <input type="hidden" name="doc_no" value="{{ $docNo }}">

                    <button
                        type="submit"
                        class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100 transition"
                    >
                        Print
                    </button>
                </form>

                <!-- ICON DROPDOWN -->
                <div
                    id="icon-{{ $docNo }}"
                    class="text-gray-500 cursor-pointer transition-transform duration-200"
                    onclick="toggleDetail('{{ $docNo }}')"
                >
                    ▼
                </div>
            </div>
        </div>

            <!-- DETAIL (HIDDEN BY DEFAULT) -->
            <div
                id="detail-{{ $docNo }}"
                class="hidden border-t px-6 py-4 bg-gray-50"
            >
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200 bg-white">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="border px-3 py-2">No</th>
                                <th class="border px-3 py-2">Nama</th>
                                <th class="border px-3 py-2">Merk</th>
                                <th class="border px-3 py-2">Jumlah</th>
                                <th class="border px-3 py-2">Harga</th>
                                <th class="border px-3 py-2">Total</th>
                                <th class="border px-3 py-2">Supplier</th>
                                <th class="border px-3 py-2">Arrival</th>
                                <th class="border px-3 py-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($items as $index => $row)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-3 py-2 text-center">
                                    {{ $index + 1 }}
                                </td>
                                <td class="border px-3 py-2">
                                    {{ $row->nama_barang }}
                                </td>
                                <td class="border px-3 py-2">
                                    {{ $row->merk_type }}
                                </td>
                                <td class="border px-3 py-2 text-center">
                                    {{ $row->jumlah }}
                                </td>
                                <td class="border px-3 py-2">
                                    {{ number_format($row->harga_satuan) }}
                                </td>
                                <td class="border px-3 py-2 font-semibold">
                                    {{ number_format($row->total) }}
                                </td>
                                <td class="border px-3 py-2">
                                    {{ $row->supplier }}
                                </td>
                                <td class="border px-3 py-2">
                                    {{ $row->arrival_date }}
                                </td>
                                <td class="border px-3 py-2 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a
                                            href="{{ route('permintaan.edit', $row->id) }}"
                                            class="px-3 py-1 text-xs rounded bg-gray-800 text-white hover:bg-gray-700"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('permintaan.destroy', $row->id) }}"
                                            onsubmit="return confirm('Hapus item ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="px-3 py-1 text-xs rounded bg-red-600 text-white hover:bg-red-700"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-right mt-4 text-sm font-semibold text-gray-700">
                    Total: Rp {{ number_format($items->sum('total')) }}
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
            Belum ada data permintaan
        </div>
    @endforelse

</div>

<!-- JAVASCRIPT TOGGLE -->
<script>
function toggleDetail(docNo) {
    const detail = document.getElementById('detail-' + docNo);
    const icon   = document.getElementById('icon-' + docNo);

    const isOpen = !detail.classList.contains('hidden');

    if (isOpen) {
        detail.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    } else {
        detail.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    }
}
</script>
</x-app-layout>

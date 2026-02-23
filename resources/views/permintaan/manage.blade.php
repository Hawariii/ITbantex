<x-app-layout>
<div class="max-w-7xl mx-auto py-8 space-y-6">

    {{-- ALERT --}}
    @if(session('error'))
        <div class="flex items-center justify-between bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600">✕</button>
        </div>
    @endif

    @if(session('success'))
        <div class="flex items-center justify-between bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">✕</button>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">
            Manage Permintaan Barang
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            Data dikelompokkan berdasarkan Document Number
        </p>
    </div>

    {{-- LIST DOCUMENT --}}
    @forelse ($data as $docNo => $items)
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden transition hover:shadow-md">

            {{-- SUMMARY --}}
            <div class="flex justify-between items-center px-6 py-5 cursor-pointer"
                 onclick="toggleDetail('{{ $docNo }}')">

                <div>
                    <div class="text-lg font-semibold text-gray-800">
                        {{ $docNo }}
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        {{ $items->count() }} Item
                        • Total:
                        <span class="font-semibold text-gray-700">
                            Rp {{ number_format($items->sum('total')) }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-4">

                    <form method="POST"
                          action="{{ route('permintaan.export') }}"
                          onclick="event.stopPropagation();">
                        @csrf
                        <input type="hidden" name="doc_no" value="{{ $docNo }}">

                        <button type="submit"
                            class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                            Print
                        </button>
                    </form>

                    <div id="icon-{{ $docNo }}"
                         class="text-gray-400 text-xl transition-transform duration-300">
                        ⌄
                    </div>
                </div>
            </div>

            {{-- DETAIL --}}
            <div id="detail-{{ $docNo }}"
                 class="hidden border-t bg-gray-50">

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Merk</th>
                                <th class="px-4 py-3 text-center">Qty</th>
                                <th class="px-4 py-3 text-right">Harga</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-left">Supplier</th>
                                <th class="px-4 py-3 text-left">Arrival</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($items as $index => $row)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $row->nama_barang }}
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $row->merk_type }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $row->jumlah }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    Rp {{ number_format($row->harga_satuan) }}
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-800">
                                    Rp {{ number_format($row->total) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $row->supplier }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $row->arrival_date }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('permintaan.edit', $row->id) }}"
                                           class="px-3 py-1 text-xs bg-gray-800 text-white rounded-md hover:bg-gray-700 transition">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('permintaan.destroy', $row->id) }}"
                                              onsubmit="return confirm('Hapus item ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-xs bg-red-600 text-white rounded-md hover:bg-red-700 transition">
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

                <div class="px-6 py-4 text-right bg-gray-50 border-t">
                    <span class="text-sm text-gray-500">Grand Total :</span>
                    <span class="text-lg font-bold text-gray-800">
                        Rp {{ number_format($items->sum('total')) }}
                    </span>
                </div>

            </div>
        </div>

    @empty
        <div class="bg-white rounded-2xl shadow-sm border p-10 text-center text-gray-500">
            Belum ada data permintaan
        </div>
    @endforelse

</div>

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
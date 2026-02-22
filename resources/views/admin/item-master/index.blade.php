<x-app-layout>
<div class="max-w-7xl mx-auto py-10 px-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Item Master / Stock Barang
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Data otomatis dari file Excel (read-only)
            </p>
        </div>

        <form action="{{ route('admin.item-master.sync') }}" method="POST">
            @csrf
            <button
                type="submit"
                class="px-5 py-2 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition shadow-sm">
                Sync dari Excel
            </button>
        </form>
    </div>

    {{-- SEARCH --}}
    <div class="flex justify-between items-center">
        <input
            type="text"
            id="searchInput"
            placeholder="Cari nama barang / asset / merk..."
            class="w-full md:w-96 px-4 py-2 rounded-xl border-gray-300 focus:ring-2 focus:ring-gray-800/20 focus:border-gray-800 transition text-sm"
        >
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="px-4 py-3 bg-green-100 text-green-700 rounded-xl border">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">No Asset</th>
                        <th class="px-4 py-3 text-left">Nama Barang</th>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Merk</th>
                        <th class="px-4 py-3 text-center">Stock</th>
                        <th class="px-4 py-3 text-center">Min</th>
                        <th class="px-4 py-3 text-center">Max</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                @forelse($items as $index => $item)

                    @php
                        $status = 'normal';
                        if ($item->stock <= $item->stock_min) {
                            $status = 'low';
                        } elseif ($item->stock >= $item->stock_max) {
                            $status = 'over';
                        }
                    @endphp

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-4 py-3">{{ $index + 1 }}</td>

                        <td class="px-4 py-3 font-medium text-gray-700">
                            {{ $item->asset_no }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->nama_barang }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->type }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->merk }}
                        </td>

                        {{-- STOCK BADGE --}}
                        <td class="px-4 py-3 text-center">
                            @if($status == 'low')
                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600 font-semibold">
                                    {{ $item->stock }} (Low)
                                </span>
                            @elseif($status == 'over')
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                    {{ $item->stock }} (Over)
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                    {{ $item->stock }} (Normal)
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $item->stock_min }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $item->stock_max }}
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="8"
                            class="px-6 py-10 text-center text-gray-400">
                            Data item master kosong
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- SEARCH SCRIPT --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(value) ? '' : 'none';
    });
});
</script>

</x-app-layout>
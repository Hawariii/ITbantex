<x-app-layout>
    <div class="px-6 py-6">

        {{-- HEADER --}}
        <div class="bg-white shadow rounded-lg p-6 flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold">Item Master / Stock Barang</h2>
                <p class="text-sm text-gray-500">
                    Data otomatis dari file Excel (read-only)
                </p>
            </div>

            {{-- TOMBOL SYNC --}}
            <form action="{{ route('admin.item-master.sync') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100 transition">
                    Sync dari Excel
                </button>
            </form>
        </div>
        {{-- SEARCH --}}
        <div class="mb-4">
            <input
                type="text"
                id="searchInput"
                placeholder="Cari nama barang / asset / merk..."
                class="w-full md:w-1/3 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300 text-sm"
            >
        </div>
        {{-- ALERT --}}
        @if(session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-3 py-2 border text-left">No</th>
                        <th class="px-3 py-2 border text-left">No Asset</th>
                        <th class="px-3 py-2 border text-left">Nama Barang</th>
                        <th class="px-3 py-2 border text-left">Type</th>
                        <th class="px-3 py-2 border text-left">Merk</th>
                        <th class="px-3 py-2 border text-center">Stock</th>
                        <th class="px-3 py-2 border text-center">Min</th>
                        <th class="px-3 py-2 border text-center">Max</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-3 py-2 border">{{ $item->asset_no }}</td>
                            <td class="px-3 py-2 border">{{ $item->nama_barang }}</td>
                            <td class="px-3 py-2 border">{{ $item->type }}</td>
                            <td class="px-3 py-2 border">{{ $item->merk }}</td>

                            <td class="px-3 py-2 border text-center
                                {{ $item->stock <= $item->stock_min ? 'text-red-600 font-semibold' : '' }}">
                                {{ $item->stock }}
                            </td>

                            <td class="px-3 py-2 border text-center">{{ $item->stock_min }}</td>
                            <td class="px-3 py-2 border text-center">{{ $item->stock_max }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 py-6 text-center text-gray-500">
                                Data item master kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
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
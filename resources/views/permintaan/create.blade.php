<x-app-layout>
<div class="max-w-7xl mx-auto py-8 space-y-6">

    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Tambah Permintaan Barang
        </h1>
        <p class="text-gray-500 text-sm">
            Isi data supplier dan detail barang yang diminta
        </p>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('permintaan.store') }}" class="space-y-6">
            @csrf

            <!-- Supplier & Arrival -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Document No
                </label>

                    <input
                    type="text"
                    name="doc_no"
                    value="{{ old('doc_no') }}"
                    placeholder="Contoh: PR-010126"
                    required
                    class="mt-1 w-full rounded-md border-gray-300 focus:border-gray-800 focus:ring-gray-800">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Supplier</label>
                    <input type="text"
                           name="supplier"
                           required
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-gray-300">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Arrival Date</label>
                    <input type="date"
                           name="arrival_date"
                           required
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-gray-300">
                </div>
            </div>

            <!-- Items -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Detail Barang
                </h3>

                <div id="items" class="space-y-3">
                    <div class="item border rounded-lg p-4 grid grid-cols-1 md:grid-cols-4 gap-3">
                        <input type="text"
                               name="nama_barang[]"
                               placeholder="Nama Barang"
                               class="border rounded px-3 py-2">

                        <input type="text"
                               name="merk_type[]"
                               placeholder="Merk / Type"
                               class="border rounded px-3 py-2">

                        <input type="number"
                               name="jumlah[]"
                               placeholder="Jumlah"
                               class="border rounded px-3 py-2">

                        <input type="text"
                               name="harga_satuan[]"
                               placeholder="Harga Satuan"
                               class="border rounded px-3 py-2">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center">
                <button type="button"
                        onclick="addItem()"
                        class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                    + Tambah Barang
                </button>

                <button type="submit"
                        class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Script -->
<script>
function addItem() {
    const items = document.getElementById('items');
    const clone = items.children[0].cloneNode(true);
    clone.querySelectorAll('input').forEach(i => i.value = '');
    items.appendChild(clone);
}
</script>
</x-app-layout>

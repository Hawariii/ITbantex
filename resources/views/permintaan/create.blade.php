<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                Form Permintaan Barang
            </h2>

            <form method="POST" action="{{ route('permintaan.store') }}" class="space-y-4">
                @csrf
            <div class="item border p-4 mb-3 rounded">
                   <input type="text" name="supplier" placeholder="Supplier" required>
                   <input type="date" name="arrival_date" required>
            </div>

    <div id="items">
        <div class="item border p-4 mb-3 rounded">
            <input type="text" name="nama_barang[]" placeholder="Nama Barang">
            <input type="text" name="merk_type[]" placeholder="Merk / Type">
            <input type="number" name="jumlah[]" placeholder="Jumlah">
            <input type="text" name="harga_satuan[]" placeholder="Harga Satuan">
        </div>
    </div>
                <div class="flex items-center justify-between mt-4">
                     <button type="button" onclick="addItem()" class="pd-4 px-6 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                       + Tambah Barang
                    </button>
                    <button class="px-6 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
<script>
    function addItem() {
    const items = document.getElementById('items');
    const clone = items.children[0].cloneNode(true);
    clone.querySelectorAll('input').forEach(i => i.value = '');
    items.appendChild(clone);
    }
</script>

</x-app-layout>

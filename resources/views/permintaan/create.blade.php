<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                Form Permintaan Barang
            </h2>

            <form method="POST" action="{{ route('permintaan.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-gray-600">Nama Barang</label>
                    <input name="nama_barang" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm text-gray-600">Merk / Type</label>
                    <input name="merk_type" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600">Jumlah</label>
                        <input type="number" name="jumlah" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Harga Satuan</label>
                        <input type="text" name="harga_satuan" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-600">Supplier</label>
                    <input name="supplier" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm text-gray-600">Arrival Date</label>
                    <input type="date" name="arrival_date" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm text-gray-600">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>

                <div class="flex justify-end">
                    <button class="px-6 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

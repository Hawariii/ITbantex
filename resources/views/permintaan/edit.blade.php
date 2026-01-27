<x-app-layout>
<div class="max-w-4xl mx-auto py-8">

    <!-- Header -->
    {{-- <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Edit Permintaan Barang
        </h1>
        <p class="text-sm text-gray-500">
            Perbarui data permintaan barang
        </p>
    </div> --}}

    <!-- Form -->
    <form method="POST" action="{{ route('permintaan.update', $item->id) }}"
          class="bg-white shadow rounded-lg p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Nama Barang
                </label>
                <input type="text" name="nama_barang"
                       value="{{ old('nama_barang', $item->nama_barang) }}"
                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Merk / Type
                </label>
                <input type="text" name="merk_type"
                       value="{{ old('merk_type', $item->merk_type) }}"
                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Jumlah
                </label>
                <input type="number" name="jumlah"
                       value="{{ old('jumlah', $item->jumlah) }}"
                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Harga Satuan
                </label>
                <input type="number" name="harga_satuan"
                       value="{{ old('harga_satuan', $item->harga_satuan) }}"
                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Supplier
                </label>
                <input type="text" name="supplier"
                       value="{{ old('supplier', $item->supplier) }}"
                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-gray-800">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Arrival Date
                </label>
                <input type="date" name="arrival_date"
                       value="{{ old('arrival_date', $item->arrival_date) }}"
                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-gray-800">
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('permintaan.manage') }}"
               class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-100">
                Batal
            </a>

            <button type="submit"
                    class="px-5 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                Update
            </button>
        </div>
    </form>

</div>
</x-app-layout>
